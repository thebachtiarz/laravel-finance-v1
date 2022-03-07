<?php

namespace TheBachtiarz\Finance\Interfaces;

interface BalanceDataInterface
{
    public const BALANCE_DATA_MUTATION_TYPE_ALLOWED = [
        self::BALANCE_DATA_MUTATION_TYPE_ADD_CODE,
        self::BALANCE_DATA_MUTATION_TYPE_MIN_CODE
    ];

    public const BALANCE_DATA_MUTATION_TYPE_ALLOWED_OPTIONS = [
        self::BALANCE_DATA_MUTATION_TYPE_ADD_CODE => self::BALANCE_DATA_MUTATION_TYPE_ADD_DESC,
        self::BALANCE_DATA_MUTATION_TYPE_MIN_CODE => self::BALANCE_DATA_MUTATION_TYPE_MIN_DESC
    ];

    public const BALANCE_DATA_MUTATION_TYPE_ADD_CODE = "add";
    public const BALANCE_DATA_MUTATION_TYPE_MIN_CODE = "min";

    public const BALANCE_DATA_MUTATION_TYPE_ADD_DESC = "Increase Savings";
    public const BALANCE_DATA_MUTATION_TYPE_MIN_DESC = "Decrease Savings";

    public const BALANCE_DATA_RULE_AMOUNT_SAVE_MINIMAL = "2000";
    public const BALANCE_DATA_RULE_AMOUNT_SAVE_MAXIMAL = "10000000";

    public const BALANCE_DATA_RULE_AMOUNT_TAKE_MINIMAL = "5000";
    public const BALANCE_DATA_RULE_AMOUNT_TAKE_MAXIMAL = "1000000";
}
