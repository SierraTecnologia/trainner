<?php

namespace Trainner\Services;

class MenuService
{

    public static function getAdminMenu()
    {
        $trainner = [];
        $trainner[] = [
            'text'        => 'Treinos',
            'url'         => url('trainner/home'), //route('trainner.home'),
            'icon'        => 'dashboard',
            'icon_color'  => 'blue',
            'label_color' => 'success',
            // 'access' => \App\Models\Role::$ADMIN
        ];

        return $trainner;
    }
}
