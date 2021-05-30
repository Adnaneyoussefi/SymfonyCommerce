<?php

namespace App\Module1\WebService;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CustomSoapClient extends \SoapClient
{
    protected $ws_name;

    private $params;

    public function __construct(string $apikey, ParameterBagInterface $params)
    {
        parent::__construct($apikey);
        $this->params = $params;
    }
    
    /**
     * __call
     *
     * @param  string $function_name
     * @param  array $arguments
     * @return object
     */
    public function __call($function_name, $arguments)
    {
        $moduleName = explode("\\", get_called_class())[1];
        $result = [];
        $enabled = $this->params->get('bouchon.enabled');
        $active_uc = $this->params->get('bouchon.active_uc');
        $directory = $this->params->get('bouchon.directory');
        if ($enabled == true) {
            $xml_path = __DIR__.DIRECTORY_SEPARATOR.'..'
            .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'
            .DIRECTORY_SEPARATOR.$directory
            .DIRECTORY_SEPARATOR.$moduleName
            .DIRECTORY_SEPARATOR.$active_uc
            .DIRECTORY_SEPARATOR.$function_name.'.xml';

            if(file_exists($xml_path))
                $result = $this->convertResponseXML($xml_path);
            else
                throw new \Exception("Le fichier ".$xml_path." n'existe pas");

            dump(explode("\\", get_called_class())[1]);

        } else {
            $result = parent::__call($function_name, $arguments);
        }
        return $result;
    }
    
    /**
     * Convertir la réponse XML en objet
     *
     * @param  string $path_xml
     * @return array|object
     */
    public function convertResponseXML($path_xml)
    {
        try {
            $xml = file_get_contents($path_xml);
            $xml = simplexml_load_string($xml);
        
            $index = 0;
            //Vérifier si l'index existe dans le tableau
            if(array_key_exists($index, $xml->xpath("//SOAP-ENV:Body/*/*")))
                $data = $xml->xpath("//SOAP-ENV:Body/*/*")[$index];
            else
                throw new \Exception('L\'index '.$index.' n\'existe pas dans le tableau.');
            
            //$arrayResult = json_decode(json_encode($data));
            $arrayResult = [];
            if(!empty($data->children())) {
                foreach ($data->children() as $node) {
                    //Dans le cas de Récupérer la liste des éléments sous form array
                    if($data->children()->item)
                        array_push($arrayResult, (object)get_object_vars($node));
                    //Dans le cas de Récupérer un seul élément sous forme objet
                    elseif($data->children()) {
                        $arrayResult = $data;
                    }
                    else
                        throw new \Exception('Le résultat est null');
                } 
            }
            else {
                $arrayResult = null;
            }
            //$soap = new \Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
            //var_dump($soap->getListProduits());
            //var_dump($arrayResult);
            return $arrayResult;

        } catch(\Exception $e) {
            echo $e->getMessage()." ";
        }
    }
}