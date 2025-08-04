<?php

return [
    'categories' => [
        ['id' => 'A1B2C3D4E5F6', 'slug' => 'baby',       'label' => 'Baby',       'modalitie' => 'basic', 'question' => 'basic', 'dp' => 'baby'],
        ['id' => 'G7H8I9J0K1L2', 'slug' => 'kids1',      'label' => 'Kids 1',     'modalitie' => 'intermediary', 'question' => 'basic', 'dp' => 'kids1'],
        ['id' => 'M3N4O5P6Q7R8', 'slug' => 'kids2',      'label' => 'Kids 2',     'modalitie' => 'advanced', 'question' => 'advanced', 'dp' => 'kids2'],
        ['id' => 'S9T0U1V2W3X4', 'slug' => 'middle1',    'label' => 'Middle 1',   'modalitie' => 'advanced', 'question' => 'advanced', 'dp' => 'middle'],
        ['id' => 'Y5Z6A7B8C9D0', 'slug' => 'middle2',    'label' => 'Middle 2',   'modalitie' => 'advanced', 'question' => 'advanced', 'dp' => 'middle'],
        ['id' => 'E1F2G3H4I5J6', 'slug' => 'high',       'label' => 'High',       'modalitie' => 'advanced', 'question' => 'advanced', 'dp' => 'high'],
        ['id' => 'K7L8M9N0O1P2', 'slug' => 'technic',    'label' => 'Technic',    'modalitie' => 'advanced', 'question' => 'advanced', 'dp' => 'technic'],
        ['id' => 'Q3R4S5T6U7V8', 'slug' => 'university', 'label' => 'University', 'modalitie' => 'advanced', 'question' => 'advanced', 'dp' => 'university'],
    ],

    'modalities_by_level' => [
        'basic' => [
            ['id' => 'A3F9L2X8Q7M5', 'slug' => 'ap', 'label' => 'Apresentação'],
        ],

        'intermediary' => [
            ['id' => 'A3F9L2X8Q7M5', 'slug' => 'ap', 'label' => 'Apresentação'],
            ['id' => 'H1G2F3E4D5C6', 'slug' => 'dp', 'label' => 'Desafio Prático (DP)'],
        ],

        'advanced' => [
            ['id' => 'Z9Y8X7W6V5U4', 'slug' => 'mc', 'label' => 'Mérito Científico (MC)'],
            ['id' => 'T3S2R1Q0P9O8', 'slug' => 'om', 'label' => 'Organização e Método (OM)'],
            ['id' => 'N7M6L5K4J3I2', 'slug' => 'te', 'label' => 'Tecnologia e Engenharia (TE)'],
            ['id' => 'H1G2F3E4D5C6', 'slug' => 'dp', 'label' => 'Desafio Prático (DP)'],
        ]
    ],

    'questions_by_level' => [
        'basic' => [
            [
                'id' => 'A3F9L2X8Q7M5',
                'modality' => 'ap',
                'assessment' => [
                    [
                        'object' => 'Projeto',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            '1. Criatividade - O projeto é inovador e demonstra uma solução criativa.',
                            '2. Qualidade da Solução - O projeto é bem pensado e tem uma boa solução para o problema abordado pela Equipe. A solução está de acordo com o tema TBR.',
                            '3. Relatório de pesquisa - A equipe demonstrou ter realizado pesquisas para desenvolver a ideia do projeto e foi capaz de relatar claramente as suas conclusões.',
                            '4. Valor de impacto e entretenimento - O projeto tem um forte impacto sobre ao problema abordado, isso me fez querer vê-lo novamente ou aprender mais sobre ele.'
                        ]
                    ],
                    [
                        'object' => 'Engenharia e Design',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            '1. Compreensão Técnica - A equipe explicou de forma clara e com conhecimento como é o funcionamento do seu projeto.',
                            '2. Conceitos de Engenharia - O projeto mostra evidências de que conceitos de engenharia foram usados.',
                            '3. Eficiência Mecânica - A concepção geral do projeto demonstra eficiência durante a apresentação (isto é, uso adequado de mecanismos, as peças não soltam com facilidade, o projeto se mostra adequado para faixa de idade da equipe, é fácil de ser reparado, etc.).',
                            '4. Estabilidade Estrutural - O projeto é resistente e pode ser operado várias vezes sem a necessidade de reparos.',
                            '5. Estética - O projeto é atraente aos olhos, percebe-se claramente que a equipe esta empenhada em fazer uma boa apresentação sem auxilio de professores e/ou técnicos.'
                        ]
                    ],
                    [
                        'object' => 'Apresentação',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            '1. Demonstração bem sucedida - O projeto funcionou como esperado, e é possivel executá-lo mais de uma vez, se necessário.',
                            '2. Habilidades de comunicação e raciocínio - Os alunos foram capazes de explicar a construção e o desenvolvimento do seu projeto, como ele funciona e por que eles decidiram construí-lo.',
                            '3. Pensamento rápido - Os alunos são capazes de responder facilmente as perguntas sobre seu projeto.',
                            '4. Posters e Decorações - Os materiais utilizados para apresentar o projeto demonstra clareza, eficiência e objetividade. A Equipe demonstra boa preparação durante a apresentação do projeto.'
                        ]
                    ],
                    [
                        'object' => 'Trabalho em Equipe',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            '1. Resultado de Aprendizagem Unificada - A equipe foi capaz de demonstrar que todos os membros compartilharam igualmente conhecimento durante o processo de aprendizagem.',
                            '2. Inclusão - A equipe foi capaz de demonstrar que todos os membros desempenharam um papel importante na construção e apresentação do seu projeto, como também na dinâmica realizada.',
                            '3. Espirito de Equipe - Todos os membros da equipe demonstraram interesse em participar da apresentação do projeto, como também mostraram entusiasmo e animação durante a reaização da dinâmica de equipe.'

                        ]
                    ],
                ]
            ],
        ],

        'advanced' => [
            [
                'id' => 'Z9Y8X7W6V5U4',
                'modality' => 'mc',
                'assessment' => [
                    [
                        'object' => 'Problema Abordado',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'O problema abordado mostra consistência com o tema central do TBR',
                            'O problema abordado é facilmente verificável e explorável',
                            'O problema abordado é impactante para a sociedade pesquisada',
                            'O método utilizado para definição do problema abordado é claro,objetivo e preciso',
                            'A escolha do problema abordado foi realizada com consciência e técnica'
                        ]
                    ],
                    [
                        'object' => 'Pesquisa do Problema',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'O método de pesquisa é claro, bem definido e executável com facilidade',
                            'A pesquisa está sustentada por dados e informações confiáveis',
                            'Há utilização de dados e informações primários',
                            'Há utilização de dados e informações secundários',
                            'As referências bibliográficas apresentadas foram bem exploradas e deram sustentação ao trabalho',
                            'Há referências bibliográficas em quantidade e qualidade para fundamentação do trabalho',
                            'A pesquisa seguiu normas e procedimentos científicos (ABNT)'
                        ]
                    ],
                    [
                        'object' => 'Solução Inovadora',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'A solução apresentada pode ser entendida como inovadora',
                            'Mais de uma solução foram apresentadas, pesquisadas e analisadas antes da proposição da solução final',
                            'A solução apresentada é exequível (implementação e viabilização)',
                            'A solução apresentada mostra-se importante e relevante para a sociedade pesquisada',
                            'A solução apresentada mostra-se capaz de resolver o problema abordado'
                        ]
                    ],
                    [
                        'object' => 'Publicação',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'A publicação do trabalho de pesquisa ocorreu de forma ampla',
                            'A publicação do trabalho de pesquisa ocorreu em meios e instrumentos confiáveis',
                            'Houve preocupação em fazer publicações parciais durante a realização do trabalho e que mostraram a evolução da pesquisa',
                            'O documento de publicação foi elaborado com respeito as normas e regras que norteiam a Metodologia Científica',
                            'O documento de publicação do trabalho de pesquisa mostra-se inteligível e de fácil compreensão',
                            'A redação do documento de publicação do trabalho de pesquisa atendeu às normas da língua culta'
                        ]
                    ]
                ],
            ],
            [
                'id' => 'T3S2R1Q0P9O8',
                'modality' => 'om',
                'assessment' => [
                    [
                        'object' => 'Estratégia Geral',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'A Equipe demonstra ter entendido os desafios da temporada',
                            'A Equipe estabeleceu estratégia adequada para o enfrentamento dos desafios a que se submeteram',
                            'A estratégia adotada é clara a todos os membros da equipe',
                            'A estratégia foi desdobrada em ações claras, objetivas e exequíveis',
                            'A Equipe registrou a evolução de seus trabalhos e as correções de percurso'
                        ]
                    ],
                    [
                        'object' => 'Organização da Equipe',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'A Equipe organizou seus membros para que cada um pudesse dar o seu melhor na realização do Plano de Ações',
                            'A Equipe demonstra união das pessoas em torno de um objetivo comum',
                            'A Equipe demonstra equilíbrio de ações e atitudes entre seus integrantes',
                            'Os membros da Equipe demonstram respeito entre si e na forma como se comunicam',
                            'O processo de tomada de decisão é sempre revestido de respeito a opinião e pelo debate livre e franco',
                            'A comunicação na Equipe é fluída e eficaz'
                        ]
                    ],
                    [
                        'object' => 'Capacidade Operacional',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'Os membros da Equipe demonstram conhecimento claro em seus domínios de atuação',
                            'Os membros da Equipe sabem o que fazem, pois agem com orientação de seus pares e mentor',
                            'O Plano Operacional foi definido de forma clara, objetiva e exequível',
                            'A qualidade foi meta da Equipe em seus afazeres, o que se pode denotar pelos resultados do trabalho',
                            'A Equipe praticou feedback de suas ações, buscando sempre melhorar a performance da Equipe'
                        ]
                    ],
                    [
                        'object' => 'Capacidade de Gestão',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'A Equipe demonstrou uso racional dos Recursos Materiais empregados',
                            'A Equipe demonstrou Planejamento Financeiro coerente e racional',
                            'A Equipe fez adequada Gestão dos Recursos Humanos',
                            'A Gestão de Propaganda e Marketing mostrou ser coerente e eficaz',
                            'A Gestão do Tempo foi bem conduzida e eficiente',
                            'A Gestão da Comunicação foi eficaz e eficiente'
                        ]
                    ]
                ]
            ],
            [
                'id' => 'N7M6L5K4J3I2',
                'modality' => 'te',
                'assessment' => [
                    [
                        'object' => 'Abordagem dos Desafios Práticos',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'A Equipe demonstra conhecer os desafios práticos e saber como resolvê-los de forma eficaz',
                            'A Equipe não se mostra tensa frente aos desafios práticos',
                            'A abordagem técnica da mesa é clara, objetiva e eficiente',
                            'A Equipe mostra segurança no enfrentamento dos desafios práticos',
                            'Os operadores do robô mostram-se firmes e seguros nas partidas',
                            'A Equipe explicita apoio aos operadores do robô durante as partidas',
                            'O Técnico e a Equipe demonstram integração e firmeza de propósitos',
                            'A Equipe é constante na realização dos desafios práticos'
                        ]
                    ],
                    [
                        'object' => 'Competência Técnica e Tecnológica',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'O robô tem um design bem definido e harmonioso',
                            'O robô é robusto em sua estrutura e flexível no manuseio',
                            'O robô não tem partes e peças que se soltam com facilidade durante as partidas prejudicando seu desempenho',
                            'A Equipe demonstra conhecimento técnico sobre o projeto do robô',
                            'Claramente nota-se que Mentor e Técnico orientaram o projeto do robô sem interferir diretamente na sua construção e/ou      programação',
                            'A articulação dos integrantes da Equipe é notada na busca de elevar o desempenho do robô entre as partidas',
                            'A lógica de programação é bem definida',
                            'A estrutura do programa é racional, compacta e eficiente',
                            'Houve otimização no projeto de partes do robô, permitindo seu uso em mais de uma aplicação',
                            'Há busca pela melhoria contínua no projeto do robô é denotada'
                        ]
                    ],
                    [
                        'object' => 'Documentação Técnica',
                        'image' => '',
                        'mission' => 0,
                        'description' => [
                            'O caderno de projeto é completo e mostra as diferentes etapas do projeto',
                            'O caderno de projeto relata ossucessos e osinsucessos do projeto',
                            'O caderno de projeto relata com detalhes o projeto do robô quanto a estrutura física, o design e a programação',
                            'O caderno de projeto foi divulgado no Blog da Equipe',
                            'A Equipe deixa claro que aproveitará seus sucessos em projetos futuros'
                        ]
                    ]
                ]
            ]
        ]
    ],

    'dp_by_level' => [
        'baby' => [
            [
                'image' => '',
                'mission' => 0,
                'description' => '',
                'itens' => [
                    [
                        'name' => '',
                        'value' => '0'
                    ],
                    [
                        'name' => '',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
        ],

        'kids1' => [
            [
                'image' => '',
                'mission' => 0,
                'description' => '',
                'itens' => [
                    [
                        'name' => '',
                        'value' => '0'
                    ],
                    [
                        'name' => '',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
        ],

        'kids2' => [
            [
                'image' => '',
                'mission' => 0,
                'description' => 'Reintegração Selvagem - Tamanduá',
                'itens' => [
                    [
                        'name' => 'Tocando Totalmente',
                        'value' => '70'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '35'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ],
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 1,
                'description' => 'Reintegração Selvagem - Macaco',
                'itens' => [
                    [
                        'name' => 'Tocando Totalmente',
                        'value' => '50'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '25'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ],
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 2,
                'description' => 'Reintegração Selvagem - Onça',
                'itens' => [
                    [
                        'name' => 'Tocando Totalmente',
                        'value' => '30'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '15'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ],
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 3,
                'description' => 'Renascimento azul',
                'itens' => [
                    [
                        'name' => 'Tocando Sobre Verde',
                        'value' => '105'
                    ],
                    [
                        'name' => 'Parcilamente Sobre Verde',
                        'value' => '75'
                    ],
                    [
                        'name' => 'Tocando Sobre Azul',
                        'value' => '45'
                    ],
                    [
                        'name' => 'Parcilamente Sobre Azul',
                        'value' => '25'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ],
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 4,
                'description' => 'Reflorestamento',
                'itens' => [
                    [
                        'name' => 'Tocando Somente Área 1',
                        'value' => '10'
                    ],
                    [
                        'name' => 'Tocando Parcialmente Área 1',
                        'value' => '5'
                    ],
                    [
                        'name' => 'Tocando Somente Área 2',
                        'value' => '14'
                    ],
                    [
                        'name' => 'Tocando Parcialmente Área 2',
                        'value' => '7'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ],
                ],
                'type' => 'number',
                'rules' => true,
                'bonus' => '40'
            ],
            [
                'image' => '',
                'mission' => 5,
                'description' => 'Departamento ecológico',
                'itens' => [
                    [
                        'name' => 'Tocando Somente',
                        'value' => '65'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '35'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ],
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ]
        ],

        'middle' => [
            [
                'image' => '',
                'mission' => 0,
                'description' => 'Reintegração Selvagem - Onça',
                'itens' => [
                    [
                        'name' => 'Tocando Totalmente',
                        'value' => '28'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '14'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'number',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 1,
                'description' => 'Reintegração Selvagem - Macaco',
                'itens' => [
                    [
                        'name' => 'Tocando Totalmente',
                        'value' => '24'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '12'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 2,
                'description' => 'Reintegração Selvagem - Tamanduá',
                'itens' => [
                    [
                        'name' => 'Tocando Totalmente',
                        'value' => '20'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '10'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 3,
                'description' => 'Renascimento azul',
                'itens' => [
                    [
                        'name' => 'Totalmente Sobre O Verde',
                        'value' => '40'
                    ],
                    [
                        'name' => 'Parcialmente Sobre O Verde',
                        'value' => '25'
                    ],
                    [
                        'name' => 'Totalmente Sobre O Azul',
                        'value' => '15'
                    ],
                    [
                        'name' => 'Parcialmente Sobre O Azul',
                        'value' => '10'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 4,
                'description' => 'Liberdade Selvagem',
                'itens' => [
                    [
                        'name' => 'Jaula Aberta',
                        'value' => '43'
                    ],
                    [
                        'name' => 'Jaula Fechada',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 5,
                'description' => 'Sistema de Monitoramento',
                'itens' => [
                    [
                        'name' => 'Acionado',
                        'value' => '45'
                    ],
                    [
                        'name' => 'Não Acionado',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 6,
                'description' => 'Reflorestamento',
                'itens' => [
                    [
                        'name' => 'Tocando Somente Área 1',
                        'value' => '6'
                    ],
                    [
                        'name' => 'Tocando Parcilamente Área 1',
                        'value' => '3'
                    ],
                    [
                        'name' => 'Tocando Somente Área 2',
                        'value' => '13'
                    ],
                    [
                        'name' => 'Tocando Parcilamente Área 2',
                        'value' => '7'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'number',
                'rules' => true,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 7,
                'description' => 'Corredor Ecológico',
                'itens' => [
                    [
                        'name' => 'Acionado',
                        'value' => '40'
                    ],
                    [
                        'name' => 'Não Acionado',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 8,
                'description' => 'Departamento ecológico',
                'itens' => [
                    [
                        'name' => 'Tocando Somente',
                        'value' => '40'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '20'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 9,
                'description' => 'Missão Maker',
                'itens' => [
                    [
                        'name' => 'Realizado',
                        'value' => '70'
                    ],
                    [
                        'name' => 'Não Realizado',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ]
        ],

        'high' => [
            [
                'image' => '',
                'mission' => 0,
                'description' => 'Expresso Ecológico',
                'itens' => [
                    [
                        'name' => 'Tocando Somente',
                        'value' => '55'
                    ],
                    [
                        'name' => 'Tocando Parcialemnte',
                        'value' => '25'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'number',
                'rules' => true,
                'bonus' => '50'
            ],
            [
                'image' => '',
                'mission' => 1,
                'description' => 'Reflorestamento Sementes',
                'itens' => [
                    [
                        'name' => 'Tocando A Mesma Cor',
                        'value' => '15'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'number',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 2,
                'description' => 'Reflorestamento - Condição Caixa',
                'itens' => [
                    [
                        'name' => 'Totalmente Dentro',
                        'value' => '10'
                    ],
                    [
                        'name' => 'Parcilamente Dentro',
                        'value' => '5'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'number',
                'rules' => false,
                'bonus' => '0'
            ],
            [
                'image' => '',
                'mission' => 3,
                'description' => 'Departamento ecológico',
                'itens' => [
                    [
                        'name' => 'Tocando Somente',
                        'value' => '80'
                    ],
                    [
                        'name' => 'Tocando Parcialmente',
                        'value' => '40'
                    ],
                    [
                        'name' => 'Outro',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ]
        ],

        'technic' => [
            [
                'image' => '',
                'mission' => 0,
                'description' => '',
                'itens' => [
                    [
                        'name' => '',
                        'value' => '0'
                    ],
                    [
                        'name' => '',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ]
        ],

        'university' => [
            [
                'image' => '',
                'mission' => 0,
                'description' => '',
                'itens' => [
                    [
                        'name' => '',
                        'value' => '0'
                    ],
                    [
                        'name' => '',
                        'value' => '0'
                    ]
                ],
                'type' => 'radio',
                'rules' => false,
                'bonus' => '0'
            ]
        ]
    ]
];
