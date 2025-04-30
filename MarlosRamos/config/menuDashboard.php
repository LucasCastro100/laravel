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
            'icon' => 'fas fa-chalkboard-teacher',
            'name' => 'Gerenciar Cursos',
            'route' => 'course.index',
            'role' => 1
        ],
        [
            'icon' => 'fas fa-users-cog',
            'name' => 'Gerenciar Usuários',
            'route' => 'admin.allUsers',
            'role' => 1
        ],
        [
            'icon' => 'fas fa-book-reader',
            'name' => 'Cursos',
            'route' => 'student.allCourses',
            'role' => 0
        ],
        [
            'icon' => 'fas fa-user-circle',
            'name' => 'Perfil',
            'route' => 'profile.edit',
            'role' => 0
        ],
    ],
];
