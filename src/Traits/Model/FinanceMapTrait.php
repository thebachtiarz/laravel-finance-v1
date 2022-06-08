<?php

namespace TheBachtiarz\Finance\Traits\Model;

use TheBachtiarz\Finance\Helpers\FinanceHelper;
use TheBachtiarz\Toolkit\Helper\Model\ModelMapTrait;

/**
 * Finance Map Trait
 */
trait FinanceMapTrait
{
    use ModelMapTrait;

    /**
     * Finance simple list map
     *
     * @return array
     */
    public function simpleListMap(): array
    {
        return [
            'finance_account' => FinanceHelper::limitCodeDisplay($this->account_number),
            'is_active' => (bool) $this->is_active,
        ] + $this->getId() + $this->getTimestamps();
    }
}
