<?php
class MyConfig{
    /*
    NOTES:
    - setting for mysql
    */
    public static $db_configs = [
        'servername' => 'localhost:3306',
        'username' => 'root',
        'password' => 'toor',
        'database' => 'ldap' 
    ];

    /*
    NOTES:     
    - this default configs will be replace by database configs.
    */
    public static $load_db = true;
    public static $default_configs = [
        // An array of LDAP hosts.
        // ex: 'ldap.forumsys.com'
        'domain_controllers' => '',

        // The base distinguished name of your domain.
        // ex: 'dc=example,dc=com'
        'base_dn' => '',

        // The port to use for connecting to your hosts.
        // ex:
        // - ldap: 389
        // - ldaps (ssl): 636
        'port' => 0,

        // The account prefix to use when authenticating your admin account above.
        // ex: 
        // - windows: 'cn='
        // - linux: 'cid='
        'admin_account_prefix' => '',

        // The account prefix to use when authenticating your admin account above.
        // ex: 'cn=Users'
        'admin_account_suffix' => '',
        'admin_account_suffix_arr' => [],

        // The global LDAP operation timeout limit in seconds.
        // NO CHANGE
        'timeout' => 5,

        // The LDAP version to utilize.
        // NO CHANGE
        'version' => 3,

        // Whether or not to use SSL when connecting to your hosts.
        'use_ssl' => false,

        // Whether or not to use TLS when connecting to your hosts.
        'use_tls' => false,

        // Whether or not follow referrals is enabled when performing LDAP operations.
        'follow_referrals' => false,

        // The username to connect to your hosts with.
        'admin_username' => '',

        // The password that is utilized with the above user.
        'admin_password' => '',

        // Custom LDAP options that you'd like to utilize.
        'custom_options' => [ ],
        
        // need to update for window or linux
        'user_filter' => '',
        'group_filter' => '',
        'organization_filter' => '',   

        // FIELDS
        'fields' => [
            'user' => [
                'list' => ['cn', 'distinguishedname'],
                'detail' => ['cn', 'distinguishedname'],
                'edit' => ['cn']
            ],
            'group' => [
                'list' => ['cn', 'distinguishedname']
            ],
            'organization' => [
                'list' => ['cn', 'distinguishedname']
            ]
        ],

        // Permissions
        'root_permission_users' => ['euler']
        // 'permissions' => [
        //     'super' => [
        //         'users' => [],
        //         'groups' => []
        //     ],
        //     'admin' => [
        //         'users' => [],
        //         'groups' => []
        //     ]
        // ]
    ];
}
?>