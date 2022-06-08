<?php

namespace TheBachtiarz\Finance\Jobs;

use Illuminate\Support\Facades\Auth;
use TheBachtiarz\Auth\Model\User;
use TheBachtiarz\Finance\Interfaces\FinanceCacheInterface;
use TheBachtiarz\Finance\Models\Finance;
use TheBachtiarz\Finance\Service\FinanceCurlService;
use TheBachtiarz\Finance\Traits\Management\FinanceMaintenanceTrait;
use TheBachtiarz\Toolkit\Cache\Service\Cache;
use TheBachtiarz\Toolkit\Helper\App\Log\ErrorLogTrait;
use TheBachtiarz\Toolkit\Helper\Cache\PaginateCache;
use TheBachtiarz\Toolkit\Helper\Model\ModelJobPaginateTrait;

class FinanceJob
{
    use ErrorLogTrait, ModelJobPaginateTrait, FinanceMaintenanceTrait;

    /**
     * Model User data
     *
     * @var User
     */
    protected static User $user;

    /**
     * Model Finance data
     *
     * @var Finance
     */
    protected static Finance $finance;

    /**
     * Define Finance Model.
     * Set if prefer to use override model.
     *
     * @var string
     */
    protected static string $financeModel = Finance::class;

    /**
     * Finance account number
     *
     * @var string
     */
    protected static string $financeAccountNumber;

    /**
     * Finance active status
     *
     * @var boolean
     */
    protected static bool $financeActiveStatus = true;

    /**
     * Finance active status flag setted
     *
     * @var boolean
     */
    protected static bool $financeActiveStatusSetted = false;

    // ? Public Methods
    /**
     * Create new finance account
     *
     * @param boolean $map
     * @return array
     */
    public static function create(bool $map = false): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            self::checkIsFinanceDisabled();

            /**
             * Create new finance account
             *
             * @var array
             */
            $_newFinanceAccount = self::createNewFinanceAccount();

            throw_if(!$_newFinanceAccount['status'], 'Exception', $_newFinanceAccount['message']);

            $_create = static::$financeModel::create([
                'user_id' => self::$user->id,
                'account_number' => $_newFinanceAccount['data'],
                'is_active' => self::$financeActiveStatus
            ]);

            throw_if(!$_create, 'Exception', "Failed to create new user finance");

            $result['data'] = $map ? $_create->simpleListMap() : $_create;
            $result['status'] = true;
            $result['message'] = "Successfully create new user finance";
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();

            self::logCatch($th);
        } finally {
            return $result;
        }
    }

    /**
     * Get account(s) list
     *
     * @param boolean $map
     * @return array
     */
    public static function getAccountList(bool $map = false): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            $_finances = self::getListFinanceAccounts($map);

            throw_if(!$_finances['status'], 'Exception', $_finances['message']);

            $result['data'] = $_finances['data'];
            $result['status'] = true;
            $result['message'] = $_finances['message'];
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();
        } finally {
            return $result;
        }
    }

    /**
     * Get finance account detail
     *
     * @param boolean $map
     * @return array
     */
    public static function getAccountDetail(bool $map = false): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            $_account = static::$financeModel::getByAccount(self::$financeAccountNumber)->first();
            throw_if(!$_account, 'Exception', "Finance account not found");

            $result['data'] = $map ? $_account->simpleListMap() : $_account;
            $result['status'] = true;
            $result['message'] = "Finance account detail";
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();

            self::logCatch($th);
        } finally {
            return $result;
        }
    }

    /**
     * Update user finance active status
     *
     * @param boolean $map
     * @return array
     */
    public static function updateActiveStatus(bool $map = false): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            self::checkIsFinanceDisabled();

            $_update = self::$finance->update([
                'is_active' => self::$financeActiveStatus
            ]);

            throw_if(!$_update, 'Exception', "Failed to update active status user finance");

            $result['data'] = $map ? self::$finance->simpleListMap() : self::$finance;
            $result['status'] = true;
            $result['message'] = "Successfully update active status user finance";
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();
        } finally {
            return $result;
        }
    }

    /**
     * Update finance account number
     *
     * @param boolean $map
     * @return array
     */
    public static function updateAccountNumber(bool $map = false): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            self::checkIsFinanceDisabled();

            /**
             * Update finance account
             *
             * @var array
             */
            $_updateFinanceAccount = self::updateFinanceAccount();

            throw_if(!$_updateFinanceAccount['status'], 'Exception', $_updateFinanceAccount['message']);

            $_update = self::$finance->update([
                'account_number' => $_updateFinanceAccount['data']
            ]);

            throw_if(!$_update, 'Exception', "Failed to update user finance");

            $result['data'] = $map ? self::$finance->simpleListMap() : self::$finance;
            $result['status'] = true;
            $result['message'] = "Successfully update user finance";
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();

            self::logCatch($th);
        } finally {
            return $result;
        }
    }

    // ? Private Methods
    /**
     * Curl service create new finance account process
     * ! Only execute by system
     *
     * @return array
     */
    private static function createNewFinanceAccount(): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            $_create = FinanceCurlService::create();

            throw_if(!$_create['status'], 'Exception', $_create['message']);

            $_financeData = $_create['data'];

            throw_if(!iconv_strlen($_financeData['finance_code']), 'Exception', "Failed to create new finance account");

            $result['status'] = true;
            $result['data'] = $_financeData['finance_code'];
            $result['message'] = $_create['message'];
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();

            self::logCatch($th);
        } finally {
            return $result;
        }
    }

    /**
     * Curl service update finance account process
     * ! Only execute by system
     *
     * @return array
     */
    private static function updateFinanceAccount(): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            $_update = FinanceCurlService::update(self::$finance->account_number);

            throw_if(!$_update['status'], 'Exception', $_update['message']);

            $_financeData = $_update['data'];

            throw_if(!iconv_strlen($_financeData['finance_code']), 'Exception', "Failed to update finance account");

            $result['status'] = true;
            $result['data'] = $_financeData['finance_code'];
            $result['message'] = $_update['message'];
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();

            self::logCatch($th);
        } finally {
            return $result;
        }
    }

    /**
     * Get list finance account(s) with cached data
     *
     * @param boolean $map
     * @param boolean $cacheFirst
     * @return array
     */
    private static function getListFinanceAccounts(bool $map = false, bool $cacheFirst = true): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ""];

        try {
            $_financesData = [];

            $_cacheFound = false;

            $_financeCacheName = self::getCachePrefixFullName($map);

            PaginateCache::activatePaginate();

            if ($cacheFirst && Cache::has($_financeCacheName)) {
                $_financesCache = Cache::get($_financeCacheName);
                self::addPaginateSummary(Cache::get("{$_financeCacheName}_pagsum"));

                if (count($_financesCache)) {
                    $_cacheFound = true;
                    $_financesData = $_financesCache;
                }
            }

            if (!$_cacheFound) {
                $_finances = self::paginateSimple(static::$financeModel);

                $_paginateData = PaginateCache::getPaginateSummaryInfo();

                Cache::setTemporary("{$_financeCacheName}_pagsum", $_paginateData, FinanceCacheInterface::CACHE_DATA_FINANCE_LIST_RULE_TTL);

                throw_if(!$_finances->count(), 'Exception', "Finance accounts not found");

                $_financesData = $_finances->toArray()['data'];

                if ($map) {
                    $_financesDataMapped = [];

                    foreach ($_financesData as $key => $account) {
                        $_accountDetail = self::setFinanceAccountNumber($account['account_number'])->getAccountDetail(true);

                        if (!$_accountDetail['status']) continue;

                        $_financesDataMapped[] = $_accountDetail['data'];
                    }

                    $_financesData = $_financesDataMapped;
                }

                Cache::setTemporary($_financeCacheName, $_financesData, FinanceCacheInterface::CACHE_DATA_FINANCE_LIST_RULE_TTL);
            }

            $result['status'] = true;
            $result['data'] = $_financesData;
            $result['message'] = sprintf("List accounts (from %s)", ($_cacheFound ? "cache" : "origin"));
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();
        } finally {
            return $result;
        }
    }

    /**
     * Get cache prefix full name
     *
     * @param boolean $map
     * @return string
     */
    private static function getCachePrefixFullName(bool $map = false): string
    {
        /**
         * Cache name builder
         *
         * @var array
         */
        $_result = [
            FinanceCacheInterface::CACHE_DATA_FINANCE_LIST_PREFIX_NAME,
            PaginateCache::getPaginatePerPage() ?: self::$paginatePerPage,
            PaginateCache::getPaginatePage() ?: self::$paginatePage
        ];

        $_result[] = Auth::hasUser() ? ('U' . Auth::user()->id) : 'guest';

        $_result[] = $map ? "mapped" : "origin";

        return implode(FinanceCacheInterface::CACHE_DATA_SEPARATOR, $_result);
    }

    // ? Setter Modules
    /**
     * Set model User data
     *
     * @param User $user Model User data
     * @return static
     */
    public static function setUser(User $user): static
    {
        self::$user = $user;

        return new static;
    }

    /**
     * Set model Finance data
     *
     * @param Finance $finance Model User Finance data
     * @return static
     */
    public static function setFinance(Finance $finance): static
    {
        self::$finance = $finance;

        return new static;
    }

    /**
     * Set finance account number
     *
     * @param string $financeAccountNumber finance account number
     * @return static
     */
    public static function setFinanceAccountNumber(string $financeAccountNumber): static
    {
        self::$financeAccountNumber = $financeAccountNumber;

        return new static;
    }

    /**
     * Set finance active status
     *
     * @param boolean $financeActiveStatus finance active status
     * @param boolean $financeActiveStatusSetted finance active status flag setted
     * @return static
     */
    public static function setFinanceActiveStatus(bool $financeActiveStatus, bool $financeActiveStatusSetted = true): static
    {
        self::$financeActiveStatus = $financeActiveStatus;
        self::$financeActiveStatusSetted = $financeActiveStatusSetted;

        return new static;
    }
}
