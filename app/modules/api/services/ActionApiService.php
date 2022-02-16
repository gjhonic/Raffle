<?php

namespace app\modules\api\services;

use app\models\base\Address;
use app\modules\api\models\ActionApi;
use app\modules\api\models\MethodsApi;

class ActionApiService
{
    /**
     * @param string $ipAddress
     * @param string $method
     * @param string $version
     * @return bool
     */
    public static function addLogUseApi(string $ipAddress, string $method, string $version): bool
    {
        $address = Address::getAddress($ipAddress);

        if (in_array($method, MethodsApi::getMethods()) && in_array($version, MethodsApi::getVersion())) {

            $actionApi = new ActionApi();
            $actionApi->address_id = $address->id;
            $actionApi->method = $method;
            $actionApi->version = $version;
            return $actionApi->save();
        }
        return false;
    }
}