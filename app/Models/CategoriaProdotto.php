<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProdotto extends Model
{
    use HasFactory;
    protected $fillable = [
        'fk_categoria',
        'fk_prodotto'
      ];
      protected $table = 'categoria_prodotto';
      public $timestamps = false;
}
