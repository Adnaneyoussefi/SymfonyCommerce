<?php

namespace App\Service;

interface RessourceInterface {
    
    public function get($id, $soapClient);

    public function add($obj, $soapClient);

    public function update($id, $obj, $soapClient);

    public function delete($id, $soapClient);
    
}