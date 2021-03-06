<?php

return new \Phalcon\Config([

    'modules' => ['api'],

    'db' => [
        'host'     =>  'mysql',
        'username' =>  getenv('MYSQL_USER'),
        'password' =>  getenv('MYSQL_PASSWORD'),
        'dbName'   =>  getenv('MYSQL_DATABASE'),
        'port'     =>  ''
    ],

    'jwt' => [
        'algo' => 'HS512',
        'secret' => 'MpfMRCzpzADu@xXxs%L@ltj8l#zT*pys',
        'ttl' => 60 * 1000,
    ],

    'min_confirmations' => 1,

    'path_to_files' => '/files',

    'smtp' => [
        'host'     => getenv("SMTP_HOST"),
        'port'     => getenv("SMTP_PORT"),
        'security' => getenv("SMTP_SECURITY"),
        'username' => getenv("SMTP_USER"),
        'password' => getenv("SMTP_PASS"),
    ],

    'filters' => [
        'limit' => 25,
        'offset' => 0
    ],

    'files' => [
        'max_file_size' => 10000000,
        'root_dir' => '/files'
    ],

    'pictures' => [
        'avatars' => [
            'width' => '512',
            'height' => '512'
        ]
    ]

]);
