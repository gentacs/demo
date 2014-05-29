<?php
spl_autoload_register('a_autoload');
spl_autoload_register('b_autoload');
spl_autoload_register('c_autoload');
function a_autoload($name){ 
	$fullpath = '../modelo/bd/'.$name.'.php';
	if(file_exists($fullpath)) require_once($fullpath);
}
function b_autoload($name){
	$fullpath = '../modelo/'.ucfirst(strtolower($name)).'.php';
	if(file_exists($fullpath)) require_once($fullpath);
}
function c_autoload($name){
	$fullpath = '../modelo/bd/'.ucfirst(strtolower($name)).'.php';
	if(file_exists($fullpath)) require_once($fullpath);
}

$controlador 	= $_GET['controlador'];
$accion 		= $_GET['accion'];
$parametros 	= $_GET['parametros'];

require_once(dirname (__FILE__) . "/$controlador/".$controlador."Controller.php");
$classControlador = $controlador."Controller";
$c = new $classControlador();
$c->$accion($parametros);