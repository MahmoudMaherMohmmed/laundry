<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class City extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'cities';
    protected $fillable = ['country_id', 'title', 'description', 'lat', 'lng', 'status'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
