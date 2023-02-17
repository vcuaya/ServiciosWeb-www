<?php
namespace DataBase;

class MyFirebase
{
    private $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    private function runCurl($collection, $document)
    {
        $url = 'https://' . $this->project . '.firebaseio.com/' . $collection . '/' . $document . '.json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        // Se convierte a Object o NULL
        return json_decode($response);
    }

    public function isUserInDB($name)
    {
        $response = $this->runCurl('usuarios', $name);
        return (!is_null($response)) ? true : false;
    }

    public function obtainPassword($user)
    {
        $response = $this->runCurl('usuarios', $user);
        return $response;
    }

    public function isCategoryInDB($nombre)
    {
        $response = $this->runCurl('productos', $nombre);
        return (!is_null($response)) ? true : false;
    }

    public function obtainProducts($category)
    {
        $response = $this->runCurl('productos', $category);
        return $response;
    }

    public function isIsbnInDB($clave)
    {
        $response = $this->runCurl('detalles', $clave);
        return (!is_null($response)) ? true : false;
    }

    public function obtainDetails($isbn)
    {
        $response = $this->runCurl('detalles', $isbn);
        return $response;
    }

    public function obtainMessage($code)
    {
        $response = $this->runCurl('respuestas', $code);
        return $response;
    }
}
?>