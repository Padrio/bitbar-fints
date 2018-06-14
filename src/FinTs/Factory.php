<?php
declare(strict_types=1);

namespace App\FinTs;

use Fhp\FinTs;

/**
 * @author Pascal Krason <p.krason@padr.io>
 */
class Factory
{
    public static function createFromArray(array $config): FinTs
    {
        return new FinTs(
            $config['fints']['server'],
            $config['fints']['port'],
            $config['credentials']['bankcode'],
            $config['credentials']['username'],
            $config['credentials']['pin']
        );
    }
}