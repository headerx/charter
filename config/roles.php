<?php

return [

    'admin' => [
        'name' => 'Administerator',
        'permissions' => [
            '*:create' => 'Can create any resource',
            '*:read' => 'Can read any resource',
            '*:update' => 'Can update any resource',
            '*:delete' => 'Can delete any resource',
        ],
        'description' => 'Administrators can perform any action.',
    ],

    'supervisor' => [
        'name' => 'Supervisor',
        'permissions' => [
            'teams:read' => 'Can read teams',
            'teams:update' => 'Can update teams',
            'records:read' => 'Can read records',
            'records:create' => 'Can create records',
            'records:update' => 'Can update records',
            'records:delete' => 'Can delete records',
        ],
        'description' => 'Supervisors can manage teams and records.',
    ],

    'editor' => [
        'name' => 'Editor',
        'permissions' => [
            'records:read' => 'Can read records',
            'records:create' => 'Can create records',
            'records:update' => 'Can update records',
            'records:delete' => 'Can delete records',
        ],
        'description' => 'Editors can manage records.',
    ],

    'workforce' => [
        'name' => 'Workforce',
        'permissions' => [
            'own:create' => 'Can create own records',
            'own:read'  => 'Can read own records',
            'own:update' => 'Can update own records',
        ],
        'description' => 'Workforce can enter their own records.',
    ],

    'client' => [
        'name' => 'Client',
        'permissions' => [
            'own:read' => 'Can read own records',
        ],
        'description' => 'Clients can read their own records.',
    ],


];
