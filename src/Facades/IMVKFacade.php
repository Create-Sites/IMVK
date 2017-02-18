<?php

namespace CreateSites\IMVK\Facades;

use Illuminate\Support\Facades\Facade;

class IMVKFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'IM_VK';
    }
}