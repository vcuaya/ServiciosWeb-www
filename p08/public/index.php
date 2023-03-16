<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/serviciosweb/p08/public");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get("/hola[/{nombre}]", function ($request, $response, $args) {
    $response->write("Hola, " . $args["nombre"]);
    return $response;
});

$app->post("/pruebapost", function ($request, $response, $args) {
    $reqPost = $request->getParsedBody();
    $val1 = $reqPost["val1"];
    $val2 = $reqPost["val2"];

    $response->write("Valores: " . $val1 . " " . $val2);
    return $response;
});

$app->get("/testjson", function ($request, $response, $args) {
    $data[0]["nombre"] = "Kaiser";
    $data[0]["apellidos"] = "EkSha";
    $data[1]["nombre"] = "Víctor";
    $data[1]["apellidos"] = "Cuaya";

    $response->write(json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response;
});

$app->post("/testjson", function ($request, $response, $args) {
    $reqPost = $request->getParsedBody();

    $data[0]["nombre"] = $reqPost["name1"];
    $data[0]["apellidos"] = $reqPost["lastName1"];
    $data[1]["nombre"] = $reqPost["name2"];
    $data[1]["apellidos"] = $reqPost["lastName2"];

    $response->write(json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response;
});

$app->run();