<?php

namespace App\View;

class Accounts extends Main
{
    public function content($data = [])
    {
        $columns = [
            'id' => [
                'label' => '#',
                'class' => 'text-center'
            ],
            'login' => [
                'label' => 'Логин в Instagram',
                'class' => '',
            ],
            'table-actions' => [
                'label' => 'Действия',
                'class' => 'text-center',
                'buttons' => [
                    'update' => [
                        'icon' => 'fa fa-pencil',
                        'route' => '/accounts/update',
                    ],
                    'delete' => [
                        'icon' => 'fa fa-times',
                        'route' => '/accounts/delete',
                    ],
                ]
            ]
        ];

        $buttons = [
            'create' => [
                'icon' => 'fa fa-plus',
                'route' => '/accounts/create'
            ]
        ];

        $this->table($columns, $data['data'], $buttons);
    }
}
