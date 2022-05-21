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
     * @param boolean $productionMode
     * @return string
     */
    private static function baseDomainResolver(bool $productionMode = true): string
    {
        return $productionMode ? tbfinanceconfig('api_url_production') : tbfinanceconfig('api_url_sandbox');
    }

    /**
     * url end point resolver
     *
     * @override
     * @return string
     */
    private static function urlResolver(): string
    {
        $_baseDomain = self::baseDomainResolver(tbfinanceconfig('is_production_mode'));

        $_prefix = tbfinanceconfig('api_url_prefix');

        $_endPoint = UrlDomainInterface::URL_DOMAIN_TRANSACTION_AVAILABLE[self::$url];

        return "{$_baseDomain}/{$_prefix}/{$_endPoint}";
    }
}
