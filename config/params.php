<?php

$db = require(__DIR__. '/db.php');

return [
    'common' => [
        'version' => '0.0.1',
        'developers' => [
            'Dmitry Shianov',
            'Savely Nesinov',
            'Yaroslav Shadt',
            'Andrey Krutogolov'
        ]
    ],
    'modules' => [
        './models',
    ], 'db' => $db
];