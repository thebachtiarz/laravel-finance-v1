<?php

namespace TheBachtiarz\Finance\Service;

use TheBachtiarz\Finance\Interfaces\UrlDomainInterface;
use TheBachtiarz\Finance\Logs\FinanceProcessLog;
use TheBachtiarz\Toolkit\Helper\Curl\CurlRestService;

class CurlService
{
    use CurlRestService {
        post as public postOrigin;
    }

    /**
     * process curl post.
     * with logger.
     *
     * @override
     * @return array
     */
    public static function post(): array
    {
        $process = self::postOrigin();

        FinanceProcessLog::status($process['status'] ?? false)->message($process['message'] ?? "")->log();

        return $process;
    }

    /**
     * base domain resolver
     *
     * @override
     * @param boolean $secure
     * @return string
     */
    private static function baseDomainResolver(bool $secure = true): string
    {
        return UrlDomainInterface::URL_DOMAIN_BASE_AVAILABLE[$secure];
    }

    /**
     * url end point resolver
     *
     * @override
     * @return string
     */
    private static function urlResolver(): string
    {
        $_baseDomain = self::baseDomainResolver(tbsnconfig('secure_url'));

        $_prefix = tbfinanceconfig('domain_prefix');

        $_endPoint = UrlDomainInterface::URL_DOMAIN_TRANSACTION_AVAILABLE[self::$url];

        return "{$_baseDomain}/{$_prefix}/{$_endPoint}";
    }
}
