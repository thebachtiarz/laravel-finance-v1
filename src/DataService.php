<?php

namespace TheBachtiarz\Finance;

class DataService
{
    /**
     * list of config who need to registered into current project.
     * perform by finance app module.
     *
     * @return array
     */
    public static function registerConfig(): array
    {
        $registerConfig = [];

        // ! logging
        $logging = config('logging.channels');
        $registerConfig[] = [
            'logging.channels' => array_merge(
                $logging,
                [
                    'finance' => [
                        'driver' => 'single',
                        'path' => tbdirlocation("log/finance.log")
                    ]
                ]
            )
        ];

        return $registerConfig;
    }
}
