<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'tx_name', 'tx_funcao', 'tx_email', 'dt_admissao', 'tx_password','cs_tipo_contrato', 'nb_category_user', 'nb_nota', 'id_lotacao', 'tx_telefone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'tx_password', 'remember_token',
    ];

    public function getAuthPassword() {
        return $this->tx_password;
    }

    public function getEmailForPasswordReset()
    {
        return $this->tx_email;
    }  
}
