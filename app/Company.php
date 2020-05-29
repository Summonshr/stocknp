<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function reports()
    {
        return $this->hasOne(Report::class);
    }

    public function prices()
    {
        return $this->hasMany(SharePrice::class);
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class);
    }
}
