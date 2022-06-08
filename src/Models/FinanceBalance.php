<?php

namespace TheBachtiarz\Finance\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TheBachtiarz\Finance\Traits\Model\{FinanceBalanceMapTrait, FinanceBalanceScopeTrait};

class FinanceBalance extends Model
{
    use SoftDeletes;

    use FinanceBalanceMapTrait, FinanceBalanceScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['finance_id', 'reference'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    // ? Relation
    public function finance(): BelongsTo
    {
        return $this->belongsTo(Finance::class);
    }
}
