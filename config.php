<?php
class MyConfig{
    public static $default_configs = [
        // An array of LDAP hosts.
        // ex: 'ldap.forumsys.com'
        'domain_controllers' => 'ldap.forumsys.com',

        // The global LDAP operation timeout limit in seconds.
        'timeout' => 5,

        // The LDAP version to utilize.
        'version' => 3,

        // The port to use for connecting to your hosts.
        // ex:
        // - ldap: 389
        // - ldaps (ssl): 636
        'port' => 389,

        // The base distinguished name of your domain.
        // ex: 'dc=example,dc=com'
        'base_dn' => 'dc=example,dc=com',

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

        // The account prefix to use when authenticating your admin account above.
        // ex: 
        // - windows: 'cn='
        // - linux: 'cid='
        'admin_account_prefix' => 'uid=',

        // The account prefix to use when authenticating your admin account above.
        // ex: 'cn=Users'
        'admin_account_suffix' => '',

        // Custom LDAP options that you'd like to utilize.
        'custom_options' => [ ],
        
        // need to update for window or linux
        'user_filter' => '(objectclass=person)',
        'group_filter' => '(objectclass=groupOfUniqueNames)',
        'role_filter' => '(objectclass=organizationalRole)',
        
        // list of suffix to select
        'admin_account_suffix_arr' => ['', 'CN=Users'],   

        // FIELDS
        'fields' => [
            'user' => [
                'detail' => ['cn', 'mail', 'objectclass'],
                'edit' => ['cn']
            ],
            'group' => [
                'detail' => ['cn'],
                'edit' => ['cn']
            ],
            'role' => [
                'detail' => ['cn'],
                'edit' => ['cn']
            ]
        ],

        // Permissions
        'permissions' => [
            'supper' => [
                'users' => [],
                'groups' => []
            ],
            'admin' => [
                'users' => [],
                'groups' => []
            ]
        ]
    ];
}
?>