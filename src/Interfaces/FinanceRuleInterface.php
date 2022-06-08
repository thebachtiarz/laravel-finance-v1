<?php

namespace TheBachtiarz\Finance\Interfaces;

interface FinanceRuleInterface
{
    public const FINANCE_RULE_BALANCE_LIST_LIMIT_DAYS = 30;

    public const FINANCE_CODE_REQUEST_ORIGINAL_NAME = "account_number";
    public const FINANCE_CODE_REQUEST_ENCRYPTED_NAME = "account_number_code";

    public const BANK_SUMMARY_NAME_PREFIX = "__bankSummaryData";
    public const BANK_SUMMARY_NAME_SEPARATOR = "|";

    public const BANK_SUMMARY_SEARCH_DATE_FORMAT = "Y-m-d";
}
