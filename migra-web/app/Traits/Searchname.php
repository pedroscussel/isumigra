<?php


namespace App;

/**
 *
 * @author Maiko de Andrade
 */
trait Searchname
{
    public function scopeSearch($q)
    {
        return empty(request()->search) ? $q : $q->where('name', 'LIKE', '%' . request()->search .'%');
    }
}
