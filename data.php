<?php
// URL del XML
$url = 'https://www.ign.es/ign/RssTools/sismologia.xml';

// Cargar el XML
$xml = simplexml_load_file($url);

// Array para almacenar los terremotos
$terremotos = array();

// Recorrer los elementos "item"
foreach ($xml->channel->item as $item) {
    // Extraer los datos relevantes del elemento "title"
    $title = (string) $item->title;
    preg_match('/-Info\.terremoto: (\d{2}\/\d{2}\/\d{4}) (\d{1,2}:\d{2}:\d{2})/', $title, $matches);
    $date = $matches[1];
    $time = $matches[2];

    // Extraer el enlace del elemento "link"
    $link = (string) $item->link;

    // Extraer la descripción del elemento "description"
    $description = (string) $item->description;

    // Extraer la magnitud y la ubicación de la descripción
    preg_match('/Se ha producido un terremoto de magnitud ([\d\.]+) en ([^ ]+(?: [^ ]+)*) en la fecha (\d{2}\/\d{2}\/\d{4} \d{1,2}:\d{2}:\d{2}) en la siguiente localización: ([\d\.\-]+),([\d\.\-]+)/'
    , $description, $matches);
    $magnitude = $matches[1];
    $location = $matches[2];
    $lat = $matches[4];
    $long = $matches[5];

    // Añadir los datos al array de terremotos
    $terremotos[] = array(
        'date' => $date,
        'time' => $time,
        'link' => $link,
        'description' => $description,
        'magnitude' => $magnitude,
        'location' => $location,
        'lat' => $lat,
        'long' => $long
    );
}
header('Content-Type: application/json');
echo json_encode($terremotos);
?>
