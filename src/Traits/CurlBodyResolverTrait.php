<?php

namespace TheBachtiarz\Finance\Traits;

use TheBachtiarz\Finance\Interfaces\FinanceSystemInterface;

/**
 * Owner Code Resolver Trait
 */
trait CurlBodyResolverTrait
{
    /**
     * owner code
     *
     * @var ?string
     */
    protected static ?string $ownerCode = null;

    // ? Private Methods
    /**
     * resolve owner code for body curl process
     *
     * @return array
     */
    private static function ownerCodeResolve(): array
    {
        $result = ['status' => false, 'data' => null, 'message' => ''];

        try {
            throw_if(tbfinanceconfig('is_multi_owner') && !self::$ownerCode, 'Exception', "Owner code required");

            $ownerCode = tbfinanceconfig('is_multi_owner')
                ? self::$ownerCode
                : tbfinanceconfig(FinanceSystemInterface::FINANCE_CONFIG_OWNER_CODE_NAME);

            $result['status'] = true;
            $result['data'] = $ownerCode;
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();
        } finally {
            return $result;
        }
    }

    // ? Setter Modules
    /**
     * Set owner code
     *
     * @param string $ownerCode owner code
     * @return self
     */
    public static function setOwnerCode(string $ownerCode): self
    {
        self::$ownerCode = $ownerCode;

        return new self;
    }
}
