<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClothesType extends Model
{
    use HasFactory;
    use Translatable;  
    use SoftDeletes;

    protected $table = 'clothes_types';
    protected $fillable = ['title', 'description', 'image'];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function items()
    {
      return $this->hasMany(Item::class);
    }
}
