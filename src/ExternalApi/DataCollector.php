<?php

namespace App\ExternalApi;

use AsisTeam\ARES\Client\Finder;

class DataCollector
{
    public static function collectCompanyDataByICO(int $ico)
    {
        $ares = new Finder();
        $companyInfo = $ares->findById($ico);
        
        return self::prepareData($companyInfo);
    }

    private static function prepareData($company)
    {
        if ($company === null) {
            return ['error' => 'Company not exists'];
        }

        return [
            'ico'       => $company->getVatId(),
            'name'      => $company->getName(),
            'legalForm' => $company->getLegalFormName(),
            'address'   => $company->getAddress()
        ];
    }
}
