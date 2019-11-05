<?php

return [

    'disk'        => 'root',

    'module'      => [
        'root' => 'modules',
    ],

    'scaffolding' => base_path() . '/modules/generator/scaffolding',

    'stubs'       => [
        'command'              => base_path() . '/modules/generator/stubs/Command.stub',
        'entity'               => base_path() . '/modules/generator/stubs/Entity.stub',
        'controller'           => base_path() . '/modules/generator/stubs/Controller.stub',
        'repository_interface' => base_path() . '/modules/generator/stubs/Repository.stub',
        'repository_eloquent'  => base_path() . '/modules/generator/stubs/RepositoryEloquent.stub',
        'validator'            => base_path() . '/modules/generator/stubs/Validator.stub',
        'test'                 => base_path() . '/modules/generator/stubs/Test.stub',
    ],

];
