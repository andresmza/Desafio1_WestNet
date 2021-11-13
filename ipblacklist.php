<?php
$url = "https://soldef.westnet.com.ar/api/v1/nodo";

//check csv
if (isset($_POST['submit'])) {
    $name = explode('.', $_FILES['ipblacklist']['name']);
    $ext = strtolower(end($name));

    if ($_FILES['ipblacklist']['size'] != 0) {
        if ($_FILES['ipblacklist']['error'] == 0) {
            if ($ext === "csv") {
                $handle = file_get_contents($_FILES['ipblacklist']['tmp_name']);
                //busca IP válidas
                $handle = preg_match_all("/((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)/", $handle, $matches);
                $handle = implode(",", $matches[0]);

                //extrae octeto 1 y 2 de la IP y luego el octeto 2 de la matriz de coincidencias
                $handle = preg_match_all("/(^|\s|,)((25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?))/", $handle, $matches);

                $count_subnet = array_count_values($matches[4]);
            } else {
                echo "El archivo subido no tiene un formato compatible.";
            }
        } else {
            echo "Se produjo un error al leer el archivo.";
        }
    } else {
        echo "El archivo subido está vacío.";
    }
}

//JSON to array
$api_data = json_decode(file_get_contents($url), true);
$nombres = array_column($api_data['data'], 'name', 'subnet');

//Combina ambos array
$values = array_intersect_key($nombres, $count_subnet);
ksort($count_subnet);
ksort($values);
$final = array_combine($values, $count_subnet);

//Crea array con los datos necesarios para JSON
foreach ($final as $key => $value) {
    $nodos['data'][] = array(
        'nodo' => $key,
        'casos' => $value
    );
}

//Crear JSON
$json_string = json_encode($nodos);
$file = 'cases_by_nodes.json';
file_put_contents($file, $json_string);

// echo (json_encode($nodos));
