<?php
use Database\MyFirebase;

//header("Content-Type: text/xml; charset=UTF-8\r\n");
ini_set("log_errors", 1);
ini_set("error_log", "reportes/php-error-producto.log");

//require_once 'nusoap/lib/nusoap.php';		//PHP v7.4.x o inferior
require_once 'vendor/autoload.php';
require_once 'firebase.php';

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
TIPO COMPLEJO PARA LA RESPUESTA DE gegtProd
*/
$server->wsdl->addComplexType(
    'RespuestaGetProd',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'code' => ['name' => 'code', 'type' => 'xsd:string'],
        'message' => ['name' => 'message', 'type' => 'xsd:string'],
        'data' => ['name' => 'data', 'type' => 'xsd:string'],
        'status' => ['name' => 'status', 'type' => 'xsd:string']
    )
);

/**
TIPO COMPLEJO PARA LA RESPUESTA DE gegtDetails
*/
$server->wsdl->addComplexType(
    'RespuestaGetDetails',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'code' => ['name' => 'code', 'type' => 'xsd:string'],
        'message' => ['name' => 'message', 'type' => 'xsd:string'],
        'data' => ['name' => 'data', 'type' => 'xsd:string'],
        'status' => ['name' => 'status', 'type' => 'xsd:string'],
        'offer' => ['name' => 'offer', 'type' => 'xsd:boolean']
    )
);

/**
REGISTRO DE LA OPERACIÓN getProd EN LA INTERFAZ DEL SERVICIO (WSDL)
*/
$server->register(
    // Nombre de la operación (método)
    'getProd',
    // Lista de parámetros; varios de tipo simple o un tipo complejo
    array(
        'user' => 'xsd:string',
        'pass' => 'xsd:string',
        'categoria' => 'xsd:string'
    ),
    // Respuesta; de tipo simple o de tipo complejo
    // array('return' => 'xsd:string'),
    array('return' => 'tns:RespuestaGetProd'),
    // Namespace para entradas (input) y salidas (output)
    'urn:producto',
    // Nombre de la acción (soapAction)
    'urn:producto#getProd',
    // Estilo de comunicación (rpc|document)
    'rpc',
    // Tipo de uso (encoded|literal)
    'encoded',
    // Documentación o descripción del método
    'Nos da una lista de productos de cada categoría.'
);

/**
REGISTRO DE LA OPERACIÓN getDetails EN LA INTERFAZ DEL SERVICIO (WSDL)
*/
$server->register(
    // Nombre de la operación (método)
    'getDetails',
    // Lista de parámetros; varios de tipo simple o un tipo complejo
    array(
        'user' => 'xsd:string',
        'pass' => 'xsd:string',
        'isbn' => 'xsd:string'
    ),
    // Respuesta; de tipo simple o de tipo complejo
    // array('return' => 'xsd:string'),
    array('return' => 'tns:RespuestaGetDetails'),
    // Namespace para entradas (input) y salidas (output)
    'urn:producto',
    // Nombre de la acción (soapAction)
    'urn:producto#getDetails',
    // Estilo de comunicación (rpc|document)
    'rpc',
    // Tipo de uso (encoded|literal)
    'encoded',
    // Documentación o descripción del método
    'Nos da una lista de detalles de cada producto.'
);

/**
VARIABLES GLOBALES
*/

$database = new MyFirebase('productos-63048-default-rtdb');

/**
IMPLEMENTACIÓN DE LA OPERACIÓN getProd
*/
function getProd($user, $pass, $categoria)
{
    try {
        global $productos, $usuarios, $respuestas, $database;

        $categoria = strtolower($categoria);

        $respuesta = array(
            'code' => 999,
            'message' => $database->obtainMessage(999),
            'data' => '',
            'status' => 'error'
        );

        if (strlen($user) != 0 && $database->isUserInDB($user)) {
            if ($database->obtainPassword($user) == md5($pass)) {
                if (strlen($categoria) != 0 && $database->isCategoryInDB($categoria)) {
                    $respuesta['code'] = 200;
                    $respuesta['message'] = $database->obtainMessage(200);
                    $respuesta['data'] = json_encode($database->obtainProducts($categoria), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    $respuesta['status'] = 'success';
                } else {
                    $respuesta['code'] = 300;
                    $respuesta['message'] = $database->obtainMessage(300);

                    error_log($respuesta['code']);
                    error_log($respuesta['message']);
                }
            } else {
                $respuesta['code'] = 501;
                $respuesta['message'] = $database->obtainMessage(501);

                error_log($respuesta['code']);
                error_log($respuesta['message']);
            }
        } else {
            $respuesta['code'] = 500;
            $respuesta['message'] = $database->obtainMessage(500);

            error_log($respuesta['code']);
            error_log($respuesta['message']);
        }

        return $respuesta;

    } catch (Exception $ex) {
        $respuesta = array(
            'code' => 999,
            'message' => $database->obtainMessage(999),
            'data' => '',
            'status' => 'error'
        );

        error_log($respuesta['code']);
        error_log($respuesta['message']);
    }
}

/**
IMPLEMENTACIÓN DE LA OPERACIÓN getDetails
*/

function getDetails($user, $pass, $isbn)
{
    try {
        global $detalles, $usuarios, $respuestas, $database;

        $respuesta = array(
            // Respuesta Default
            'code' => 999,
            'message' => $database->obtainMessage(999),
            'data' => '',
            'status' => 'error',
            'offer' => false
        );

        if (strlen($user) != 0 && $database->isUserInDB($user)) {
            if ($database->obtainPassword($user) == md5($pass)) {
                if (strlen($isbn) != 0 && $database->isIsbnInDB($isbn)) {
                    $respuesta["code"] = "201";
                    $respuesta["message"] = $database->obtainMessage(201);
                    $respuesta["data"] = json_encode($database->obtainDetails($isbn), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    $respuesta["status"] = "success";
                    $respuesta["offer"] = ($database->obtainDetails($isbn)->Descuento > 0) ? true : false;
                } else {
                    $respuesta['code'] = 301;
                    $respuesta['message'] = $database->obtainMessage(301);

                    error_log($respuesta['code']);
                    error_log($respuesta['message']);
                }
            } else {
                $respuesta['code'] = 501;
                $respuesta['message'] = $database->obtainMessage(501);

                error_log($respuesta['code']);
                error_log($respuesta['message']);
            }
        } else {
            $respuesta['code'] = 500;
            $respuesta['message'] = $database->obtainMessage(500);

            error_log($respuesta['code']);
            error_log($respuesta['message']);
        }

        return $respuesta;

    } catch (Exception $ex) {
        $respuesta = array(
            'code' => 999,
            'message' => $respuestas[999],
            'data' => $ex->getMessage(),
            'status' => 'error',
            'offer' => false
        );

        error_log($respuesta['code']);
        error_log($respuesta['message']);
    }
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