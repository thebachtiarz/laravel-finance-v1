<?php

use TheBachtiarz\Finance\Interfaces\FinanceSystemInterface;

/**
 * thebachtiarz finance config
 *
 * @param string|null $keyName config key name | null will return all
 * @return mixed
 */
function tbfinanceconfig(?string $keyName = null)
{
    $configName = FinanceSystemInterface::FINANCE_CONFIG_NAME;

    return iconv_strlen($keyName)
        ? config("{$configName}.{$keyName}")
        : config("{$configName}");
}
