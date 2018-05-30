<?php
$configs = [
    // An array of LDAP hosts.
    'domain_controllers' => ['ldap.forumsys.com'],

    // The global LDAP operation timeout limit in seconds.
    'timeout' => 5,

    // The LDAP version to utilize.
    'version' => 3,

    // The port to use for connecting to your hosts.
    'port' => 389,

    // The base distinguished name of your domain.
    'base_dn' => 'dc=example,dc=com',

    // Whether or not to use SSL when connecting to your hosts.
    'use_ssl' => false,

    // Whether or not to use TLS when connecting to your hosts.
    'use_tls' => false,

    // Whether or not follow referrals is enabled when performing LDAP operations.
    'follow_referrals' => false,

    // The account prefix to use when authenticating users.
    'account_prefix' => null,

    // The account suffix to use when authenticating users.
    'account_suffix' => null,

    // The username to connect to your hosts with.
    'admin_username' => '',

    // The password that is utilized with the above user.
    'admin_password' => '',

    // The account prefix to use when authenticating your admin account above.
    'admin_account_prefix' => 'uid=',

    // The account prefix to use when authenticating your admin account above.
    'admin_account_suffix' => ',dc=example,dc=com',

    // Custom LDAP options that you'd like to utilize.
    'custom_options' => [],
];

?>