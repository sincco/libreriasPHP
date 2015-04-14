# sFTP
Simple FTP
### Version
1.0

Permite manipular la conexión de a un servidor FTP de un modo más simple.

La conexión se invoca desde el armado de una URL al cargar la clase:
```
$ftp = new sFTP("ftp://usuario:password@host[:puerto]/[carpeta]");
```
Y el llamado de las funciones se puede hacer con el nombre traducido o quitando el sufijo ftp_ a cualquier función que se desee:

```
$ftp->listar(".");
$ftp->nlist(".");
```

### Ejemplo de uso:

```
<?php
require_once 'sftp.php';

//Crea una conexion al servidor sobre un subdirectorio
$ftp = new sFTP("ftp://Ti_Port_TMK:prnport13@172.16.1.7/Nueva carpeta");
//lista el directorio actual
print_r($ftp->listar("."));
//subir un nivel
$ftp->dir("..");
//lista el directorio actual
print_r($ftp->listar("."));
//descargar un archivo
$ftp->bajar('baja.tmp', 'archivo.txt', FTP_ASCII);
//cerra conexion
$ftp->cerrar();
```

# sCSV
Simple CSV
### Version
1.0

Permite la creación de archivos CSV de forma rápida y fácil.

###exportar($arregloDatos)
Genera el achivo con los datos pasados
###html($arregloDatos)
Genera el archivo como salida al navegador con las cabeceras necesarias para una descarga directa (con base al archivo

### Ejemplo de uso:

```
<?php
require_once 'sCSV.php';

//Instanciar la clase diciendo que archivo y separador utilizar
$_csv = new sCSV("archivo.csv",",");
//Parsear descarga desde el navegador
$_csv->html($datos);
```

Licencia
----
MIT

**@deivanmiranda - http://ivanmiranda.me**

