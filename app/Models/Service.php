<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use Translatable;  
    use SoftDeletes;

    protected $table = 'services';
    protected $fillable = ['title', 'description', 'image'];

    public function clothesTypes()
    {
        return $this->belongsToMany(ClothesType::class);
    }

    public function items()
    {
      return $this->hasMany(Item::class);
    }

}
