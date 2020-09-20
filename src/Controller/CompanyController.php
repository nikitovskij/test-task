<?php

namespace App\Controller;

use AsisTeam\ARES\Client\Finder;
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

    public function find($request, $response, $args)
    {
        $ico     = $request->getQueryParam('ico');
        $company = $this->ares->findById($ico);
        
        if ($company === null) {
            $data = [
                'error' => 'Company not found'
            ];
        } else {
            $data = $this->getPreparedData($company);
        }
        
        // $res = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        return $this->container->get('renderer')->render($response, 'index.phtml', $data);
    }

    public function renderJson($request, $response, $args)
    {
        //$response->withJason();
        return false;
    }

    public function getPreparedData($company)
    {
        return [
            'ico'        => $company->getVatId(),
            'name'       => $company->getName(),
            'legal_form' => $company->getLegalFormName(),
            'address'    => $company->getAddress()
        ];
    }
}
