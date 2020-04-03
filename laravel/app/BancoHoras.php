<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BancoHoras extends Model
{
    protected $table = 'dias_uteis';
   	protected $primaryKey = ['nb_mes','nb_ano','id_diasuteis'];
   	protected $fillable = ['nb_mes','nb_ano','nb_dias'];
}
