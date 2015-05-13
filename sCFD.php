<?php
/************************************
* sCFD (simpleCFD)
*************************************
* Manipulación de elementos
*************************************
Rev:
*************************************
@deivanmiranda: 1.0 - Mayo, 2015
************************************/
class sCFD {
	private $_archivo;

	public function __construct($archivo = "") {
		if(strlen(trim($archivo)) > 0) {
			$this->_archivo = $archivo;
		}
	}

#Devuelve un array con el contenido del CFD con los elementos que lo conforman
	public function leer($archivo = "") {
		if(strlen(trim($archivo)) > 0) {
			$this->_archivo = $archivo;
		}
		$_respuesta = array();
		$xml = new SimpleXMLElement ($this->_archivo, null, true);
		$_namespace = $xml->getNamespaces(true);
		$xml->registerXPathNamespace('cfdi', $_namespace['cfdi']);
		$xml->registerXPathNamespace('tfd', $_namespace['tfd']);
		$namespaces = $xml->getDocNamespaces();
		$_respuesta['Comprobante'] = $xml->xpath('//cfdi:Comprobante')[0];
		$_respuesta['Emisor'] = $xml->xpath('//cfdi:Comprobante//cfdi:Emisor')[0];
		$_respuesta['Receptor'] = $xml->xpath('//cfdi:Comprobante//cfdi:Receptor')[0];
		$_respuesta['Conceptos'] = $xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto');
		$_respuesta['TimbreFiscalDigital'] = $xml->xpath('//tfd:TimbreFiscalDigital');
		return $_respuesta;
	}
}
