<?php

namespace TheBachtiarz\Finance\Helpers;

use Illuminate\Support\Str;

class FinanceHelper
{
    //

    /**
     * Get original/custom finance codes.
     * Based on finance config.
     *
     * @param string $financeAccount
     * @param boolean $dependOnConfig
     * @return string
     */
    public static function limitCodeDisplay(string $financeAccount, bool $dependOnConfig = false): string
    {
        $_result = $financeAccount;

        try {
            if ($dependOnConfig)
                throw_if(!tbfinanceconfig('always_limit_display'), 'Exception', "Always limit display is disable.");

            throw_if(
                !tbfinanceconfig('finance_account_length'),
                'Exception',
                "Display original finance account."
            );

            throw_if(
                tbfinanceconfig('finance_account_length') > iconv_strlen($financeAccount),
                'Exception',
                "Account limit display cannot more than original."
            );

            $_result = Str::limit(
                $financeAccount,
                tbfinanceconfig('finance_account_length'),
                tbfinanceconfig('finance_account_suffix')
            );
        } catch (\Throwable $th) {
        } finally {
            return $_result;
        }
    }
}
