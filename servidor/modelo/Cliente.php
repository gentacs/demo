<?php
class Cliente{
	public $id;
	public $nombre;
	public $apellidoPaterno;
	public $apellidoMaterno;
	public $telefono;
	public $trabajos;
	private $bdCliente;
	private $bdTrabajo;

	public function __construct($id){

		$this->bdCliente = new BdCliente();
		$this->bdTrabajo = new BdTrabajo();

		$datos 					= $this->bdCliente->getClienteId($id);
		$this->id 				= $datos->id;
		$this->nombre			= $datos->nombre;
		$this->apellidoPaterno 	= $datos->apellido_paterno;
		$this->apellidoMaterno 	= $datos->apellido_materno;
		$this->telefono 		= $datos->fono;
		$this->trabajos 		= $this->bdTrabajo->trabajosClienta($id);
	}
}