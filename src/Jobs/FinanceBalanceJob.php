<?php

namespace TheBachtiarz\Finance\Jobs;

use TheBachtiarz\Finance\Helpers\FinanceHelper;
use TheBachtiarz\Finance\Models\{Finance, FinanceBalance};
use TheBachtiarz\Finance\Traits\Job\TransactionJobTrait;
use TheBachtiarz\Finance\Traits\Management\FinanceMaintenanceTrait;
use TheBachtiarz\Toolkit\Helper\App\Log\ErrorLogTrait;

class FinanceBalanceJob
{
    use ErrorLogTrait, TransactionJobTrait, FinanceMaintenanceTrait;

    /**
     * Model Finance data
     *
     * @var Finance
     */
    protected static Finance $finance;

    /**
     * Model Finance Balance data
     *
     * @var FinanceBalance
     */
    protected static FinanceBalance $financeBalance;

    /**
     * Define Finance Balance Model.
     * Set if prefer to use override model.
     *
     * @var string
     */
    protected static string $financeBalanceModel = FinanceBalance::class;

    // ? Public Methods
    /**
     * Create new finance balance record
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
             * Create new transaction for finance balance
             *
             * @var array
             */
            $_createTransaction = self::setTransactionFinanceCode(self::$finance->account_number)->createTransaction();

            throw_if(!$_createTransaction['status'], 'Exception', $_createTransaction['message']);

            $_createBankSaving = static::$financeBalanceModel::create([
                'finance_id' => self::$finance->id,
                'reference' => $_createTransaction['data']['transaction_reference']
            ]);

            throw_if(!$_createBankSaving, 'Exception', "Failed to create new finance balance record");

            $result['data'] = $map ? $_createBankSaving->simpleListMap() : $_createBankSaving;
            $result['status'] = true;
            $result['message'] = "Successfully create new finance balance record";
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();

            self::logCatch($th);
        } finally {
            return $result;
        }
    }

    /**
     * Get detail of transaction
     *
     * @return array
     */
    public static function detail(): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            $_detail = self::getDetailTransaction();

            throw_if(!$_detail['status'], 'Exception', $_detail['message']);

            $result['data'] = self::transactionDetailMap($_detail['data']);
            $result['status'] = true;
            $result['message'] = "Detail of transaction";
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();

            self::logCatch($th);
        } finally {
            return $result;
        }
    }

    // ? Private Methods
    /**
     * Transaction detail map
     *
     * @param array $transaction
     * @return array
     */
    private static function transactionDetailMap(array $transaction): array
    {
        try {
            foreach (tbfinanceconfig('transaction_code_detail_limit') as $key => $column)
                if (@$transaction[$column])
                    $transaction[$column] = FinanceHelper::limitCodeDisplay($transaction[$column], true);

            return $transaction;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // ? Setter Modules
    /**
     * Set model Finance data
     *
     * @param Finance $finance Model Finance data
     * @return self
     */
    public static function setFinance(Finance $finance): self
    {
        self::$finance = $finance;

        return new self;
    }

    /**
     * Set model Finance Balance data
     *
     * @param FinanceBalance $financeBalance Model Finance Balance data
     * @return self
     */
    public static function setFinanceBalance(FinanceBalance $financeBalance): self
    {
        self::$financeBalance = $financeBalance;

        return new self;
    }
}
