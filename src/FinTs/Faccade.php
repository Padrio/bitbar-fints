<?php
declare(strict_types=1);

namespace App\FinTs;

use Exception;
use Fhp\FinTs;
use Fhp\Model\SEPAAccount;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
class Faccade
{

    /**
     * @var FinTs
     */
    private $finTs;

    public function __construct(FinTs $finTs)
    {
        $this->finTs = $finTs;
    }

    public function findSEPAAccountByNumber($accountNumber): ?SEPAAccount
    {
        try {
            $accounts = $this->finTs->getSEPAAccounts();
        } catch (Exception $exception) {
            return null;
        }

        foreach ($accounts as $account) {
            if ($account->getAccountNumber() == $accountNumber) {
                return $account;
            }
        }

        return null;
    }
}