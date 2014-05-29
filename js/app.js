var app = angular.module('projectMuestra', ['ngRoute']);

app.config(function ($routeProvider){
	$routeProvider.when('/',
		{
			controller: 'ListaController',
			templateUrl: 'vista/cliente/lista.html'
		}
	)
	.when('/cliente/:id', 
		{
			controller: 'DetalleController',
			templateUrl: 'vista/cliente/detalle.html'
		}
	)
	.when('/nuevo/cliente',
		{
			controller: 'NuevoController',
			templateUrl: 'vista/cliente/nuevo.html'
		}
	);
});

app.controller('DetalleController', function($scope, $routeParams, DetalleFactory){

	$scope.cargarFormulario = function () {
		
	}
	
	function init(){ 
		DetalleFactory.getClienteId($routeParams.id).success(function (datos){
			$scope.cliente = datos;
		});
	}
	init();
});

app.controller('ListaController', function($scope, clienteFactory, $location){

	function init(){

		clienteFactory.getClientes().success(function(datos){

			$scope.clientes = datos;

		});

	}

	$scope.cambiarPath = function(id){

		$location.path("/cliente/"+id);

	}

	init();
});
app.controller('NuevoController', function( $scope, clienteFactory, $location ){

	function init(){

	}

	$scope.guardar = function (){

		var cliente = $scope.cliente;

		clienteFactory.addCliente(cliente).success(function (id) {

			$location.path("/cliente/"+id);

		}); 
	}

	$scope.reset = function(){

		$scope.cliente = angular.copy({});

	}

	$scope.validar = function(cliente){

		console.log(angular.equals( cliente, {} ));
		return true;

	}

	init();
});

app.factory('clienteFactory', function ( $http ) {

	var factory = {};

	factory.getClientes = function(){

		return $http.get(
				'servidor/controlador/controlador.php?controlador=Cliente&accion=getLista&parametros='
			);

	};

	factory.addCliente = function ( cliente ) { 

		var parametros = JSON.stringify({'nombre': cliente.nombre, 'apellidoPaterno': cliente.apellidoPaterno, 'apellidoMaterno': cliente.apellidoMaterno, 'telefono': cliente.telefono });

		return $http.get('servidor/controlador/controlador.php?controlador=Cliente&accion=addCliente&parametros='+parametros);
	}

	return factory;
});

app.factory('DetalleFactory', function ( $http ) {

	var factory = {};

	factory.getClienteId = function(id){

		var parametros = JSON.stringify({'id': id });

		return $http.get('servidor/controlador/controlador.php?controlador=Cliente&accion=getUsuario&parametros='+parametros);

	};

	return factory;

});
