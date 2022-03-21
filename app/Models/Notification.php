<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notifications';
    protected $fillable = ['client_id', 'title', 'body'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
