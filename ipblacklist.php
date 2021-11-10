<?php

echo "<pre>";
print_r($_FILES);
echo "</pre>";

//check csv
if (isset($_POST['submit'])) {
    $name = explode('.', $_FILES['ipblacklist']['name']);
    $ext = strtolower(end($name));

    if ($_FILES['ipblacklist']['size'] != 0) {
        if ($_FILES['ipblacklist']['error'] == 0) {
            if ($ext == "csv") {

                $handle = fopen($_FILES['ipblacklist']['tmp_name'], "r");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $data = trim($data[0], "'");

                    if (filter_var($data, FILTER_VALIDATE_IP)) {
                        $ips[] = $data;    
                    }
                }
                echo "<pre>";
                print_r($ips);
                echo "</pre>";
                fclose($handle);
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
