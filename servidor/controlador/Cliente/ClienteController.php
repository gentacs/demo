<?php
Class ClienteController{
	protected $bdCliente;
	protected $clietne;
	public function __construct(){
		$this->bdCliente = new BdCliente();
	}
	public function addCliente( $parametros ) {
		echo json_encode( $this->bdCliente->guardar($parametros) );
	}
	public function getLista(){
		echo json_encode($this->bdCliente->getAll());
	}
	public function getUsuario($parametros){
		$parametros = json_decode($parametros);
		$this->cliente = new Cliente($parametros->id);
		echo json_encode($this->cliente);
	}
}