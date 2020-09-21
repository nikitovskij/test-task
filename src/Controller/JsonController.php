<?php

namespace App\Controller;

use App\ExternalApi\DataCollector;

class JsonController
{
    public function renderJson($request, $response, $args)
    {
        ['ico' => $ico] = $args;
        $data = DataCollector::collectCompanyDataByICO($ico);

        return $response->withJson($data, 201);
    }
}
