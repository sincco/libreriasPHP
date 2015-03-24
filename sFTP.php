<?php
/************************************
* sFTP (simpleFTP)
*************************************
* Manejo de conexión a servidor FTP
*************************************
Rev:
*************************************
@deivanmiranda: 1.0 - Marzo, 2015
************************************/
class sFTP {
//Definición de alias para funciones
	private static $_alias = array(
		'conectar' => 'connect',
		'conectarssl' => 'ssl_connect',
		'listar' => 'nlist',
		'subir' => 'put',
		'cerrar' => 'quit',
		'dir' => 'chdir',
		'bajar' => 'get'
	);

	private $_conexion;
	private $_respuesta;
	private $_error;

/*
	@url -> URI de conexión al servidor
	Si la URI se pasa como una cadena de conexión directa, se obtiene cada parte, pej:
	ftp://user:password@sld.domain.tld:21/ruta1/ruta2
*/
	public function __construct($url = NULL) {
		if (!extension_loaded('ftp')) { //Validar que PHP tenga el soporte para FTP
			throw new Exception;
		}
		if ($url) {
			if(preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i",$url, $_parts)) {
				preg_match("/:(.*)/i",$_parts[3], $_port);
				if(count($_port) == 0)
					$_port = array(0=>"",1=>$_parts[3]);
				if(isset($_port[2]))
					$this->conectar($_port[1], $_port[2]);
				else
					$this->conectar($_port[1]);
				$this->login($_parts[1], $_parts[2]);
				$this->pasv(TRUE);
				if(strlen($_parts[4]) > 1) {
					$this->chdir($_parts[4]);
				}
			}
		}
	}

/*
	Método mágico para habilitar los alias en español o las llamadas directas de las
	funciones ftp de PHP
*/
	public function __call($name, $args) {
		$name = strtolower($name);
		$silent = strncmp($name, 'try', 3) === 0;
		$func = $silent ? substr($name, 3) : $name;
		$func = 'ftp_' . (isset(self::$_alias[$func]) ? self::$_alias[$func] : $func);
		if (!function_exists($func)) {
			throw new Exception("Metodo no definido sFTP::$name().");
		}
		$this->errorMsg = NULL;
		set_error_handler(array($this, '_error'));
		if ($func === 'ftp_connect' || $func === 'ftp_ssl_connect') {
			$this->_respuesta = array($name => $args);
			$this->_conexion = call_user_func_array($func, $args);
			$res = NULL;
		} elseif (!is_resource($this->_conexion)) {
			restore_error_handler();
			throw new FtpException("Servidor no conectado.");
		} else {
			if ($func === 'ftp_login' || $func === 'ftp_pasv') {
				$this->_respuesta[$name] = $args;
			}
			array_unshift($args, $this->_conexion);
			$res = call_user_func_array($func, $args);
			if ($func === 'ftp_chdir' || $func === 'ftp_cdup') {
				$this->_respuesta['chdir'] = array(ftp_pwd($this->_conexion));
			}
		}
		restore_error_handler();
		if (!$silent && $this->errorMsg !== NULL) {
			if (ini_get('html_errors')) {
				$this->errorMsg = html_entity_decode(strip_tags($this->errorMsg));
			}
			if (($a = strpos($this->errorMsg, ': ')) !== FALSE) {
				$this->errorMsg = substr($this->errorMsg, $a + 2);
			}
			throw new FtpException($this->errorMsg);
		}
		return $res;
	}

/*
	Manejo de errores
*/
	public function _error($code, $message)
	{
		$this->_error = $message;
	}

}


class FtpException extends Exception {}
