<?php

namespace App\View;

class Tasks extends Main
{
    public function content($data = [])
    {
        $columns = [
            'id' => [
                'label' => '#',
                'class' => 'text-center'
            ],
            'login' => [
                'label' => 'Аккаунт',
                'class' => '',
            ],
            'title' => [
                'label' => 'Название',
                'class' => '',
            ],
            'description' => [
                'label' => 'Описание',
                'class' => '',
            ],
            'publish_date' => [
                'label' => 'Дата публикации',
                'class' => '',
            ],
            'table-actions' => [
                'label' => 'Действия',
                'class' => 'text-center',
                'buttons' => [
                    'update' => [
                        'icon' => 'fa fa-pencil',
                        'route' => '/tasks/update',
                    ],
                    'delete' => [
                        'icon' => 'fa fa-times',
                        'route' => '/tasks/delete',
                    ],
                ]
            ]
        ];

        $buttons = [
            'create' => [
                'icon' => 'fa fa-plus',
                'route' => '/tasks/create'
            ]
        ];

        $this->table($columns, $data['data'], $buttons);
    }
}
