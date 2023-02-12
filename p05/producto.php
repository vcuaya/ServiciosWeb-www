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
        'oferta' => ['name' => 'oferta', 'type' => 'xsd:boolean']
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
    'Nos da los detalles de un producto.'
);

/**
VARIABLES GLOBALES
*/

$productos = array(
    //ARREGLO DE PRODUCTOS
    'libros' => [
        '9788445000663' => 'El Señor de los Anillos I: La Comunidad del Anillo',
        '9789708104678' => 'Los límites de la Fundación',
        '9786073118460' => 'La Larga Marcha'
    ],
    'comics' => [
        '9781506712536' => 'The Mask Omnibus Volume 1',
        '9781534319356' => 'Spawn Compendium Volume 1',
        '9781951087302' => 'Van Helsing: Eve of Oblivion'
    ],
    'mangas' => [
        '9781421580364' => 'Tokyo Ghoul',
        '9781646090327' => 'My Dress-Up Darling 01',
        '9781421520544' => 'Vagabond, Vol. 1'
    ]
);

$detalles = array(
    //ARREGLO DE DETALLES
    '9788445000663' => [
        'Autor' => 'J. R. R. Tolkien',
        'Titulo' => 'El Señor de los Anillos I: La Comunidad del Anillo',
        'Editorial' => 'Booket',
        'Fecha' => 2012,
        'Precio' => 318.00,
        'Oferta' => false
    ],
    '9789708104678' => [
        'Autor' => 'Isaac Asimov',
        'Titulo' => 'Los límites de la Fundación',
        'Editorial' => 'Debolsillo',
        'Fecha' => 2008,
        'Precio' => 528.00,
        'Oferta' => false
    ],
    '9786073118460' => [
        'Autor' => 'Stephen King',
        'Titulo' => 'La Larga Marcha',
        'Editorial' => 'Debolsillo',
        'Fecha' => 2013,
        'Precio' => 399.00,
        'Oferta' => false
    ],
    '9781506712536' => [
        'Autor' => 'John Arcudi (Author), Doug Mahnke (Artist)',
        'Titulo' => 'The Mask Omnibus Volume 1',
        'Editorial' => 'Dark Horse Books',
        'Fecha' => 2019,
        'Precio' => 599.80,
        'Oferta' => true
    ],
    '9781534319356' => [
        'Autor' => 'Todd McFarlane (Author, Artist), Alan Moore (Author), Grant Morrison (Author), Frank Miller (Author), Greg Capullo (Artist), Tony Daniel (Artist), Marc Silvestri (Artist)',
        'Titulo' => 'Spawn Compendium Volume 1',
        'Editorial' => 'Image Comics',
        'Fecha' => 2021,
        'Precio' => 939.80,
        'Oferta' => true
    ],
    '9781951087302' => [
        'Autor' => 'Joe Brusha (Author), Patrick Shand (Author), Brian Hawkins (Author)',
        'Titulo' => 'Van Helsing: Eve of Oblivion',
        'Editorial' => 'Zenescope',
        'Fecha' => 2022,
        'Precio' => 399.80,
        'Oferta' => true
    ],
    '9781421580364' => [
        'Autor' => 'Sui Ishida',
        'Titulo' => 'Tokyo Ghoul',
        'Editorial' => 'VIZ Media LLC',
        'Fecha' => 2015,
        'Precio' => 220.80,
        'Oferta' => false
    ],
    '9781646090327' => [
        'Autor' => ' Shinichi Fukuda (Author) ',
        'Titulo' => 'My Dress-Up Darling 01',
        'Editorial' => 'Square Enix Manga',
        'Fecha' => 2020,
        'Precio' => 199.80,
        'Oferta' => false
    ],
    '9781421520544' => [
        'Autor' => 'Takehiko Inoue (Author, Creator)',
        'Titulo' => 'Vagabond, Vol. 1',
        'Editorial' => 'VIZ Media LLC',
        'Fecha' => 2008,
        'Precio' => 244.00,
        'Oferta' => false
    ]
);

$respuestas = array(
    // ARREGLO DE RESPUESTAS
    200 => 'Categoría encontrada exitosamente.',
    201 => 'ISBN encontrado exitosamente.',
    300 => 'Categoría no encontrada.',
    301 => 'ISBN no encontrado.',
    500 => 'Usuario no reconocido.',
    501 => 'Password no reconocido.',
    999 => 'Error no identificado'
);

$usuarios = array(
    // ARRELGO DE USUARIOS
    'pruebas1' => 'de88e3e4ab202d87754078cbb2df6063',
    'pruebas2' => '6796ebbb111298d042de1a20a7b9b6eb',
    'pruebas3' => 'f7e999012e3700d47e6cb8700ee9cf19',
);

/**
IMPLEMENTACIÓN DE LA OPERACIÓN getProd
*/
function getProd($user, $pass, $string)
{
    try {
        global $productos, $usuarios, $respuestas;

        $categoria = strtolower($string);
        $respuesta = '';

        if (array_key_exists($user, $usuarios)) {
            if ($usuarios[$user] == md5($pass)) {
                if (array_key_exists($categoria, $productos)) {
                    $respuesta = array(
                        'code' => 200,
                        'message' => $respuestas[200],
                        'data' => json_encode($productos[$categoria], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                        'status' => 'success'
                    );
                } else {
                    $respuesta = array(
                        'code' => 300,
                        'message' => $respuestas[300],
                        'data' => $categoria,
                        'status' => 'error'
                    );

                    error_log($respuesta);
                }
            } else {
                $respuesta = array(
                    'code' => 501,
                    'message' => $respuestas[501],
                    'data' => '',
                    'status' => 'error'
                );

                error_log($respuesta);
            }
        } else {
            $respuesta = array(
                'code' => 500,
                'message' => $respuestas[500],
                'data' => $user,
                'status' => 'error'
            );

            error_log($respuesta);
        }

        return $respuesta;

    } catch (Exception $ex) {
        $respuesta = array(
            'code' => 999,
            'message' => $respuestas[999],
            'data' => '',
            'status' => 'error'
        );

        error_log($respuesta);
    }
}

/**
IMPLEMENTACIÓN DE LA OPERACIÓN getDetails
*/

function getDetails($user, $pass, $isbn)
{
    try {
        global $detalles, $usuarios, $respuestas;

        $respuesta = '';

        if (array_key_exists($user, $usuarios)) {
            if ($usuarios[$user] == md5($pass)) {
                if (array_key_exists($isbn, $detalles)) {
                    $respuesta = array(
                        'code' => 201,
                        'message' => $respuestas[201],
                        'data' => json_encode($detalles[$isbn], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                        'status' => 'success'
                    );
                } else {
                    $respuesta = array(
                        'code' => 301,
                        'message' => $respuestas[301],
                        'data' => $isbn,
                        'status' => 'error'
                    );

                    error_log($respuesta);
                }
            } else {
                $respuesta = array(
                    'code' => 501,
                    'message' => $respuestas[501],
                    'data' => '',
                    'status' => 'error'
                );

                error_log($respuesta);
            }
        } else {
            $respuesta = array(
                'code' => 500,
                'message' => $respuestas[500],
                'data' => $user,
                'status' => 'error'
            );

            error_log($respuesta);
        }

        return $respuesta;

    } catch (Exception $ex) {
        $respuesta = array(
            'code' => 999,
            'message' => $respuestas[999],
            'data' => $ex->getMessage(),
            'status' => 'error'
        );

        error_log($respuesta);
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