<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GlobalController extends AbstractController{

    public function __construct()
    {
        $moduleName = explode("\\", get_called_class())[1];
        define('MODULE_NAME', $moduleName);
    }
}