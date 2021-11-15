<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafío 1</title>
</head>

<body>
    <form action="ipblacklist.php" method="post" enctype="multipart/form-data">
        Subir archivo *.csv:
        <br><br>
        <input type="file" name="ipblacklist">
        <br><br>
        <input type="submit" value="Cargar archivo" name="submit">
    </form>
    <?php
    if (isset($_GET['err'])) {
        switch ($_GET['err']) {
            case 1:
                echo "El archivo subido está vacío.";
                break;
            case 2:
                echo "Se produjo un error al leer el archivo.";
                break;
            case 3:
                echo "El archivo subido no tiene un formato compatible.";
                break;
            case 4:
                echo "No se encontraron coincidencias con IP válidas.";
                break;
        }
    }
    ?>
</body>

</html>