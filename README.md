# sFTP
Simple FTP
#### Version
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

#### Ejemplo de uso:

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
#### Version
1.0

Permite la creación de archivos CSV de forma rápida y fácil.

####exportar($arregloDatos)
Genera el achivo con los datos pasados
####html($arregloDatos)
Genera el archivo como salida al navegador con las cabeceras necesarias para una descarga directa (con base al archivo

#### Ejemplo de uso:

```
<?php
require_once 'sCSV.php';

//Instanciar la clase diciendo que archivo y separador utilizar
$_csv = new sCSV("archivo.csv",",");
//Parsear descarga desde el navegador
$_csv->html($datos);
```

# sRSS
Simple RSS
#### Version
1.0

Crea un feed de noticias en base a los datos pasados.

###__construct(namespace array,datos_canal array, url_sitio string, nombre_sitio string[, caracteres_contenido int, contenido_completo boolean])

Al iniciar la clase se pasan los datos referentes al canal que se está creando, los namespaces que se involucran y el limite de caracteres del texto de contenido del elemento.
```
$_namespace = 'xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:media="http://search.yahoo.com/mrss"';

$_canal = array(
	"titulo" => "APSICAT",
	"link" => "http://apsicat.com",
	"descripcion" => "Lectura de apoyo",
	"language" => "es",
	"imagen_titulo" => "apsicat.com",
	"imagen_link" => "http://apsicat.com",
	"imagen_url" => "http://apsicat.com/html/images/logo.png",
);
$rss = new sRSS($_namespace, $_canal, 'http://ivanmiranda.me', 'Codigos y otras ideas al aire', 150);
```
###crear(elementos array)

```
#El arreglo de elementos debe tener las llaves:
$elemento = array(
  "titulo" => "Titulo artículo",
  "link" => "http://liga.com/articulo",
  "contenido" => "Contenido del articulo[...]",
  "fecha" => "2015-01-01",
  "imagen" => "http://liga.com/imagen.xxx" #Opcional
);

$rss->crear($elemento);
```

# SCFD
Simple CFD
#### Version
1.0

Permite manipular CFD's

#### Ejemplo de uso:

```
<?php
require_once 'sCFD.php';

$_cfd = New sCFD(PATH_URL."/cfds/".$archivo.".xml");
$_datos = $_cfd->leer();
//El arreglo $_datos ahora tiene los elementos de cada sección que se quiera consultar
//pej. $_datos['Emisor']['rfc']
```

----
Licencia
----
MIT

**@deivanmiranda - http://ivanmiranda.me**

