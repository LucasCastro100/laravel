<?php

return [
    'admin' => [
        [
            'icon' => 'fa-solid fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'admin.dashBoard',
            'role' => 3
        ],
        // [
        //     'icon' => 'fa-solid fa-users-cog',
        //     'name' => 'Gerenciar Usuários',
        //     'route' => 'admin.allUsers',
        //     'role' => 3
        // ],
    ],
    'teacher' => [
        [
            'icon' => 'fa-solid fa-list-check',
            'name' => 'Gerenciar Testes',
            'route' => 'test.index',
            'role' => 2
        ],
        [
            'icon' => 'fa-solid fa-chalkboard-teacher',
            'name' => 'Gerenciar Cursos',
            'route' => 'course.index',
            'role' => 2
        ],
        [
            'icon' => 'fa-solid fa-comments',
            'name' => 'Gerenciar Comentários',
            'route' => 'course.index',
            'role' => 2
        ],
    ],
    'student' => [
        [
            'icon' => 'fa-solid fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'student.dashBoard',
            'role' => 1
        ],
        [
            'icon' => 'fa-solid fa-book-reader',
            'name' => 'Meus Cursos',
            'route' => 'student.myCourses',
            'role' => 1
        ],
        [
            'icon' => 'fa-solid fa-pencil',
            'name' => 'Meus Testes',
            'route' => 'student.myTests',
            'role' => 1
        ],
    ]
];
