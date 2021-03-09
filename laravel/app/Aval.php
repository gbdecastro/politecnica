<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aval extends Model
{
    protected $table = 'aval';
   	protected $primaryKey = ['id_f1','nb_idx','nb_ano','nb_mes'];
   	protected $fillable = ['id.f2','nb_proativ','nb_produtiv','nb_pontual'];
}
