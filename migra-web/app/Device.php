<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use App\Mongoteste;

class Device extends Model
{
    use Searchname, Sortable, SoftDeletes;
    public $sortable = ['name', 'bat', 'created_at', 'volume'];
    protected $fillable = ['name'];

    protected $attributes = [
        'volume' => 0.0,
        'gps' => '',
        'mass_1' => 0.0,
        'mass_2' => 0,
        'mass_3' => 0,
        'mass_4' => 0,
        'ntc' => 0,
        'bat' => 0
    ];

    // ***************************************************************************
    //
    // Atualiza os dados no mysql pegando eles do mongo, e depois retorna o atributo
    //
    // ***************************************************************************/
    public function getDataFromMongo($key)
    {
        //verifica se existe o dispositivo com o serial passado (name)
        if (!is_null($this->name)) {
            $db = DB::connection('mongodb')
                ->collection('mqtt')
                ->get();
            $json = $db->where($this->name)->last();

            if ($json) {
                $timestamp = $json['_id']->getTimestamp();
                date_default_timezone_set('America/Sao_Paulo');
                $data = date('d/m/Y H:i:s (T)', $timestamp);

                if ($key == 'Hora') {
                    return $data;
                } else {
                    $value = $json[$this->name];
                    //muda a chave vinda do mongo para a chave do mysql
                    $newkey = str_replace('Distancia', 'mass_', $key);
                    $this[$newkey] = $value[$key];
                    $this->save();
                    return $value[$key];
                }
            } else {
                return -2; //-2 indica que não há dados de mqtt para esse dispositivo
            }
        }
        return -3; //-3 erro de chamada de key
        //-1 indica que há dados mas são imprecisos
    }

    public function getData($attr)
    {
        //atualiza o mysql com o mongo
        $value = $this->getDataFromMongo($attr);
        //retorna o dado atualizado
        return $value;
    }

    public function updateBatteryPercentageFromMongo()
    {
        $this->getData('bat');
    }

    public function getMqttTimestamp()
    {
        $value = $this->getData('Hora');
        return $value;
    }

    /***********************************************************************
     * Retorna a altura do container
     *
     * @return float
     **********************************************************************/
    public function getHeight()
    {
        //S_x representa o valor medido pelo sensor “x” (dinâmico);
        $S1 = $this->getData('Distancia1');
        $S2 = $this->getData('Distancia2');
        $S3 = $this->getData('Distancia3');
        $S4 = $this->getData('Distancia4');
        // $S1 = 3775;
        // $S2 = 339;
        // $S3 = 162;
        // $S4 = 196;

        //H_x representa a altura do sensor “x” em relação ao chão do container (constante);
        $H1 = 1560;
        $H2 = 1685;
        $H3 = 1650;
        $H4 = 1685;

        //C_x representa o cosseno do ângulo entre o sensor “x” e o chão do container (constante);
        $C1 = 0.4384; // cos(64 graus)
        $C2 = 0.5592; // cos(56 graus)
        $C3 = 0.4384; // cos(64 graus)
        $C4 = 0.5592; // cos(56 graus)

        //P_x representa o peso do sensor “x” em relação ao volume do container (constante);
        $P1 = 0.9531;
        $P2 = 0.5554;
        $P3 = 1;
        $P4 = 0.5537;

        //F representa o fator de conversão de milímetro para metro (constante).
        $F = 1000;

        //Fórmula
        $part1 = ($H1 - $S1 * $C1) * $P1;
        $part2 = ($H2 - $S2 * $C2) * $P2;
        $part3 = ($H3 - $S3 * $C3) * $P3;
        $part4 = ($H4 - $S4 * $C4) * $P4;

        //dividendo / divisor
        $dividend = $part1 + $part2 + $part3 + $part4;
        $divider = ($P1 + $P2 + $P3 + $P4) * $F;

        $height = $dividend / $divider;

        return $height;
    }

    /***********************************************************************
     * Retorna o volume em m³ do container
     *
     * @return float
     **********************************************************************/
    public function getVolume()
    {
        //valores do container
        $width = 2.35;
        $length = 6.5;
        $K = $width * $length;

        $height = $this->getHeight();

        $volume = $height * $K;

        return $volume;
    }

    /***********************************************************************
     * Retorna o peso em toneladas do container
     *
     * @return float
     **********************************************************************/
    public function getWeight()
    {
        $volume = $this->getVolume();
        $density = 1;

        $material = $this->container->activeServiceOrder->material;
        if ($material != null) {
            $density = $material->density;
        }

        $mass = $volume * $density;

        return $mass;
    }

    /***********************************************************************
     * Retorna a temperatura em graus celsius do container
     *
     * @return float
     **********************************************************************/
    public function getTemperature()
    {
        // $NTC = 4066;
        $NTC = $this->getData('ntc');
        $return = -1;

        if ($NTC == -1) {
            $return = $NTC;
        } elseif ($NTC <= 499) {
            $return =
                (-0.0000001352 * pow($NTC, 3) +
                    0.0001734552 * pow($NTC, 2) -
                    0.1129155164 * $NTC +
                    63.3508199252) /
                0.9999429454;
        } elseif ($NTC <= 2299) {
            $return =
                (-18.7471748189 * log($NTC) + 150.4406456301) / 0.9991125453;
        } elseif ($NTC <= 4095) {
            $return = (-0.0080355934 * $NTC + 23.0627134238) / 0.9988680388;
        }

        // return round($return);
        return $return;
    }

    /***********************************************************************
     * Retorna a tensão de bateria do disposito do container
     *
     * @return float
     **********************************************************************/
    public function getBatteryPercentage()
    {
        $BAT = $this->getData('bat');
        $return = -1;

        if ($BAT <= -1) {
            $return = $BAT;
        } elseif ($BAT <= 4095) {
            $return = 0.0029 * $BAT + 1.3568;
        }

        return $return;
    }

    // ***************************************************************************/

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            $model->{'name'} = str_pad(
                $model->{$model->getKeyName()},
                10,
                '0',
                STR_PAD_LEFT
            );
            $model->save();
        });
    }

    public function getPositionAttribute()
    {
        $this->gps = $this->getData('gps');
        $value = explode(',', $this->gps);

        if (sizeof($value) == 2) {
            $this->latitude = $value[0];
            $this->longitude = $value[1];
        }
        $this->save();

        return $this->latitude . ',' . $this->longitude;
    }

    public function getStatusAttribute()
    {
        if ($this->attributes['volume'] > 0.7) {
            return 'FULL';
        } elseif ($this->attributes['volume'] > 0.4) {
            return 'HALFFULL';
        }

        return 'EMPTY';
    }

    public function getColorAttribute()
    {
        if ($this->attributes['volume'] > 0.7) {
            return 'red';
        } elseif ($this->attributes['volume'] > 0.4) {
            return 'yellow';
        }

        return 'green';
    }

    public function modelDevice()
    {
        return $this->belongsTo(ModelDevice::class)->withDefault();
    }

    public function container()
    {
        return $this->belongsTo(Container::class)->withDefault();
    }

    public function scopeFull($query)
    {
        return $query->where('volume', '>', 0.7);
    }

    public function scopeHalfFull($query)
    {
        return $query->where('volume', '>', 0.4)->where('volume', '<=', 0.7);
    }

    public function scopeEmpty($query)
    {
        return $query->where('volume', '<=', 0.4);
    }

    public function scopeLowBattery($query)
    {
        return $query->where('bat', '<=', 819);
    }
}
