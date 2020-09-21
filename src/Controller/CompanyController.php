<?php

namespace App\Controller;

use AsisTeam\ARES\Client\Finder;
use App\ExternalApi\DataCollector;
use Psr\Container\ContainerInterface;

class CompanyController
{
    protected $container;
    protected $ares;

    public function __construct(ContainerInterface $container, Finder $ares)
    {
        $this->container = $container;
        $this->ares      = $ares;
    }

    public function index($request, $response, $args)
    {
        return $this->container->get('renderer')->render($response, 'index.phtml');
    }

    public function getCompany($request, $response, $args)
    {
        $ico  = $request->getParsedBodyParam('ico');
        $data = DataCollector::collectCompanyDataByICO($ico);

        if (isset($data['error'])) {
            return $this->container->get('renderer')->render($response, 'index.phtml', $data);
        }

        return $this->container->get('renderer')->render($response, 'show.phtml', $data);
    }
}
