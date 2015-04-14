<?php
/************************************
* sCSV (simpleCSV)
*************************************
* Manejo de archivos CSV
*************************************
Rev:
*************************************
@deivanmiranda: 1.0 - Abril, 2015
************************************/
class sCSV {
	private
		$_separador = "",
		$_archivo = "",
		$_respuesta = "";
	
	public function __construct($archivo,$separador,$datos = array()) {
		$this->_separador = $separador;
		$this->_archivo = $archivo;
		if(count($datos) > 0) {
			$this->escribir($datos);
		}
	}

//Escribe en un archivo el contenido de un arreglo
	public function escribir($datos) {
		if(!$_puntero = fopen( $this->_archivo,'w')) {
			$this->_respuesta = "No se pudo abrir el archivo";
			return $this->_respuesta;
		}

		if(!( is_array($datos) && count($datos) >= 1 )) {
			$this->_respuesta =  "No es un arreglo";
			return $this->_respuesta;
		}
		
		$_contenido = "";
		foreach($datos as $_dato) {
			$_contenido .= trim(implode($this->_separador, $_dato))."\r\n";
		}

		if (fwrite($_puntero, $_contenido) === FALSE )
			$this->_respuesta =  "Error al escribir el archivo";
		else
			$this->_respuesta =  "OK";
		fclose($_puntero);
		return $this->_respuesta;
	}

//Convierte el arreglo de datos en un CSV con salida a navegador
	public function html($datos) {
		$_contenido = "";
		foreach($datos as $_dato) {
			$_contenido .= trim(implode($this->_separador, $_dato))."\r\n";
		}
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=".$this->_archivo);
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $_contenido;
		return true;
	}
}
