<?php

return [
    'manifest_path' => public_path('build/manifest.json'), 
    'hot_file' => public_path('hot'), 
    'build_directory' => 'build', 
    'asset_url' => null, 
    'ssr' => [
        'manifest_path' => public_path('build/ssr-manifest.json'), 
        'entry' => 'resources/js/ssr.js',
    ],
];
