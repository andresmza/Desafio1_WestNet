<?php
$url_API = 'https://soldef.westnet.com.ar/api/v1/nodo';

if (isset($_POST['submit'])) {
    //Extrae el nombre del archivo subido.
    $name = explode('.', $_FILES['ipblacklist']['name']);

    //Extrae la extensión del archivo subido.
    $ext = strtolower(end($name));

    //Validaciones del archivo subido.
    if ($_FILES['ipblacklist']['size'] != 0) {
        if ($_FILES['ipblacklist']['error'] == 0) {
            if ($ext === 'csv') {

                //Lee el contenido del archivo y lo guarda en una variable tipo String.
                $file = file_get_contents($_FILES['ipblacklist']['tmp_name']);

                //Extrae la cadena que coincide con una IP válida y
                //extrae el segundo octeto de la IP de la matriz de coincidencias.
                $result = preg_match_all('/((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){2}(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)/', $file, $matches);
                
                if ($result == 0) {
                    //Error 4: No se encontraron coincidencias.
                    header('Location:index.php?err=4');
                }

                //Contabiliza los resultados obtenidos en un array ('subred' => 'cantidad')
                $count_subnet = array_count_values($matches[2]);

            } else {
                //Error 3: El archivo subido no tiene un formato compatible.
                header('Location:index.php?err=3');

            }
        } else {
            //Error 2: Se produjo un error al leer el archivo.
            header('Location:index.php?err=2');

        }
    } else {
        //Error 1: El archivo subido está vacío.
        header('Location:index.php?err=1');

    }
}

//Obtiene datos de API y los almacena en un array.
$api_data = json_decode(file_get_contents($url_API), true);

//Unifica los datos traídos de la api asignando 'name' a la clave y 'subnet' al valor.
$subnet_names = array_column($api_data['data'], 'name', 'subnet');

//Calcula intersección del array de subredes traído de la API con los valores encontrados en las IP's baneadas.
$subnets_found = array_intersect_key($subnet_names, $count_subnet);

//Combina array de IP's baneadas encontradas y array de subredes.
$combined_subnets = array_combine($subnets_found, $count_subnet);

//Crea array con la estructura necesaria para JSON.
foreach ($combined_subnets as $key => $value) {
    $nodes['data'][] = array(
        'nodo' => $key,
        'casos' => $value
    );
}

//Crea JSON y devuelve el archivo.
$json_string = json_encode($nodes);
$output_file = 'cases_by_nodes.json';
file_put_contents($output_file, $json_string);
?>
