<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Country extends Model
{
    use Translatable;
    
    protected $table = 'countries';

    protected $fillable = ['title'];

    public function cities()
    {
      return $this->hasMany(City::class);
    }
}
