<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodotto extends Model
{
    use HasFactory;
    protected $table = 'prodotto';
    protected $primaryKey = 'id_prodotto';
    protected $fillable = [
        'nome',
        'prezzo',
        'descrizione'
      ];
      public $timestamps = false;
      
      public function categorie()
      {
          return $this->belongsToMany(Categoria::class, 'categoria_prodotto', 'fk_prodotto', 'fk_categoria');
      }
}
