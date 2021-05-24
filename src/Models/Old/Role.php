<?php

namespace Trainner\Models;

class Role extends \Spatie\Permission\Models\Role
{

    /**
     * Acesso Deus para usuários de Infra
     *
     * @var array
     */
    public static $GOOD = 1;

    /**
     * Acesso Deus para usuários de Infra
     *
     * @var array
     */
    public static $ADMIN = 2;

    /**
     * São consumidores dos Clientes dos Usuários do Payment
     *
     * @var array
     */
    public static $CUSTOMER = 3;

    /**
     * Usuários do Organização
     *
     * @var array
     */
    public static $USER = 4;

    /**
     * São clientes dos Usuários do Payment.
     *
     * @var array
     */
    public static $CLIENT = 5;

    // protected $guarded = [];

    // public function users()
    // {
    //     $userModel = User::class;

    //     return $this->belongsToMany($userModel, 'role_user')
    //         ->select(app($userModel)->getTable().'.*')
    //         ->union($this->hasMany($userModel))->getQuery();
    // }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class);
    // }
}
