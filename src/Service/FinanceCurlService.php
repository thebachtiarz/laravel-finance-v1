<?php

namespace TheBachtiarz\Finance\Service;

use TheBachtiarz\Finance\Interfaces\{FinanceSystemInterface, UrlDomainInterface};

class FinanceCurlService
{
    //

    // ? Public Methods
    /**
     * Create new finance account
     *
     * @return array
     */
    public static function create(): array
    {
        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_FINANCE_CREATE_NAME)->post();
    }

    /**
     * Get detail finance account
     *
     * @param string $financeCode
     * @return array
     */
    public static function detail(string $financeCode): array
    {
        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_FINANCE_CODE_NAME => $financeCode
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_FINANCE_DETAIL_NAME)->setData($_body)->post();
    }

    /**
     * Update finance account code
     *
     * @param string $financeCode
     * @return array
     */
    public static function update(string $financeCode): array
    {
        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_FINANCE_CODE_NAME => $financeCode
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_FINANCE_UPDATE_NAME)->setData($_body)->post();
    }
}
