<?php
//responsable de instanciar la conexión a nuestra base da datos.
class Conexion{
	public static function GetConexion(){
		require_once ('config.php');
		$username = DBUSER;
		$password= DBPASSWORD;
		$host = DBHOST;
		$database =DBNAME;
		
		$con =  $con = new Mongo("mongodb://{$username}:{$password}@{$host}");
		$db = $con->selectDB($database);
		return $db;
	}
}
?>