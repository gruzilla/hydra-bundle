<?php

namespace Hydra\HydraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Hydra\Commands\ExpirationCommandTrait,
    Hydra\Common\Helper\ExpirationHelper;

class ExpirationCommand extends ContainerAwareCommand
{
    use ExpirationCommandTrait;

    protected function getExpirationHelper()
    {
        // create and load hydra
        $storage = $this->getContainer()->get('hydra.storage');
        $hydra = $this->getContainer()->get('hydra.service');

        $expirationHelper = new ExpirationHelper(
            $hydra,
            $storage
        );

        return $expirationHelper;
    }
}