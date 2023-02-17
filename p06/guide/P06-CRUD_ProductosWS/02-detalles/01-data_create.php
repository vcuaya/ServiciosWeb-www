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
$coleccion = 'detalles';

$data = '{
    "9788445000663":{
		"Autor": "J. R. R. Tolkien",
		"Titulo": "El Señor de los Anillos I: La Comunidad del Anillo",
		"Editorial": "Booket",
		"Fecha": 2012,
		"Precio": 318,
		"Descuento" : 0.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9789708104678":{
		"Autor": "Isaac Asimov",
		"Titulo": "Los límites de la Fundación",
		"Editorial": "Debolsillo",
		"Fecha": 2008,
		"Precio": 528,
		"Descuento" : 0.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9786073118460":{
		"Autor": "Stephen King",
		"Titulo": "La Larga Marcha",
		"Editorial": "Debolsillo",
		"Fecha": 2013,
		"Precio": 399,
		"Descuento" : 0.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9781506712536":{
		"Autor": "John Arcudi (Author), Doug Mahnke (Artist)",
		"Titulo": "The Mask Omnibus Volume 1",
		"Editorial": "Dark Horse Books",
		"Fecha": 2019,
		"Precio": 599.8,
		"Descuento" : 5.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9781534319356":{
		"Autor": "Todd McFarlane (Author, Artist), Alan Moore (Author), Grant Morrison (Author), Frank Miller (Author), Greg Capullo (Artist), Tony Daniel (Artist), Marc Silvestri (Artist)",
		"Titulo": "Spawn Compendium Volume 1",
		"Editorial": "Image Comics",
		"Fecha": 2021,
		"Precio": 939.8,
		"Descuento" : 3.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9781951087302":{
		"Autor": "Joe Brusha (Author), Patrick Shand (Author), Brian Hawkins (Author)",
		"Titulo": "Van Helsing: Eve of Oblivion",
		"Editorial": "Zenescope",
		"Fecha": 2022,
		"Precio": 399.8,
		"Descuento" : 10.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9781421580364":{
		"Autor": "Sui Ishida",
		"Titulo": "Tokyo Ghoul",
		"Editorial": "VIZ Media LLC",
		"Fecha": 2015,
		"Precio": 220.8,
		"Descuento" : 0.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9781646090327":{
		"Autor": " Shinichi Fukuda (Author) ",
		"Titulo": "My Dress-Up Darling 01",
		"Editorial": "Square Enix Manga",
		"Fecha": 2020,
		"Precio": 199.8,
		"Descuento" : 0.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "9781421520544":{
		"Autor": "Takehiko Inoue (Author, Creator)",
		"Titulo": "Vagabond, Vol. 1",
		"Editorial": "VIZ Media LLC",
		"Fecha": 2008,
		"Precio": 244,
		"Descuento" : 0.00
	}
}';

$res = create_document($proyecto, $coleccion, $data);
if (!is_null($res)) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}
?>