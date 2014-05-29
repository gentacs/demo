<?php
require('BD.php');
class BdCliente extends BD{
	protected $table;
	private $estructura;

	public function __construct(){
		parent::__construct();
		$this->estructura = array(
								"nombre" 			=> "",
								"apellidoPaterno" 	=> "",
								"apellidoMaterno" 	=> "",
								"telefono"		 	=> "",
							);

	}
	public function buscar($cadena){
		$retornar 	= array();
		$sub_cadena	= explode(" ", $cadena);
		$sql 		= "";
		if( count( $sub_cadena ) == 2 ) {
			$sql = "SELECT * FROM cliente WHERE (LOWER(nombre) LIKE LOWER('$sub_cadena[0]') AND LOWER(apellido_paterno) LIKE LOWER('$sub_cadena[1]')) OR ".
					"(LOWER(nombre) LIKE LOWER('$sub_cadena[1]') AND LOWER(apellido_paterno) LIKE LOWER('$sub_cadena[0]'))";
		}else{
			$sql 	= "SELECT * FROM cliente WHERE LOWER(nombre) LIKE LOWER('%$cadena%') OR LOWER(apellido_paterno) LIKE LOWER('%$cadena%') ORDER BY nombre, apellido_paterno";
		}
		$this->abrir();
		$r 			= $this->conexion( $sql );
		$this->cerrar();
		while ($d 	= pg_fetch_object($r)){
			$retornar[$d->intid] = $d;
		}
		return $retornar;
	}

	public function getAll(){
		$retornar 	= array();
		$sql 		= "SELECT * FROM cliente ";
		$this->abrir();
		$r 			= $this->conexion->query( $sql );
		$this->cerrar();
		foreach ($r as $d){ 
			$retornar[] = $d;
		}
		return $retornar;
	}

	public function getClienteId($id){
		$retornar;
		$sql = "SELECT * FROM cliente WHERE id = $id";
		$this->abrir();
		$r 			= $this->conexion->query( $sql );
		$this->cerrar();
		foreach ( $r as $d ){
			$retornar = (Object)$d;
		}
		return $retornar;
	}

	public function guardar ( $datos ) { 

		$datos 		= (Array) json_decode($datos);
		$cliente 	= (Object) ($datos + $this->estructura);
		$id 		= 0;

		$this->abrir();

		if( isset( $datos->id ) ){

			$sql = "UPDATE cliente SET   nombre 			= ?, ".
										"apellido_paterno	= ?, ".
										"apellido_materno 	= ?, ".
										"fono 				= ? ".
					"WHERE id = ?";
			$this->conexion->prepare($sql);
			$this->conexion->execute(array($cliente->nombre, $cliente->apellidoPaterno, $cliente->apellidoMaterno, $cliente->telefono, $cliente->id));
			$this->conexion->commit();
			$id = $cliente->id;

		}else{

			$sql = "INSERT INTO cliente (nombre, apellido_paterno, apellido_materno, fono) ".
					"VALUES(?, ?, ?, ?)";
			try{

				$this->conexion->beginTransaction();
				$sentencia 	= $this->conexion->prepare($sql);
				$sentencia->execute(array($cliente->nombre, $cliente->apellidoPaterno, $cliente->apellidoMaterno, $cliente->telefono));
				$id 		= (int) $this->conexion->lastInsertId();
				$this->conexion->commit();

			}catch( PDOException $e){

				$this->conexion->roolback();

			}

		}
		$this->cerrar();

		return $id;
		
	}
}
?>