<?php

namespace App\Service;

interface RessourceInterface {
    
    public function get($id, $soapClient);

    public function add();

    public function update($id, $soapClient);

    public function delete($id, $soapClient);
    
}