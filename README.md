# fis-simulacion-client-php

FIS Desarrollado por Círculo de Crédito, es un Score que evalúa a personas sin historial crediticio que califica el nivel de cumplimiento de pago de un individuo considerando variables demográficas y factores de riesgo de crédito territorial.

## Requisitos

PHP 7.1 ó superior

### Dependencias adicionales

- Se debe contar con las siguientes dependencias de PHP:
  - ext-curl
  - ext-mbstring
- En caso de no ser así, para linux use los siguientes comandos

```sh
#ejemplo con php en versión 7.3 para otra versión colocar php{version}-curl
apt-get install php7.3-curl
apt-get install php7.3-mbstring
```

- Composer [vea como instalar][1]

## Instalación

Ejecutar: `composer install`

## Guía de inicio

### Paso 1. Agregar el producto a la aplicación

Al iniciar sesión seguir los siguientes pasos:

1.  Dar clic en la sección "**Mis aplicaciones**".
2.  Seleccionar la aplicación.
3.  Ir a la pestaña de "**Editar '@tuApp**' ".
    <p align="center">
      <img src="https://github.com/APIHub-CdC/imagenes-cdc/blob/master/edit_applications.jpg" width="900">
    </p>
4.  Al abrirse la ventana, seleccionar el producto.
5.  Dar clic en el botón "**Guardar App**":
    <p align="center">
      <img src="https://github.com/APIHub-CdC/imagenes-cdc/blob/master/selected_product.jpg" width="400">
    </p>

### Paso 2. Capturar los datos de la petición

Los siguientes datos a modificar se encuentran en **test/Api/ApiTest.php**

Es importante contar con el setUp() que se encargará de inicializar la url. Modificar la URL **('the_url')** de la petición del objeto **_\$config_**, como se muestra en el siguiente fragmento de código:

```php
public function setUp()
{
    $handler = handlerStack::create();
    $client = new Client(['handler' => $handler]);
    $config = new Configuration();
    $config->setHost('the_url');
    $this->apiInstance = new Instance($client, $config);
    $this->x_api_key = "your_api_key";
}
/**
* Este es el método que se será ejecutado en la prueba ubicado en path/to/repository/test/Api/ApiTest.php
*/
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
```

## Pruebas unitarias

Para ejecutar las pruebas unitarias:

```sh
./vendor/bin/phpunit
```

[1]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
