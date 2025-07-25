<?php

return [
    'show_warnings' => true,   // Se verdadeiro, lança uma exceção em caso de avisos do dompdf
    'public_path' => null,  // Sobrescreve o caminho público, se necessário
    'convert_entities' => true, // Converte entidades HTML em caracteres correspondentes
    'options' => [
        'font_dir' => public_path('fonts/'), // Diretório onde as fontes estão armazenadas
        'font_cache' => public_path('fonts/'), // Diretório de cache das fontes
        'temp_dir' => sys_get_temp_dir(), // Diretório temporário para armazenar arquivos temporários
        'chroot' => realpath(base_path()), // Define o diretório raiz para o dompdf
        'allowed_protocols' => [
            'file://' => ['rules' => []], // Permite o uso de URLs de arquivos
            'http://' => ['rules' => []], // Permite o uso de URLs HTTP
            'https://' => ['rules' => []], // Permite o uso de URLs HTTPS
        ],
        'artifactPathValidation' => null, // Configuração de validação de caminho de artefato, geralmente não necessário
        'log_output_file' => null, // Caminho para o arquivo de log, se desejado
        'enable_font_subsetting' => false, // Se verdadeiro, ativa o subconjunto de fontes para PDF
        'pdf_backend' => 'CPDF', // Backend usado para gerar PDF
        'default_media_type' => 'screen', // Tipo de mídia padrão
        'default_paper_size' => 'A4', // Tamanho padrão do papel
        'default_paper_orientation' => 'landscape', // Orientação padrão do papel (retrato ou paisagem)
        'default_font' => 'Nunito Sans', // Fonte padrão a ser usada
        'dpi' => 300, // Resolução do PDF (pontos por polegada)
        'enable_php' => false, // Permite a execução de PHP dentro do HTML
        'enable_javascript' => false, // Permite a execução de JavaScript
        'enable_remote' => true, // Permite o uso de recursos remotos (como imagens externas)
        'allowed_remote_hosts' => null, // Hosts remotos permitidos, se necessário
        'font_height_ratio' => 1.1, // Relação de altura da fonte
        'enable_html5_parser' => false, // Habilita o parser HTML5
        'margin_top' => 30, // Margem superior do documento
        'margin_right' => 20, // Margem direita do documento
        'margin_bottom' => 30, // Margem inferior do documento
        'margin_left' => 20, // Margem esquerda do documento

        // Adicionando configurações de fontes
        'font_data' => [
            'Nunito Sans' => [
                'R' => 'NunitoSans-Regular.ttf',
                'B' => 'NunitoSans-Bold.ttf',
                'I' => 'NunitoSans-Italic.ttf',
                'BI' => 'NunitoSans-BoldItalic.ttf',
            ],
        ],
    ],
];
