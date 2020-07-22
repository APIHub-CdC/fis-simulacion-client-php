<?php
namespace FIS\Simulacion\MX\Client;

use \FIS\Simulacion\MX\Client\ApiException;
use \FIS\Simulacion\MX\Client\Configuration;
use \FIS\Simulacion\MX\Client\ObjectSerializer;
use \FIS\Simulacion\MX\Client\Api\FISSimulacionApi as Instance;

use \GuzzleHttp\Client;
use \GuzzleHttp\Event\Emitter;
use \GuzzleHttp\Middleware;
use \GuzzleHttp\HandlerStack as handlerStack;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        $handler = handlerStack::create();

        $client = new Client(['handler' => $handler]);

        $config = new Configuration();
        $config->setHost('the_url');

        $this->apiInstance = new Instance($client, $config);
        $this->x_api_key = "your_api_key";
    } 
    
    public function testGetScoreNoHitDG()
    {
        $persona = new \FIS\Simulacion\MX\Client\Model\PersonaPeticion();
        $domicilio = new \FIS\Simulacion\MX\Client\Model\DomicilioPeticion();        
        $estado = new \FIS\Simulacion\MX\Client\Model\CatalogoEstados();
            
        $domicilio->setDireccion("SAN JOAQUIN");
        $domicilio->setColoniaPoblacion("EL ARENAL");
        $domicilio->setDelegacionMunicipio("IZTAPALAPA");
        $domicilio->setCiudad("MEXICO");
        $domicilio->setEstado($estado::CDMX);
        $domicilio->setCP("12345");

        $persona->setApellidoPaterno("OLIVOS");
        $persona->setApellidoMaterno("JIMENEZ");
        $persona->setApellidoAdicional(null);
        $persona->setPrimerNombre("JUAN");
        $persona->setSegundoNombre(null);
        $persona->setFechaNacimiento("1966-05-13");
        $persona->setRFC("CUPU800825569");
        $persona->setDomicilio($domicilio);
                
        try {
            $result = $this->apiInstance->getScoreNoHitDG($this->x_api_key, $persona);
            print_r($result);
            $this->assertTrue($result->getFolioConsulta()!==null);

            return $result->getFolioConsulta();
        } catch (Exception $e) {
            echo 'Exception when calling ApiTest->testGetScoreNoHitDG: ', $e->getMessage(), PHP_EOL;
        }
    } 
}     
