<?php

return [
    'admin' => [
        [
            'icon' => 'fa-solid fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'admin.dashBoard',
            'role' => 3
        ],
        [
            'icon' => 'fa-solid fa-users-cog',
            'name' => 'Usuários',
            'route' => 'admin.users',
            'role' => 3
        ],
        [
            'icon' => 'fa-solid fa-chalkboard-teacher',
            'name' => 'Cursos',
            'route' => 'course.index',
            'role' => 3
        ],
        [
            'icon' => 'fa-solid fa-list-check',
            'name' => 'Testes',
            'route' => 'test.index',
            'role' => 3
        ],
        [
            'icon' => 'fa-solid fa-circle-question',
            'name' => 'Dúvidas',
            'route' => 'admin.contacts',
            'role' => 3
        ],
    ],
    'teacher' => [
        [
            'icon' => 'fa-solid fa-tachometer-alt',
            'name' => 'Painel',
            'route' => 'teacher.dashBoard',
            'role' => 2
        ],
        [
            'icon' => 'fa-solid fa-list-check',
            'name' => 'Testes',
            'route' => 'teacher.myTests',
            'role' => 2
        ],
        [
            'icon' => 'fa-solid fa-chalkboard-teacher',
            'name' => 'Cursos',
            'route' => 'teacher.myCourses',
            'role' => 2
        ],
        [
            'icon' => 'fa-solid fa-comments',
            'name' => 'Comentários',
            'route' => 'comment.index',
            'role' => 2
        ],
        [
            'icon' => 'fa-solid fa-user-plus',
            'name' => 'Alunos',
            'route' => 'teacher.students',
            'role' => 2
        ],
        [
            'icon' => 'fa-solid fa-circle-question',
            'name' => 'Dúvidas',
            'route' => 'teacher.contacts',
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
        [
            'icon' => 'fa-solid fa-circle-question',
            'name' => 'Dúvidas',
            'route' => 'student.duvidas',
            'role' => 1
        ],
    ]
];
