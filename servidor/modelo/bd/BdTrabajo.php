<?php
require_once(dirname (__FILE__) . "/BD.php");
class BdTrabajo extends BD{
	protected $trabajo;

	public function trabajosClienta($id){
		$retornar 	= array();
		$sql 		= "SELECT id, fecha as fecha, descripcion, cliente_id FROM trabajo WHERE cliente_id = $id ORDER BY fecha DESC"; 
		$this->abrir();
		$r 			= $this->conexion->query( $sql ); 
		$this->cerrar();
		foreach ($r as $d){
			$retornar[] = $d;
		}
		return $retornar;
	}
	public function guardar($datos){
		$sql = "INSERT INTO trabajo(datfecha, strdescripcion, cliente_intid) ".
				"VALUES(NOW(), $$$datos[comentario]$$, $datos[intid])";
		$r = $this->insert($sql);
		if(!$r){
			return false;
		}else{
			return true;
		}
	}
}
?>