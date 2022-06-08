<?php

namespace TheBachtiarz\Finance\Traits\Job;

use TheBachtiarz\Finance\Service\BalanceCurlService;

/**
 * Transaction Job Trait
 */
trait TransactionJobTrait
{
    /**
     * Transaction purpose code
     *
     * @var string
     */
    protected static string $transactionPurposeCode;

    /**
     * Transaction finance code
     *
     * @var string
     */
    protected static string $transactionFinanceCode;

    /**
     * Transaction mutation type
     *
     * @var string
     */
    protected static string $transactionMutationType;

    /**
     * Transaction credit amount
     *
     * @var string
     */
    protected static string $transactionCreditAmount;

    /**
     * Transaction information
     *
     * @var string
     */
    protected static string $transactionInformation;

    /**
     * Transaction reference code
     *
     * @var string
     */
    protected static string $referenceCode;

    // ? Public Methods

    // ? Private Methods
    /**
     * Create new transaction
     *
     * @return array
     */
    private static function createTransaction(): array
    {
        return BalanceCurlService::create(
            self::$transactionPurposeCode,
            self::$transactionFinanceCode,
            self::$transactionMutationType,
            self::$transactionCreditAmount,
            self::$transactionInformation
        );
    }

    /**
     * Get detail of transaction by reference code
     *
     * @return array
     */
    private static function getDetailTransaction(): array
    {
        return BalanceCurlService::detail(self::$referenceCode);
    }

    // ? Setter Modules
    /**
     * Set transaction purpose code
     *
     * @param string $transactionPurposeCode transaction purpose code
     * @return static
     */
    public static function setTransactionPurposeCode(string $transactionPurposeCode): static
    {
        self::$transactionPurposeCode = $transactionPurposeCode;

        return new static;
    }

    /**
     * Set transaction finance code
     *
     * @param string $transactionFinanceCode transaction finance code
     * @return static
     */
    public static function setTransactionFinanceCode(string $transactionFinanceCode): static
    {
        self::$transactionFinanceCode = $transactionFinanceCode;

        return new static;
    }

    /**
     * Set transaction mutation type
     *
     * @param string $transactionMutationType transaction mutation type
     * @return static
     */
    public static function setTransactionMutationType(string $transactionMutationType): static
    {
        self::$transactionMutationType = $transactionMutationType;

        return new static;
    }

    /**
     * Set transaction credit amount
     *
     * @param string $transactionCreditAmount transaction credit amount
     * @return static
     */
    public static function setTransactionCreditAmount(string $transactionCreditAmount): static
    {
        self::$transactionCreditAmount = $transactionCreditAmount;

        return new static;
    }

    /**
     * Set transaction information
     *
     * @param string $transactionInformation transaction information
     * @return static
     */
    public static function setTransactionInformation(string $transactionInformation): static
    {
        self::$transactionInformation = $transactionInformation;

        return new static;
    }

    /**
     * Set reference code
     *
     * @param string $referenceCode reference code
     * @return static
     */
    public static function setReferenceCode(string $referenceCode): static
    {
        self::$referenceCode = $referenceCode;

        return new static;
    }
}
