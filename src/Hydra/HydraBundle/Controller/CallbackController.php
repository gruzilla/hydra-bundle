<?php

namespace Hydra\HydraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CallbackController extends Controller
{
    /**
     * @Route("/hydra/callback/{serviceName}", name="_hydra_redirect")
     */
    public function indexAction($serviceName = '')
    {
        if (empty($serviceName)) {
            echo 'please provide a service name in the url!';
            exit;
        }

        $storage = $this->get('hydra.storage');
        $serviceProvider = $this->get('hydra.service_provider');

        try {
            $service = $serviceProvider->createService($serviceName);
            $serviceProvider->retrieveAccessToken($serviceName, $_REQUEST);

            echo 'Access token stored!';
        } catch (\Exception $e) {
            echo 'ERROR: ' .$e;
        }

        exit;
    }
}