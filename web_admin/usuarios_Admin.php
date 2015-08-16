<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
<title>KoH</title>
</head>

<header id="cabecera">
<h1>KoH</h1>
<h3>Usuarios</h3>
</header>
<nav id="menu">
<ul>

<li><a href="web_Admin.php">Principal</a></li>
<li><a href="zonas_Admin.php">Zonas</a></li>
<li><a href="usuarios_Admin.php"><b>Usuarios</b></a></li>
<li><a href="escuelas_Admin.php">Escuelas</a></li>
<li><a href="acerca.php">Acerca</a></li>


</ul>
</nav>

<body>
		

								
				
				<div class="box container">
					<section>
						<header>
							<h3>Ingresar usuario</h3>
						</header>
						<form method="post" action="usuarios_Admin.php">
							
							<div class="row">
									<br><br><br>
									<input type="hidden" name='crear' value="1" />
									<input class="text" type="text" name="un" id="textbox" value="" placeholder="el nombre de usuario" /><br>
									<input class="text" type="password" name="pwd" id="textbox" value="" placeholder="digite la contrase&ntilde;a" /><br>
									<input class="text" type="text" name="sch" id="textbox" value="" placeholder="escuela" /><br>
									<input class="text" type="text" name="x" id="textbox" value="" placeholder="digite la coordenada x" /><br>
									<input class="text" type="text" name="y" id="textbox" value="" placeholder="digite la coordenada y" /><br>
									

							</div>
							<br><br>
							<div class="row">
								<div class="12u">
									<ul class="actions">
										<li><input type="submit" value="Crear" /></li>
										<li><input type="reset" value="Resetear" class="alt" /></li>
									</ul>
								</div>
							</div>
						</form>
 

							</div>	

<br><br><br>



<?php


$response = array ();
if (isset ( $_POST ['pwd'] ) && isset ( $_POST ['un'] ) && isset ( $_POST ['sch'] ) && isset ( $_POST ['x'] )&& isset ( $_POST ['y'] )) {
	$connection = new MongoClient ();
	// y demas datos para crear un usuario nuevo.
	
	// crear user en DB.
	
	$db = $connection->koh;
	$user_collection = $db->user;
	
	// No pueden dos usuarios con el mismo nombre.
	$cursor = $user_collection->find ();
	$exists = false;
	foreach ( $cursor as $document ) {
		if ($document ['username'] == $_GET ['un']) {
			$exists = true;
			break;
		}
	}
	
	//buscamos que la escuela exista (utilizaremos la misma variable $exists solo para reciclar.)
	$db = $connection->koh;
	$school_collection = $db->school;
	$school = $school_collection->findOne(array('sch_name'=>$_POST['sch']));
	if($school['sch_name']==NULL){
		$exists=true;
	}
	
	if ($exists == false) {
		$doc = array (
				"username" => $_POST ['un'],
				"password" => $_POST ['pwd'],
				"school" => $_POST ['sch'],
				"x"=> $_POST['x'],
				"y"=> $_POST['y'],
				"alert"=>'safe'
		);
		$user_collection->insert ( $doc );
		$response ["message"] = 1;
	} else {
		$response ["message"] = 0;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );

?>



<div>				
	<section>
		<header>
			<h3>Zonas</h3>
		</header>
		<div class="table-wrapper">
			<table class="default">
				<thead>
					<tr>
						<th>  Nombre de usuario </th>
						<th>  Password  </th>
						<th>  Escuela  </th>
						<th>Coordenada X</th>
						<th>Coordenada Y</th>
						<th>Alerta</th>
						<th></th>

					</tr>
				</thead>
				<tbody>
<?php
$connection = new MongoClient ();
$db = $connection->koh;
$user_collection = $db->user;
$user = $user_collection->find ();
foreach ($user as $resultado) {
	echo '<tr>' . "\n";
	echo '<td>'.$resultado['username'].'</td>'."\n";
	//echo '<td>' .$resultado['password']. '</td>'."\n";
	echo '<td>' ."xxx". '</td>'."\n";
	echo '<td>' .$resultado['school']. '</td>'."\n";
	echo '<td>' .$resultado['x']. '</td>'."\n";
	echo '<td>' .$resultado['y']. '</td>'."\n";
	echo '<td>' .$resultado['alert']. '</td>'."\n";
	echo '</tr>' . "\n";
}


?>			
			</tbody>
			</table>
		</div>
	</section>					</section>
</div>

<br>
<br>
<br>
<br>
				
				
				

		<!-- Footer -->
			<div id="footer">
				
				
				
				<div class="container 75%">

					
					
					
					<ul class="copyright">
						<li>&copy; KoH.</li>
						<li><a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.</li>
					</ul>

				</div>
			</div>

	</body>
</html>











