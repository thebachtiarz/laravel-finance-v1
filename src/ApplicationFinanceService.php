<?php

namespace TheBachtiarz\Finance;

use TheBachtiarz\Finance\Console\Commands\{OwnerCreateCommand, OwnerUpdateCommand};

class ApplicationFinanceService
{
    /**
     * list of commands from finance modules
     */
    public const COMMANDS = [
        OwnerCreateCommand::class,
        OwnerUpdateCommand::class
    ];

    // ? Public Methods
    /**
     * register config
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
     * register commands
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
     * set configs
     *
     * @return void
     */
    private function setConfigs(): void
    {
        foreach (DataService::registerConfig() as $key => $register)
            config($register);
    }
}
