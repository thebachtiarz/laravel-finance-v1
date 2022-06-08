<?php

namespace TheBachtiarz\Finance\Interfaces;

interface FinanceCacheInterface
{
    /**
     * Finance data cache name separator
     */
    public const CACHE_DATA_SEPARATOR = "_";

    /**
     * Finance cache name prefix
     */
    public const CACHE_DATA_FINANCE_LIST_PREFIX_NAME = "UaFChE";

    /**
     * Finance cache data temporary lifetime
     */
    public const CACHE_DATA_FINANCE_LIST_RULE_TTL = 1800;
}
