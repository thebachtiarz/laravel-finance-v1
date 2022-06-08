<?php

namespace TheBachtiarz\Finance\Traits\Management;

use TheBachtiarz\Toolkit\Cache\Service\Cache;

/**
 * Finance Maintenance Trait
 */
trait FinanceMaintenanceTrait
{
    //

    // ? Public Methods

    // ? Private Methods
    /**
     * Disable finance activity
     *
     * @return void
     */
    private static function disableFinanceActivity(): void
    {
        Cache::set('__financeActivityDisable', true);
    }

    /**
     * Enable finance activity
     *
     * @return void
     */
    private static function enableFinanceActivity(): void
    {
        Cache::delete('__financeActivityDisable');
    }

    /**
     * Check is finance activity condition
     *
     * @return void
     * @throws \Throwable
     */
    private static function checkIsFinanceDisabled(): void
    {
        try {
            throw_if(Cache::has('__financeActivityDisable'), 'Exception', "Finance activity is disable");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // ? Setter Modules
}
