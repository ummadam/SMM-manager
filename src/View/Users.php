<?php

namespace App\View;

class Users extends Main 
{
    public function content($data = [])
    {
        $columns = [
            'id' => [
                'label' => '#',
                'class' => 'text-center'
            ],
            'email' => [
                'label' => 'Email',
                'class' => '',
            ],
            'name' => [
                'label' => 'Имя менеджера',
                'class' => ''
            ],
            'table-actions' => [
                'label' => 'Действия',
                'class' => 'text-center',
                'buttons' => [
                    'update' => [
                        'icon' => 'fa fa-pencil',
                        'route' => '/users/update',
                    ],
                    'delete' => [
                        'icon' => 'fa fa-times',
                        'route' => '/users/delete',
                    ],
                ]
            ]
        ];

        $buttons = [
            'create' => [
                'icon' => 'fa fa-plus',
                'route' => '/users/create'
            ]
        ];

        $this->table($columns, $data['data'], $buttons);
    }
}