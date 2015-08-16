<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
<title>KoH</title>
</head>

<header id="cabecera">
<h1>KoH</h1>
<h3>Zonas</h3>
</header>
<nav id="menu">
<ul>

<li><a href="web_Admin.php">Principal</a></li>
<li><a href="zonas_Admin.php">Zonas</a></li>
<li><a href="usuarios_Admin.php">Usuarios</a></li>
<li><a href="escuelas_Admin.php"><b>Escuelas</b></a></li>
<li><a href="acerca.php">Acerca</a></li>


</ul>
</nav>

<body>
		

								
				
				<div class="box container">
					<section>
						<header>
							<h3>Ingresar escuela</h3>
						</header>
						<form method="post" action="escuelas_Admin.php">
							
							<div class="row">
									<br><br><br>
									<input type="hidden" name='crear' value="1" />
									<input class="text" type="text" name="sch" id="textbox" value="" placeholder="digite el nombre de la escuela" /><br>
									<input class="text" type="text" name="color" id="textbox" value="" placeholder="asigne un color a la escuela" /><br>
									

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

	
if (isset ( $_POST ['sch'] ) && isset($_POST['color'])) {
	$connection = new MongoClient ();
	// buscar school en DB.
	$db = $connection->koh;
	$school_collection = $db->school;
	$school = $school_collection->findOne (array('sch_name'=>$_GET['sch']));
	
	if ( $school['sch_name']==NULL){
		$document = array (
			'sch_name'=> $_POST['sch'],
			'sch_color'=> $_POST['color']
		);
		$school_collection->insert ( $document );
		$response['message'] = 1;
	}else{
		$response['message'] = 0;
	}
}else{
	$response['message'] = 0;
}

?>


<div>				
	<section>
		<header>
			<h3>Escuela</h3>
		</header>
		<div class="table-wrapper">
			<table class="default">
				<thead>
					<tr>
						<th>  Nombre de la escuela  </th>
						<th>  Color  </th>

					</tr>
				</thead>
				<tbody>
<?php
$connection = new MongoClient ();
$db = $connection->koh;
$school_collection = $db->school;
// Tomamos todas las zonas
$school = $school_collection->find ();
foreach ($school as $resultado) {
	echo '<tr>' . "\n";
	echo '<td>'.$resultado['sch_name'].'</td>'."\n";
	echo '<td>' .$resultado['sch_color']. '</td>'."\n";
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











