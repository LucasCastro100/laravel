<?php

return [
    'admin' => [
        [
            'icon' => 'fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'dashboard',
            'role' => 0
        ],        
        [
            'icon' => 'fas fa-vial',
            'name' => 'Gerenciar Testes',
            'route' => 'test.index',
            'role' => 1
        ],
        [
            'icon' => 'fas fa-book',
            'name' => 'Gerenciar Cursos',
            'route' => 'course.index',
            'role' => 1
        ],
        [
            'icon' => 'fas fa-users',
            'name' => 'Gerenciar Usuários',
            'route' => 'course.index',
            'role' => 1
        ],
        [
            'icon' => 'fas fa-user',
            'name' => 'Perfil',
            'route' => 'profile.edit',
            'role' => 0
        ],
    ],
];
