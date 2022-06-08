<?php

namespace TheBachtiarz\Finance\Traits\Model;

use Interfaces\Data\Finance\FinanceRuleDataInterface;

/**
 * Finance Balance Scope Trait
 */
trait FinanceBalanceScopeTrait
{
    /**
     * Get finance balance by date
     *
     * @param string|null $date
     * @return object|null
     */
    public function scopeGetByDate($query, ?string $date = null): ?object
    {
        $date = $date ?: today();

        return $query->whereDate('created_at', $date);
    }

    /**
     * Get finance balance by last days
     *
     * @param integer $accountId
     * @param integer $days
     * @return object|null
     */
    public function scopeGetByLastDays($query, int $accountId, int $days = FinanceRuleDataInterface::FINANCE_RULE_BALANCE_LIST_LIMIT_DAYS): ?object
    {
        return $query->where('finance_id', $accountId)->where('created_at', '>=', self::dbGetFullDateSubDays($days));
    }

    /**
     * Get finance balance order by date.
     *
     * @param string $orderBy default: asc
     * @return object|null
     */
    public function scopeOrderByDate($query, string $orderBy = 'asc'): ?object
    {
        return $query->orderBy('created_at', $orderBy);
    }

    /**
     * Get finance balance each latest
     *
     * @return object|null
     */
    public function scopeGetEachLatest($query): ?object
    {
        $_eachLatestIds = [];

        $_userFinanceIds = [];

        foreach ($this->orderByDate('desc')->get() as $key => $financeBalance) {
            if (in_array($financeBalance->finance_id, $_userFinanceIds)) continue;

            $_userFinanceIds[] = $financeBalance->finance_id;
            $_eachLatestIds[] = $financeBalance->id;
        }

        return $query->whereIn('id', $_eachLatestIds)->orderBy('id');
    }
}
