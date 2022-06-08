<?php

namespace TheBachtiarz\Finance;

class ApplicationFinanceService
{
    /**
     * List of commands from finance modules
     */
    public const COMMANDS = [
        \TheBachtiarz\Finance\Console\Commands\OwnerCreateCommand::class,
        \TheBachtiarz\Finance\Console\Commands\OwnerUpdateCommand::class
    ];

    // ? Public Methods
    /**
     * Register config
     *
     * @return boolean
     */
    public function registerConfig(): bool
    {
        try {
            $this->setConfigs();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Register commands
     *
     * @return array
     */
    public function registerCommands(): array
    {
        try {
            return self::COMMANDS;
        } catch (\Throwable $th) {
            return [];
        }
    }

    // ? Private Methods
    /**
     * Set configs
     *
     * @return void
     */
    private function setConfigs(): void
    {
        foreach (DataService::registerConfig() as $key => $register)
            config($register);
    }
}
