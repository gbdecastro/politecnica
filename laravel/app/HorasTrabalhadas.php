<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HorasTrabalhadas extends Model
{
	protected $table = 'horas_projetos_funcionarios';

    protected $primaryKey = ['id_funcionario','id_projeto','id_grupo','dt_trabalho'];

    protected $fillable = [
    	'id_funcionario',
    	'id_projeto',
    	'id_grupo',
    	'dt_trabalho',
    	'nb_horas_trabalho',
		'nb_despesa',
		'cs_status'
    ];
}
