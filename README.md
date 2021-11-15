# Desafio1_WestNet

Script PHP que resuelve el siguiente problema:

Manejo de estructuras de datos

Desarrollar en PHP un script que resuelva el siguiente problema:
El sector de Networking del área de Sistemas detecta una situación sospechosa en la
red y genera un archivo llamado ip_blacklist.csv que contiene un listado de strings
separados por coma correspondientes a una lista de IPs. El segundo octeto de la IP
define la subred en la que se encuentra esta IP en la red. Afortunadamente, ya existe
un endpoint de API (https://soldef.westnet.com.ar/api/v1/nodo) que devuelve un
JSON con campos de nombre del nodo y subred.
Se necesita cruzar esta información para identificar la cantidad de casos que existen
en cada nodo.
Crear un script que lea el archivo que contiene la lista de IPs y devolver un archivo
JSON llamado cases_by_nodes.json respetando el siguiente formato de ejemplo:

{
  "data":[
    {
       "nodo":"DECIMO",
       "casos":9
    },
    {
       "nodo":"HUDSON",
       "casos":6
    }
  ]
}

NOTAS:

● Si el nodo no posee casos no debe figurar en el JSON.

● Por cuestiones de rendimiento se debe, en lo posible, evitar el uso de bucles
en el código. Para ello investigue sobre las funciones nativas que posee PHP
para cruzar la información entre arrays.

● Como los datos vienen de un archivo generado se debe tener en cuenta
validaciones básicas como: que no se encuentre vacío, que su contenido sean
IPs válidas, entre otras que ayuden a darle fiabilidad a los resultados.
