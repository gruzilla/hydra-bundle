<?php

namespace Hydra\HydraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Hydra\Commands\RequestCommandTrait,
    Hydra\Common\Helper\RequestHelper;

class RequestCommand extends ContainerAwareCommand
{
    use RequestCommandTrait;

    protected function getRequestHelper()
    {
        $hydra = $this->getContainer()->get('hydra.service');
        $repositoryFactory = $this->getContainer()->get('hydra.repository_factory');

        return new RequestHelper(
            $hydra,
            $repositoryFactory
        );
    }
}