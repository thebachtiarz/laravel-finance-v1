<?php

namespace TheBachtiarz\Finance\Logs;

use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;
use TheBachtiarz\Toolkit\Helper\App\Interfaces\LogLevelInterface;

class FinanceProcessLog
{
    /**
     * Log level default
     *
     * @var string|null
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#5-psrlogloglevel
     */
    private static ?string $level = null;

    /**
     * Process result status
     *
     * @var boolean
     */
    private static bool $status;

    /**
     * Process result message
     *
     * @var string
     */
    private static string $message;

    // ? Public Methods
    /**
     * Process log result
     *
     * @return void
     */
    public static function log(): void
    {
        Log::channel('finance')->log(self::levelResolver(), self::$message);
    }

    // ? Private Methods
    /**
     * Log level resolver by process status
     *
     * @return string
     */
    private static function levelResolver(): string
    {
        try {
            throw_if(!self::$level || !in_array(self::$level, LogLevelInterface::LOG_LEVEL_AVAILABLE), 'Exception', "");

            return self::$level;
        } catch (\Throwable $th) {
            return self::$status ? LogLevel::INFO : LogLevel::WARNING;
        }
    }

    // ? Setter Modules
    /**
     * Set log level
     *
     * @param string $level log level
     * @return self
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#5-psrlogloglevel
     */
    public static function level(string $level): self
    {
        self::$level = $level;

        return new self;
    }

    /**
     * Set process result status
     *
     * @param boolean $status process result status
     * @return self
     */
    public static function status(bool $status): self
    {
        self::$status = $status;

        return new self;
    }

    /**
     * Set process result message
     *
     * @param string $message process result message
     * @return self
     */
    public static function message(string $message): self
    {
        self::$message = $message;

        return new self;
    }
}
