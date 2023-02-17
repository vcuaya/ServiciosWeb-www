<?php

function create_document($project, $collection, $document)
{
    $url = 'https://' . $project . '.firebaseio.com/' . $collection . '.json';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // en sustitución de curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    curl_close($ch);

    // Se convierte a Object o NULL
    return json_decode($response);
}

$proyecto = 'productos-63048-default-rtdb';
$coleccion = 'productos';

$data = '{
	"libros":{
		"9788445000663": "El Señor de los Anillos I: La Comunidad del Anillo",
		"9789708104678": "Los límites de la Fundación",
		"9786073118460": "La Larga Marcha"
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "comics":{
		"9781506712536": "The Mask Omnibus Volume 1",
		"9781534319356": "Spawn Compendium Volume 1",
		"9781951087302": "Van Helsing: Eve of Oblivion"
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "mangas":{
		"9781421580364": "Tokyo Ghoul",
		"9781646090327": "My Dress-Up Darling 01",
		"9781421520544": "Vagabond, Vol. 1"
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}
?>