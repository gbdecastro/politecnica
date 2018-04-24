<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projetos extends Model
{
    protected $table = 'projetos';
    
    protected $primaryKey = ['id_projeto','id_grupo'];

    protected $fillable = ['tx_projeto', 'cs_situacao', 'id_empresa','cs_status'];
    
}
