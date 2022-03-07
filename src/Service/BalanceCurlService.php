<?php

namespace TheBachtiarz\Finance\Service;

use TheBachtiarz\Finance\Interfaces\{BalanceDataInterface, FinanceSystemInterface, UrlDomainInterface};
use TheBachtiarz\Finance\Traits\CurlBodyResolverTrait;
use TheBachtiarz\Toolkit\Helper\App\Converter\ConverterHelper;
use TheBachtiarz\Toolkit\Helper\App\Response\DataResponse;

class BalanceCurlService
{
    use CurlBodyResolverTrait, DataResponse, ConverterHelper;

    // ? Private Methods
    /**
     * create new transaction for finance account
     *
     * @param string $purposeCode
     * @param string $financeCode
     * @param string $mutationType allowed: [add, min]
     * @param string $creditAmount
     * @param string $information
     * @return array
     */
    public static function create(
        string $purposeCode,
        string $financeCode,
        string $mutationType,
        string $creditAmount,
        string $information
    ): array {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $mutationType = self::mutationTypeResolver($mutationType);
        $creditAmount = self::creditAmountResolver($mutationType, $creditAmount);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data'],
            FinanceSystemInterface::FINANCE_CONFIG_PURPOSE_CODE_NAME => $purposeCode,
            FinanceSystemInterface::FINANCE_CONFIG_FINANCE_CODE_NAME => $financeCode,
            FinanceSystemInterface::FINANCE_CONFIG_MUTATION_NAME => $mutationType,
            FinanceSystemInterface::FINANCE_CONFIG_CREDIT_CODE_NAME => $creditAmount,
            FinanceSystemInterface::FINANCE_CONFIG_INFORMATION_NAME => $information,
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_BALANCE_CREATE_NAME)->setData($_body)->post();
    }

    /**
     * get list latest finance account transaction from each purpose
     *
     * @param string $purposeCode
     * @return array
     */
    public static function listLastEachPurpose(string $purposeCode): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data'],
            FinanceSystemInterface::FINANCE_CONFIG_PURPOSE_CODE_NAME => $purposeCode
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_BALANCE_LISTPURPOSE_NAME)->setData($_body)->post();
    }

    /**
     * get finance account list transaction(s) from purpose
     *
     * @param string $purposeCode
     * @param string $financeCode
     * @param string $dateRange
     * @return array
     */
    public static function listTransactions(
        string $purposeCode,
        string $financeCode,
        string $dateRange = ""
    ): array {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data'],
            FinanceSystemInterface::FINANCE_CONFIG_PURPOSE_CODE_NAME => $purposeCode,
            FinanceSystemInterface::FINANCE_CONFIG_FINANCE_CODE_NAME => $financeCode,
        ];

        if (iconv_strlen($dateRange))
            $_body = array_merge([
                $_body,
                [FinanceSystemInterface::FINANCE_CONFIG_DATE_RANGE_NAME => $dateRange]
            ]);

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_BALANCE_LIST_NAME)->setData($_body)->post();
    }

    /**
     * get detail finance account transaction by reference code
     *
     * @param string $referenceCode
     * @return array
     */
    public static function detail(string $referenceCode): array
    {
        $ownerResolver = self::ownerCodeResolve();

        if (!$ownerResolver['status'])
            return self::errorResponse($ownerResolver['message']);

        $_body = [
            FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME => $ownerResolver['data'],
            FinanceSystemInterface::FINANCE_CONFIG_BALANCE_REFERENCE_NAME => $referenceCode
        ];

        return CurlService::setUrl(UrlDomainInterface::URL_DOMAIN_BALANCE_DETAIL_NAME)->setData($_body)->post();
    }

    // ? Private Methods
    /**
     * mutation type resolver
     *
     * @param string $mutationType
     * @return string
     * @throws \Throwable
     */
    private static function mutationTypeResolver(string $mutationType): string
    {
        try {
            throw_if(
                !in_array($mutationType, BalanceDataInterface::BALANCE_DATA_MUTATION_TYPE_ALLOWED),
                'Exception',
                "Mutation type not allowed"
            );

            return $mutationType;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * credit amount resolver
     *
     * @param string $mutationType
     * @param string $creditAmount
     * @return string
     * @throws \Throwable
     */
    private static function creditAmountResolver(string $mutationType, string $creditAmount): string
    {
        try {
            /**
             * mutation type -> add
             */
            if ($mutationType === BalanceDataInterface::BALANCE_DATA_MUTATION_TYPE_ADD_CODE) {
                /**
                 * check for rule credit amount minimal
                 */
                throw_if(
                    (int) $creditAmount < BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_SAVE_MINIMAL,
                    'Exception',
                    "Amount of credit nominal cannot less than " . self::setRupiah(BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_SAVE_MINIMAL)
                );

                /**
                 * check the rule of credit, cannot add more than rule of amount
                 */
                throw_if(
                    (int) $creditAmount > BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_SAVE_MAXIMAL,
                    'Exception',
                    "Amount of credit nominal cannot more than " . self::setRupiah(BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_SAVE_MAXIMAL)
                );
            }

            /**
             * mutation type -> min
             */
            if ($mutationType === BalanceDataInterface::BALANCE_DATA_MUTATION_TYPE_MIN_CODE) {
                /**
                 * check for rule debit amount minimal
                 */
                throw_if(
                    (int) $creditAmount < BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_TAKE_MINIMAL,
                    'Exception',
                    "Amount of credit nominal cannot less than " . self::setRupiah(BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_TAKE_MINIMAL)
                );

                /**
                 * check the rule of credit, cannot take more than rule of amount
                 */
                throw_if(
                    (int) $creditAmount > BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_TAKE_MAXIMAL,
                    'Exception',
                    "Amount of credit nominal cannot more than " . self::setRupiah(BalanceDataInterface::BALANCE_DATA_RULE_AMOUNT_TAKE_MAXIMAL)
                );
            }

            return $creditAmount;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
