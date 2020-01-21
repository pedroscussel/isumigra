<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use Uuids;
    public $incrementing = false;

    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function documentable()
    {
        return $this->morphTo();
    }

    public function containerType()
    {
        return $this->belongsTo(ContainerType::class);
    }

    public function getFilesizeAttribute()
    {
        return self::bytesToHuman($this->attributes['filesize']);
    }

    public function getExtensionIconAttribute()
    {
        $extension = explode("/", $this->attributes['mimetype']);
        return $extension[0];
    }

    public static function getmaxUploadSizeInHuman() {
        return Document::bytesToHuman(Document::getMaxUploadSizeInBytes());
    }

    // Returns a file size limit in bytes based on the PHP upload_max_filesize
    // and post_max_size
    // Para aumentar o limite é preciso alterar no php.ini, exemplo:
    // upload_max_filesize 40M
    // post_max_size 40M
    public static function getMaxUploadSizeInBytes() {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = Document::parseSize(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = Document::parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }

    private static function parseSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }
        else {
            return round($size);
        }
    }

    public static function stripAccents($stripAccents) {
        return strtr(utf8_decode($stripAccents),
            utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
                        'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}
