<?php
//header("Content-Type: text/xml; charset=UTF-8\r\n");
ini_set("log_errors", 1);
ini_set("error_log", "reportes/php-error-producto.log");

require_once 'vendor/autoload.php';
//require_once 'nusoap/lib/nusoap.php';		//PHP v7.4.x o inferior

/**
CREACIÓN Y CONFIGURACIÓN DEL OBJETO QUE DEFINIRÁ EL SERVICIO WEB TIPO SOAP
*/
$server = new soap_server();
/*
configureWSDL('Nombre del Servicio', 'targetNamespace');
targetNamespace: Hacemos que el esquema que estamos creando tenga asociado un espacio 
de nombres propio (target namespace). Para ello se puede utilizar el 
atributo targetNamespace del elemento "schema":
*/
$server->configureWSDL('WebServicesBUAP', 'urn:buap_api');
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->encode_utf8 = true;

/**
REGISTRO DE LA OPERACIÓN getProd EN LA INTERFAZ DEL SERVICIO (WSDL)
*/
$server->register(
    'getProd',
    // Nombre de la operación (método)
    array('categoria' => 'xsd:string'),
    // Lista de parámetros; varios de tipo simple o un tipo complejo
    array('return' => 'xsd:string'),
    // Respuesta; de tipo simple o de tipo complejo
    'urn:producto',
    // Namespace para entradas (input) y salidas (output)
    'urn:producto#getProd',
    // Nombre de la acción (soapAction)
    'rpc',
    // Estilo de comunicación (rpc|document)
    'encoded',
    // Tipo de uso (encoded|literal)
    'Nos da una lista de productos de cada categoría.' // Documentación o descripción del método
);

/**
VARIABLE GLOBAL
*/

$productos = array(
    //ARREGLO DE PRODUCTOS
    'libros' => [
        'LIB001' => 'El señor de los anillos',
        'LIB002' => 'Los límites de la Fundación',
        'LIB003' => 'The Rails Way'
    ],
    'comics' => [
        'COM001' => 'The Mask Omnibus Volume 1',
        'COM002' => 'Spawn Compendium Volume 1',
        'COM003' => 'Van Helsing: Eve of Oblivion'
    ],
    'mangas' => [
        'MAN001' => 'Tokyo Ghoul',
        'MAN002' => 'My Dress-Up',
        'MAN003' => 'Vagabond'
    ]
);

/**
IMPLEMENTACIÓN DE LA OPERACIÓN getProd
*/
function getProd($str)
{
    global $productos;
    $categoria = strtolower($str);
    $respuesta = '';

    switch ($categoria) {
        case "libros":
            // $respuesta = join(
            //     "|",
            //     array(
            //         "El señor de los anillos",
            //         "Los límites de la Fundación",
            //         "The Rails Way"
            //     )
            // );
            $respuesta = json_encode($GLOBALS[$productos['libros']]);
            break;
        case "comics":
            // $respuesta = join(
            //     "|",
            //     array(
            //         "The Mask Omnibus Volume 1",
            //         "Spawn Compendium Volume 1",
            //         "Van Helsing: Eve of Oblivion"
            //     )
            // );
            break;
        case "mangas":
            // $respuesta = join(
            //     "|",
            //     array(
            //         "Tokyo Ghoul",
            //         "My Dress-Up",
            //         "Vagabond"
            //     )
            // );
            break;
        default:
            $respuesta = "No hay productos de esta categoria";
            error_log('categoria: ' . $categoria);
            error_log('error: ' . $respuesta);
    }

    return $respuesta;
}
/**
EXPOSICIÓN DEL SERVICIO (WSDL)
*/
// Exposición del servicio (WSDL)
//$data = !empty($HTTP_RAW_POST_DATA)?$HTTP_RAW_POST_DATA:'';
//@$server->service($data);

// Exposición del servicio (WSDL) PHP v7.2 o superior
@$server->service(file_get_contents("php://input"));
?>