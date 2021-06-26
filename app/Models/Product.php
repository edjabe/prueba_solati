<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
        'valor',
        'moneda',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
