<?php

namespace App\Service;

abstract class Ressource {

    public function __construct($bouchonne)
    {
        $this->bouchonne = $bouchonne;
    }

    abstract public function getList($soapClient);

    abstract public function get($id, $soapClient);

    abstract public function add($obj, $soapClient);

    abstract public function update($id, $obj, $soapClient);

    abstract public function delete($id, $soapClient);

    public function convertResponseXML($path_xml)
    {
        $xml = file_get_contents($path_xml);
        //$xml = preg_replace('#[a-zA-Z0-9]+="[\#a-zA-Z0-9]+"#', '', $xml);
        $xml = simplexml_load_string($xml);
        $data = $xml->xpath("//SOAP-ENV:Body/*/*")[0];
        $arrayResult = json_decode(json_encode($data));
        return $arrayResult->item;
    }

}