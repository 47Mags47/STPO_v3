<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Files
    |--------------------------------------------------------------------------
    |
    | Here you may configure the settings related to files and their downloads
    |
    */

    'max_file_size' => env('MAX_FILE_SIZE', '10M'),

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'temp' => [
            'driver' => 'local',
            'root' => storage_path('app/private/temp'),
        ],

        'templates' => [
            'driver' => 'local',
            'root' => storage_path('app/private/templates'),
        ],

        'uploads' => [
            'driver' => 'local',
            'root' => storage_path('app/private/uploads'),
        ],

        'fsd' => [
            'driver' => 'local',
            'root' => storage_path('app/private/fsd'),
        ],

        'payments' => [
            'driver' => 'local',
            'root' => storage_path('app/private/payments'),
        ],

        'appeals' => [
            'driver' => 'local',
            'root' => storage_path('app/private/appeals'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
