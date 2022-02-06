<?php

namespace TheBachtiarz\Finance\Service;

use TheBachtiarz\Finance\Interfaces\{FinanceSystemInterface, UrlDomainInterface};
use TheBachtiarz\Finance\Traits\CurlBodyResolverTrait;
use TheBachtiarz\Toolkit\Helper\App\Response\DataResponse;

class OwnerCurlService
{
    use CurlBodyResolverTrait, DataResponse;

    /**
     * create new owner finance
     *
     * @return array
     */
    public static function create(): array
    {
        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_OWNER_CREATE_NAME)->post();
    }

    /**
     * get information about owner finance
     *
     * @return array
     */
    public static function detail(): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data']
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_OWNER_DETAIL_NAME)->setData($_body)->post();
    }

    /**
     * update owner finance code
     *
     * @return array
     */
    public static function update(): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data']
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_OWNER_UPDATE_NAME)->setData($_body)->post();
    }
}
