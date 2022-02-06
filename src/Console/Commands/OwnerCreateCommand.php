<?php

namespace TheBachtiarz\Finance\Console\Commands;

use Illuminate\Console\{Command, ConfirmableTrait};
use Illuminate\Support\Facades\{Artisan, Log};
use TheBachtiarz\Finance\Interfaces\FinanceSystemInterface;
use TheBachtiarz\Finance\Service\OwnerCurlService;
use TheBachtiarz\Toolkit\Config\Helper\ConfigHelper;
use TheBachtiarz\Toolkit\Config\Interfaces\Data\ToolkitConfigInterface;
use TheBachtiarz\Toolkit\Config\Service\ToolkitConfigService;
use TheBachtiarz\Toolkit\Helper\App\Log\ErrorLogTrait;

class OwnerCreateCommand extends Command
{
    use ConfirmableTrait, ConfigHelper, ErrorLogTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thebachtiarz:finance:owner:create {--force : Force operation to update owner code even owner code exists or in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finance: create new owner finance (single owner only)';

    /**
     * proposed owner code
     *
     * @var string
     */
    private $proposedOwnerCode = "";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (tbfinanceconfig('is_multi_owner')) {
            $this->warn('Cancel this process, because this application is intended for multiple owners.');

            die;
        }

        $currentOwnerCode = tbfinanceconfig('owner_code');

        try {
            if (iconv_strlen($currentOwnerCode)) {
                throw_if(!($this->hasOption('force') && $this->option('force')), 'Exception', "");

                throw_if(!$this->confirmToProceed(), 'Exception', "");

                $this->updateOwnerCodeAndConfigFile();
            } else {
                $this->updateOwnerCodeAndConfigFile();
            }
        } catch (\Throwable $th) {
            $this->warn('Owner code has been declared, use --force to change it.');

            $this->proposedOwnerCode = $currentOwnerCode;
        }

        try {
            $updateConfigData = ToolkitConfigService::name(FinanceSystemInterface::FINANCE_CONFIG_PREFIX_NAME . "/" . FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME)
                ->value($this->proposedOwnerCode)
                ->accessGroup(ToolkitConfigInterface::TOOLKIT_CONFIG_PRIVATE_CODE)
                ->isEncrypt(true)
                ->set();

            throw_if(!$updateConfigData, 'Exception', "Failed to update config owner code data");

            Artisan::call('config:cache');

            Log::channel('application')->info("- Successfully set new finance owner code");

            $this->info('Owner code set successfully.');

            return 1;
        } catch (\Throwable $th) {
            Log::channel('application')->warning("- Failed to set new finance owner code: {$th->getMessage()}");

            $this->warn('Failed to set owner code.');

            return 0;
        }
    }

    /**
     * update owner code and config file
     *
     * @return void
     */
    private function updateOwnerCodeAndConfigFile(): void
    {
        try {
            $generateOwnerCode = OwnerCurlService::create();

            throw_if(!$generateOwnerCode['status'], 'Exception', $generateOwnerCode['message']);

            $this->proposedOwnerCode = $generateOwnerCode['data']['owner_code'];

            $updateConfigFile = self::setConfigName(FinanceSystemInterface::FINANCE_CONFIG_NAME)
                ->updateConfigFile(FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME, $this->proposedOwnerCode);

            throw_if(!$updateConfigFile, 'Exception', "Failed to update config owner code file");
        } catch (\Throwable $th) {
            self::logCatch($th);

            throw $th;
        }
    }
}