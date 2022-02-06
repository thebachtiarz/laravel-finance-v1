<?php

namespace TheBachtiarz\Finance\Interfaces;

interface UrlDomainInterface
{
    public const URL_DOMAIN_BASE_AVAILABLE = [
        true => self::URL_DOMAIN_BASE_SECURE,
        false => self::URL_DOMAIN_BASE_UNSECURE
    ];

    public const URL_DOMAIN_TRANSACTION_AVAILABLE = [
        self::URL_DOMAIN_OWNER_CREATE_NAME => self::URL_DOMAIN_OWNER_CREATE_PATH,
        self::URL_DOMAIN_OWNER_DETAIL_NAME => self::URL_DOMAIN_OWNER_DETAIL_PATH,
        self::URL_DOMAIN_OWNER_UPDATE_NAME => self::URL_DOMAIN_OWNER_UPDATE_PATH,
        self::URL_DOMAIN_PURPOSE_CREATE_NAME => self::URL_DOMAIN_PURPOSE_CREATE_PATH,
        self::URL_DOMAIN_PURPOSE_LIST_NAME => self::URL_DOMAIN_PURPOSE_LIST_PATH,
        self::URL_DOMAIN_PURPOSE_DETAIL_NAME => self::URL_DOMAIN_PURPOSE_DETAIL_PATH,
        self::URL_DOMAIN_PURPOSE_UPDATE_NAME => self::URL_DOMAIN_PURPOSE_UPDATE_PATH,
        self::URL_DOMAIN_FINANCE_CREATE_NAME => self::URL_DOMAIN_FINANCE_CREATE_PATH,
        self::URL_DOMAIN_FINANCE_DETAIL_NAME => self::URL_DOMAIN_FINANCE_DETAIL_PATH,
        self::URL_DOMAIN_FINANCE_UPDATE_NAME => self::URL_DOMAIN_FINANCE_UPDATE_PATH,
        self::URL_DOMAIN_BALANCE_CREATE_NAME => self::URL_DOMAIN_BALANCE_CREATE_PATH,
        self::URL_DOMAIN_BALANCE_LISTPURPOSE_NAME => self::URL_DOMAIN_BALANCE_LISTPURPOSE_PATH,
        self::URL_DOMAIN_BALANCE_LIST_NAME => self::URL_DOMAIN_BALANCE_LIST_PATH,
        self::URL_DOMAIN_BALANCE_DETAIL_NAME => self::URL_DOMAIN_BALANCE_DETAIL_PATH
    ];

    public const URL_DOMAIN_BASE_SECURE = "https://appfinance.thebachtiarz.com";
    public const URL_DOMAIN_BASE_UNSECURE = "http://appfinance.thebachtiarz.com";

    public const URL_DOMAIN_OWNER_CREATE_NAME = "owner-create";
    public const URL_DOMAIN_OWNER_DETAIL_NAME = "owner-detail";
    public const URL_DOMAIN_OWNER_UPDATE_NAME = "owner-update";
    public const URL_DOMAIN_PURPOSE_CREATE_NAME = "purpose-create";
    public const URL_DOMAIN_PURPOSE_LIST_NAME = "purpose-list";
    public const URL_DOMAIN_PURPOSE_DETAIL_NAME = "purpose-detail";
    public const URL_DOMAIN_PURPOSE_UPDATE_NAME = "purpose-update";
    public const URL_DOMAIN_FINANCE_CREATE_NAME = "finance-create";
    public const URL_DOMAIN_FINANCE_DETAIL_NAME = "finance-detail";
    public const URL_DOMAIN_FINANCE_UPDATE_NAME = "finance-update";
    public const URL_DOMAIN_BALANCE_CREATE_NAME = "balance-create";
    public const URL_DOMAIN_BALANCE_LISTPURPOSE_NAME = "balance-list-purpose";
    public const URL_DOMAIN_BALANCE_LIST_NAME = "balance-list";
    public const URL_DOMAIN_BALANCE_DETAIL_NAME = "balance-detail";

    public const URL_DOMAIN_OWNER_CREATE_PATH = "owner/register";
    public const URL_DOMAIN_OWNER_DETAIL_PATH = "owner/detail";
    public const URL_DOMAIN_OWNER_UPDATE_PATH = "owner/update";
    public const URL_DOMAIN_PURPOSE_CREATE_PATH = "purpose/generate";
    public const URL_DOMAIN_PURPOSE_LIST_PATH = "purpose/list";
    public const URL_DOMAIN_PURPOSE_DETAIL_PATH = "purpose/detail";
    public const URL_DOMAIN_PURPOSE_UPDATE_PATH = "purpose/update";
    public const URL_DOMAIN_FINANCE_CREATE_PATH = "finance/generate";
    public const URL_DOMAIN_FINANCE_DETAIL_PATH = "finance/detail";
    public const URL_DOMAIN_FINANCE_UPDATE_PATH = "finance/update";
    public const URL_DOMAIN_BALANCE_CREATE_PATH = "balance/create";
    public const URL_DOMAIN_BALANCE_LISTPURPOSE_PATH = "balance/get-each-finance-by-purpose";
    public const URL_DOMAIN_BALANCE_LIST_PATH = "balance/get-transactions";
    public const URL_DOMAIN_BALANCE_DETAIL_PATH = "balance/get-transaction";
}
