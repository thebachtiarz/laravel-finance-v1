<?php

namespace TheBachtiarz\Finance\Traits\Model;

/**
 * Finance Scope Trait
 */
trait FinanceScopeTrait
{
    /**
     * Get user finance by account
     *
     * @param string $newAccountProposed
     * @return object|null
     */
    public function scopeGetByAccount($query, string $newAccountProposed): ?object
    {
        return $query->where('account_number', $newAccountProposed);
    }

    /**
     * Get user finance by year
     *
     * @param string $year
     * @return object|null
     */
    public function scopeGetByYear($query, string $year): ?object
    {
        return $query->whereYear('created_at', $year);
    }

    /**
     * Get user finance where active by condition
     *
     * @param boolean $active
     * @return object|null
     */
    public function scopeGetWhereActive($query, bool $active): ?object
    {
        return $query->where('is_active', $active);
    }
}
