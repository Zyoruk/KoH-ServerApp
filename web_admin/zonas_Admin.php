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
<li><a href="zonas_Admin.php"><b>Zonas</b></a></li>
<li><a href="usuarios_Admin.php">Usuarios</a></li>
<li><a href="escuelas_Admin.php">Escuelas</a></li>
<li><a href="acerca.php">Acerca</a></li>


</ul>
</nav>

<body>
		

								
				
				<div class="box container">
					<section>
						<header>
							<h3>Ingresar zona</h3>
						</header>
						<form method="post" action="zonas_Admin.php">
							
							<div class="row">
									<br><br><br>
									<input type="hidden" name='crear' value="1" />
									<input class="text" type="text" name="zid" id="textbox" value="" placeholder="digite el identificador de la zona" /><br>
									<input class="text" type="text" name="x1" id="textbox" value="" placeholder="digite la primera coordenada x" /><br>
									<input class="text" type="text" name="x2" id="textbox" value="" placeholder="digite la segunda coordenada x" /><br>
									<input class="text" type="text" name="y1" id="textbox" value="" placeholder="digite la primera coordenada y" /><br>
									<input class="text" type="text" name="y2" id="textbox" value="" placeholder="digite la segunda coordenada y" /><br>
									

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

	
if(isset($_POST['crear'])) {

		$zone_id = $_POST ['zid'];
		$zone_X1 = $_POST ['x1'];
		$zone_X2 = $_POST ['x2'];
		$zone_Y1 = $_POST ['y1'];
		$zone_Y2 = $_POST ['y2'];
		$flag=1;
		
		if(isset($_POST ['zid'])){
			$zone_id=$_POST ['zid'];
		}else{
			$flag=0;
			echo "se quedó";
		}
		if(isset($_POST ['x1'])){
			$zone_X1=$_POST ['x1'];
		}else{
			$flag=0;
		}
		if(isset($_POST ['x2'])){
			$zone_X2=$_POST ['x2'];
		}else{
			$flag=0;
		}
		if(isset($_POST ['y1'])){
			$zone_Y1=$_POST ['y1'];
		}else{
			$flag=0;
		}
		if(isset($_POST ['y2'])){
			$zone_Y2=$_POST ['y2'];
		}else{
			$flag=0;
		}


		// Servicio para la parte administrativa del juego.
		// No debería ser pública para la aplicación android.


		$connection = new MongoClient ();
		// Verificar que no exista otra zona con el mismo nombre.
		$db = $connection->koh;
		$zone_collection = $db->zone;
		// Tomamos todas las zonas
		$zone = $zone_collection->find ();
		$exists = false;
		$fits = true;
		foreach ( $zone as $document ) {
			if ($document ['zone_id'] == $zone_id) {
				$exists = true;
				break;
			} else if ($zone_X1 >= $document ['zone_X1'] && $zone_X2 <= $document ['zone_X2'] && $zone_Y1 >= $document ['zone_Y1'] && $zone_Y2 >= $document ['zone_Y2']) {
				$fits = false;
			}
		}
		if ($exists == false && $fits == true) {
			$document = array (
					'zone_id' => $zone_id,
					'zone_owner' => 'neutral',
					'zone_X1' => $zone_X1,
					'zone_X2' => $zone_X2,
					'zone_Y1' => $zone_Y1,
					'zone_Y2' => $zone_Y2,
					'zone_fight_alert' => 'safe' 
			);
			$zone_collection->insert ( $document );
			echo "zona creada";
			$response ['message'] = 1;
		} else {
			$response ['message'] = 0;
		}

		



}else{
	echo "no se ha ingresado alguna zona a$uacute;";
}

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
						<th>  Id de la zona  </th>
						<th>  Conquistador  </th>
						<th>Primera coordenada X</th>
						<th>Segunda coordenada X</th>
						<th>Primera coordenada Y</th>
						<th>Segunda coordenada Y</th>
						<th>Alerta de batalla</th>

					</tr>
				</thead>
				<tbody>
<?php
$connection = new MongoClient ();
$db = $connection->koh;
$zone_collection = $db->zone;
// Tomamos todas las zonas
$zone = $zone_collection->find ();
foreach ($zone as $resultado) {
	echo '<tr>' . "\n";
	echo '<td>'.$resultado['zone_id'].'</td>'."\n";
	echo '<td>' .$resultado['zone_owner']. '</td>'."\n";
	echo '<td>' .$resultado['zone_X1']. '</td>'."\n";
	echo '<td>' .$resultado['zone_X2']. '</td>'."\n";
	echo '<td>' .$resultado['zone_Y1']. '</td>'."\n";
	echo '<td>' .$resultado['zone_Y2']. '</td>'."\n";
	echo '<td>' .$resultado['zone_fight_alert']. '</td>'."\n";
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











