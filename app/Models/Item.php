<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use Translatable;  
    use SoftDeletes;

    protected $table = 'items';
    protected $fillable = ['service_id', 'clothes_type_id', 'title', 'description', 'price', 'image'];

    public function services()
    {
        return $this->belongsTo(Service::class);
    }

    public function colthesType()
    {
        return $this->belongsTo(ClothesType::class);
    }
}
