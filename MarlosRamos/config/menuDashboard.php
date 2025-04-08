<?php

return [
    'admin' => [
        [
            'icon' => 'fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'dashboard',
        ],        
        [
            'icon' => 'fas fa-vial',
            'name' => 'Gerenciar Testes',
            'route' => 'test.index',
        ],
        [
            'icon' => 'fas fa-book',
            'name' => 'Gerenciar Cursos',
            'route' => 'course.index'
        ],
        [
            'icon' => 'fas fa-users',
            'name' => 'Gerenciar Usuários',
            'route' => 'course.index',
        ],
        [
            'icon' => 'fas fa-user',
            'name' => 'Perfil',
            'route' => 'profile.edit',
        ],
    ],
];
