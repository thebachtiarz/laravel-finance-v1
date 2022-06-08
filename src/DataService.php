<?php

namespace TheBachtiarz\Finance;

class DataService
{
    /**
     * List of config who need to registered into current project.
     * Perform by finance app module.
     *
     * @return array
     */
    public static function registerConfig(): array
    {
        $registerConfig = [];

        // ! Logging
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
