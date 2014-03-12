<?php

namespace Hydra\HydraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Hydra\Commands\ConfigCommandTrait,
    Hydra\Common\Helper\ConfigHelper;

class ConfigCommand extends ContainerAwareCommand
{
    use ConfigCommandTrait;

    protected function getConfigHelper($serviceName)
    {
        // create and load hydra
        $storage = $this->getContainer()->get('hydra.storage');
        $provider = $this->getContainer()->get('hydra.service_provider');

        $className = $this->getConfigHelperClassName($serviceName);

        return new $className(
            $storage,
            $provider,
            $serviceName
        );
   }
}