<?php
$data = '{
    "concepto":"Curso de PHP",
    "subtotal":"200",
    "id":"1"
}';

// Equivalente a insertar una tabla en SQL
$url = "https://productos-63048-default-rtdb.firebaseio.com/presupuestos.json";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_errno($ch);
} else {
    echo 'Se insertó correctamente';
}
?>