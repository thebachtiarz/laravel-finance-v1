<?php

use TheBachtiarz\Finance\Interfaces\FinanceSystemInterface;

/**
 * TheBachtiarz finance config
 *
 * @param string|null $keyName config key name | null will return all
 * @return mixed
 */
function tbfinanceconfig(?string $keyName = null): mixed
{
    $configName = FinanceSystemInterface::FINANCE_CONFIG_NAME;

    return iconv_strlen($keyName)
        ? config("{$configName}.{$keyName}")
        : config("{$configName}");
}
