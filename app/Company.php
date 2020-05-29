<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    public function news()
    {
        return $this->hasMany(News::class, 'symbol', 'symbol');
    }

    public function reports()
    {
        return $this->hasOne(Report::class, 'symbol', 'symbol');
    }

    public function prices()
    {
        return $this->hasMany(SharePrice::class, 'symbol', 'symbol');
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class, 'symbol', 'symbol');
    }
}
