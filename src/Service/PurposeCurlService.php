<?php

namespace TheBachtiarz\Finance\Service;

use TheBachtiarz\Finance\Interfaces\{FinanceSystemInterface, UrlDomainInterface};
use TheBachtiarz\Finance\Traits\CurlBodyResolverTrait;
use TheBachtiarz\Toolkit\Helper\App\Response\DataResponse;

class PurposeCurlService
{
    use CurlBodyResolverTrait, DataResponse;

    /**
     * create new finance purpose
     *
     * @param string $information
     * @return array
     */
    public static function create(string $information): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data'],
            FinanceSystemInterface::FINANCE_CONFIG_INFORMATION_NAME => $information
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_PURPOSE_CREATE_NAME)->setData($_body)->post();
    }

    /**
     * list finance purpose(s) owner
     *
     * @return array
     */
    public static function list(): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data']
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_PURPOSE_LIST_NAME)->setData($_body)->post();
    }

    /**
     * show detail finance purpose
     *
     * @param string $purposeCode
     * @return array
     */
    public static function detail(string $purposeCode): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data'],
            FinanceSystemInterface::FINANCE_CONFIG_PURPOSE_CODE_NAME => $purposeCode
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_PURPOSE_DETAIL_NAME)->setData($_body)->post();
    }

    /**
     * update finance purpose information
     *
     * @param string $purposeCode
     * @param string $information
     * @return array
     */
    public static function update(string $purposeCode, string $information): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data'],
            FinanceSystemInterface::FINANCE_CONFIG_PURPOSE_CODE_NAME => $purposeCode,
            FinanceSystemInterface::FINANCE_CONFIG_INFORMATION_NAME => $information
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_PURPOSE_UPDATE_NAME)->setData($_body)->post();
    }
}
