<?php
declare(strict_types=1);

namespace App;

use App\FinTs\Faccade as FinTsFaccade;
use App\FinTs\Factory as FinTsFactory;
use DateTime;
use Fhp\FinTs;
use Fhp\Model\SEPAAccount;
use Fhp\Model\StatementOfAccount\Transaction;

class Banking
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @var FinTs
     */
    private $finTs;

    /**
     * @var FinTsFaccade
     */
    private $faccade;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    private function getFinTs(): FinTs
    {
        if(!$this->finTs) {
            $this->finTs = FinTsFactory::createFromArray($this->config);
        }

        return $this->finTs;
    }

    private function getFaccade(): FinTsFaccade
    {
        if(!$this->faccade) {
            $this->faccade = new FinTsFaccade($this->getFinTs());
        }

        return $this->faccade;
    }

    private function getAccount(): ?SEPAAccount
    {
        $accountNumber = $this->config['account']['number'];
        return $this->getFaccade()->findSEPAAccountByNumber($accountNumber);
    }

    public function getSaldo(): ?string
    {
        $account = $this->getAccount();
        if(is_null($account)) {
            return null;
        }

        $saldo = $this->finTs->getSaldo($account);

        return sprintf(
            '%s %s',
            $saldo->getAmount(),
            $saldo->getCurrency()
        );
    }

    /**
     * @param int $limit
     *
     * @return Transaction[]
     */
    public function getTransactions(int $limit = 5)
    {
        $account = $this->getAccount();

        try {
            $response = $this->getFinTs()->getStatementOfAccount($account, new DateTime('-7 days'), new DateTime());
        } catch (\Exception $e) {
            return [];
        }

        $statement = $response->getStatements()[0] ?? null;
        if(is_null($statement)) {
            return [];
        }

        $transactions = $statement->getTransactions();
        $transactions = array_reverse($transactions);

        if(count($transactions) <= $limit) {
            return $transactions;
        }

        for($i = 0; $i < $limit; $i++) {
            yield $transactions[$i];
        }
    }
}