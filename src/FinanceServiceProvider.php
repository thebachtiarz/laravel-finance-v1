<?php

namespace TheBachtiarz\Finance;

use Illuminate\Support\ServiceProvider;
use TheBachtiarz\Finance\Interfaces\FinanceSystemInterface;

class FinanceServiceProvider extends ServiceProvider
{
    /**
     * register module finance
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }

    /**
     * boot module toolkit
     *
     * @return void
     */
    public function boot(): void
    {
        if (app()->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/' . FinanceSystemInterface::FINANCE_CONFIG_NAME . '.php' => config_path(FinanceSystemInterface::FINANCE_CONFIG_NAME . '.php'),
            ], 'thebachtiarz-finance-config');
        }
    }
}
