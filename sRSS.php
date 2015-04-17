<?php
/************************************
* Clase para control de RSS
*************************************
*************************************
Rev:
*************************************
@ivanmiranda: 1.0
************************************/

class sRSS {

  protected
    $_xmlns = "",
    $_canal = array(),
    $_sitioURL = "",
    $_sitioNombre = "",
    $_completo = "",
    $_contenido;

#Construcción del RSS
  public function __construct($nameSpace, $canal, $sitioURL, $sitioNombre, $descripcion = 100, $completo = false) {
    $this->_xmlns = ($nameSpace ? ' '.$nameSpace : '');
    $this->_canal = $canal;
    $this->_sitioURL = $sitioURL;
    $this->_sitioNombre = $sitioNombre;
    $this->_completo = $completo;
    $this->_contenido = $descripcion;
  }

#Creación del RSS 2.0, regresa la cadena armada 
  public function crear($datos) {
    $_xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";
    $_xml .= '<rss version="2.0"'.$this->_xmlns.'>'."\n";
  #Propiedades obligatorias del canal
    $_xml .= '<channel>'."\n";
    $_xml .= '<title>'.$this->_canal["titulo"].'</title>'."\n";
    $_xml .= '<link>'.$this->_canal["link"].'</link>'."\n";
    $_xml .= '<description>'.$this->_canal["descripcion"].'</description>'."\n";
 
  #Propiedades opcionales del canal
    if(array_key_exists("lenguaje", $this->_canal)) {
      $_xml .= '<language>'.$this->_canal["lenguaje"].'</language>'."\n";
    }
    if(array_key_exists("imagen_titulo", $this->_canal)) {
      $_xml .= '<image>'."\n";
      $_xml .= '<title>'.$this->_canal["imagen_titulo"].'</title>'."\n";
      $_xml .= '<link>'.$this->_canal["imagen_link"].'</link>'."\n";
      $_xml .= '<url>'.$this->_canal["imagen_url"].'</url>'."\n";
      $_xml .= '</image>'."\n";
    }
  #Elementos
    $_fecha =  date("YmdHis"); // get current time
 
    foreach($datos as $rss_item) {
      $_xml .= '<item>'."\n";
      $_xml .= '<title>'.$rss_item['titulo'].'</title>'."\n";
      $_xml .= '<link>'.$rss_item['link'].'</link>'."\n";
      $_xml .= '<description>'.substr(strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",$rss_item['contenido'])),0,$this->_contenido).'</description>'."\n";
      $_xml .= '<pubDate>'.date("D, d M Y H:i:s T", strtotime($rss_item['fecha'])).'</pubDate>'."\n";
      if(array_key_exists("imagen", $rss_item)) {
        $_xml .= '<media:content type="image/jpeg" height="768" width="1024" url="'.$rss_item['imagen'].'" />'."\n";
      }
      if($this->_completo) {
        $_xml .= '<content:encoded><![CDATA['.$rss_item['contenido'].']]></content:encoded>'."\n";
      }
      $_xml .= '</item>'."\n";
    } 
    $_xml .= '</channel>';
    $_xml .= '</rss>';
    header('Content-type: application/xml');
    echo $_xml;
  } 
}
