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
    $server->register( 'getProd',                               // Nombre de la operación (método)
                        array('categoria' => 'xsd:string'),     // Lista de parámetros; varios de tipo simple o un tipo complejo
                        array('return' => 'xsd:string'),        // Respuesta; de tipo simple o de tipo complejo
                        'urn:producto',                         // Namespace para entradas (input) y salidas (output)
                        'urn:producto#getProd',                 // Nombre de la acción (soapAction)
                        'rpc',                                  // Estilo de comunicación (rpc|document)
                        'encoded',                              // Tipo de uso (encoded|literal)
                        'Nos da una lista de productos de cada categoría.'  // Documentación o descripción del método
                     );

    /**
        IMPLEMENTACIÓN DE LA OPERACIÓN getProd
    */
    function getProd($categoria) {
    	$respuesta = ''; 

        if ($categoria == "libros") {
            $respuesta = join("|", array("El señor de los anillos",
                                   "Los límites de la Fundación",
                                   "The Rails Way"));
        } else {
            $respuesta = "No hay productos de esta categoria";
            error_log('categoria: '.$categoria);
            error_log('error: '.$respuesta);
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