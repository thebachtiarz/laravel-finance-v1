<?php

namespace TheBachtiarz\Finance\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TheBachtiarz\Finance\Traits\Model\{FinanceMapTrait, FinanceScopeTrait};

class Finance extends Model
{
    use SoftDeletes;

    use FinanceMapTrait, FinanceScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'account_number', 'is_active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    // ? Relation
    public function user(): BelongsTo
    {
        return $this->belongsTo(tbauthgetusermodel(), 'user_id');
    }

    public function financebalances(): HasMany
    {
        return $this->hasMany(FinanceBalance::class);
    }

    public function financebalancelatest()
    {
        return $this->financebalances()->latest()->first();
    }

    public function financebalanceyesterday()
    {
        return $this->financebalances()->whereDate('created_at', today()->subDays(1))->latest()->first();
    }

    public function financebalancerangefromfirst(string $date)
    {
        return $this->financebalances()->whereDate('created_at', '<=', $date)->latest()->first();
    }

    public function financebalancetoday()
    {
        return $this->financebalances()->whereDate('created_at', today());
    }
}
