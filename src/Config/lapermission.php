<?php

return [

    /**
     * User
     */
    'user' => [
        'model' => \App\Models\User::class
    ],
    
    /**
     * Middleware
     * set the middleware
     */
    'middleware' => [
        /**
         * enable or disable lapermission middleware
         */
        'enabled' => true,

        /**
         * Handling
         * To handle if user does not have required role/permission
         * 
         * available options: 'abort', 'redirect'
         */
        'handling' => 'abort',
        
        /**
         * Handlers
         * Action for selected handling
         */
        'handlers' => [
            /**
             * Abort the operation with given error code and error message
             */
            'abort' => [
                'code' => 403,
                'message' => 'You does not have permission/role to access this resource.'
            ],

            'redirect' => [
                /**
                 * Where to redirect user
                 */
                'url' => '/',
                /**
                 * session flash message
                 */
                'message' => [
                    'key' => 'lapermission_error',
                    'message' => 'You does not have permission/role to access this resource.'
                ]
            ]
        ]
    ],

    /**
     * LaPermission magic methods
     * enable or disable LaPermission magic methods
     * available magic methods:
     *      1. hasPermission('Edit Post')
     *      2. hasRole('Super Admin')
     */
    'magic_enable' => true,
    
];