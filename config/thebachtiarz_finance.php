<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API URL Production
    |--------------------------------------------------------------------------
    |
    | API URL Production site.
    |
    */
    'api_url_production' => "https://appfinance.thebachtiarz.com",

    /*
    |--------------------------------------------------------------------------
    | API URL Sandbox
    |--------------------------------------------------------------------------
    |
    | API URL Sandbox site.
    |
    */
    'api_url_sandbox' => "http://appfinance.test",

    /*
    |--------------------------------------------------------------------------
    | Url Prefix
    |--------------------------------------------------------------------------
    |
    | Set url prefix.
    |
    */
    'api_url_prefix' => 'XcVItKlgRst',

    /*
    |--------------------------------------------------------------------------
    | Warehouse Mode
    |--------------------------------------------------------------------------
    |
    | Set mode of warehouse project.
    |
    */
    'is_production_mode' => true,

    /*
    |--------------------------------------------------------------------------
    | Finance Owner Type
    |--------------------------------------------------------------------------
    |
    | Define this application is using multi owner(s).
    |
    */
    'is_multi_owner' => false,

    /*
    |--------------------------------------------------------------------------
    | Owner Finance code
    |--------------------------------------------------------------------------
    |
    | Define owner code for finance.
    |
    | ! this config is mutable !
    |
    */
    'owner_code' => "",

    /*
    |--------------------------------------------------------------------------
    | Finance Codes Limit Display
    |--------------------------------------------------------------------------
    |
    | Define finance codes to always limit display.
    |
    */
    'always_limit_display' => false,

    /*
    |--------------------------------------------------------------------------
    | Finance Transaction Detail Limit Display
    |--------------------------------------------------------------------------
    |
    | Define finance transaction detail limit display.
    | Available: ['owner_code', 'finance_code', 'purpose_code', 'transaction_reference'];
    |
    */
    'transaction_code_detail_limit' => [],

    /*
    |--------------------------------------------------------------------------
    | Finance Account length display
    |--------------------------------------------------------------------------
    |
    | Define finance account length to display.
    | Leave null if want to full display.
    |
    */
    'finance_account_length' => null,

    /*
    |--------------------------------------------------------------------------
    | Finance Account suffix code
    |--------------------------------------------------------------------------
    |
    | Define finance account suffix code for display rest of limit finance account.
    | Will not appear if 'finance_account_length' == null.
    |
    */
    'finance_account_suffix' => "SECRETCODE",
];
