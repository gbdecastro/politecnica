<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aval extends Model
{
    protected $table = 'aval';
   	protected $primaryKey = ['id_f1','id_f2','nb_ano','nb_mes'];
   	protected $fillable = ['nb_nota'];
}
