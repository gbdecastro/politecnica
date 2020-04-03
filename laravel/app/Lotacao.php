<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    protected $table = 'lotacao';
   	protected $primaryKey = ['id_lotacao'];
   	protected $fillable = ['id_diasuteis','tx_lotacao','nb_horas'];
}
