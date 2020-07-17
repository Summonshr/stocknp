<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    public $timestamps = false;

    public function news()
    {
        return $this->hasMany(News::class, 'symbol', 'symbol');
    }

    public function report()
    {
        return $this->hasOne(Report::class, 'symbol', 'symbol');
    }

    public function prices()
    {
        return $this->hasMany(SharePrice::class, 'symbol', 'symbol');
    }

    public function price()
    {
        return $this->hasOne(SharePrice::class, 'symbol', 'symbol');
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class, 'symbol', 'symbol');
    }
}
