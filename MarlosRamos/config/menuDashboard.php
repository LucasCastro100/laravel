<?php

return [
    'admin' => [
        [
            'icon' => 'fas fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'admin.dashBoard',
            'role' => 3
        ],


        [
            'icon' => 'fas fa-users-cog',
            'name' => 'Gerenciar Usuários',
            'route' => 'admin.allUsers',
            'role' => 3
        ],
    ],
    'teacher' => [
        [
            'icon' => 'fas fa-vial',
            'name' => 'Gerenciar Testes',
            'route' => 'test.index',
            'role' => 2
        ],
        [
            'icon' => 'fas fa-chalkboard-teacher',
            'name' => 'Gerenciar Cursos',
            'route' => 'course.index',
            'role' => 2
        ],
    ],
    'student' => [
        [
            'icon' => 'fas fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'student.dashBoard',
            'role' => 1
        ],
        [
            'icon' => 'fas fa-book-reader',
            'name' => 'Cursos',
            'route' => 'student.allCourses',
            'role' => 1
        ],
    ]
];
