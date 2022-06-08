<?php

namespace TheBachtiarz\Finance\Traits\Model;

use TheBachtiarz\Toolkit\Helper\Model\ModelMapTrait;

/**
 * Finance Balance Map Trait
 */
trait FinanceBalanceMapTrait
{
    use ModelMapTrait;

    /**
     * Finance balance simple list map
     *
     * @return array
     */
    public function simpleListMap(): array
    {
        return [
            'reference' => $this->reference
        ] + $this->getId() + $this->getTimestamps();
    }
}
