<?php

	require ('../conexion.php');

	$id_encuesta = $_POST['id_encuesta'];

	$query10 = "SELECT * FROM encuestas WHERE id_encuesta = '$id_encuesta'";
	$resultado10 = $con->query($query10);
	$row10 = $resultado10->fetch_assoc();

  	$ids = array();

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Favicon - FIS -->
  <link rel="shortcut icon" href="../imagenes/Logo-fis.png">

  <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">


  <title>Procesar</title>
</head>
<body>

<?php
    require '../navbar.php';
?>

	<center>
		<div style="margin-top: 50px"></div>
		<?php


		$id_usuario = $_SESSION['id_usuario'];

		$query5 = "SELECT * FROM usuarios_encuestas WHERE id_usuario = '$id_usuario' AND id_encuesta = '$id_encuesta'";
		$resultado5 = $con->query($query5);
		$tamaño = $resultado5->num_rows;

		if ($tamaño > 0) {
			echo "Ya respondiste la encuesta";
			echo "<br/>";
		} else {

			$query6 = "INSERT INTO usuarios_encuestas (id_usuario, id_encuesta) VALUES ('$id_usuario', '$id_encuesta')";
			$resultado6 = $con->query($query6);

			if ($row10['estado'] == '1') {
			 	for ($i = 1; $i <= 100; $i++) {

					if (isset($_POST[$i])) {
						$ids[$i] = $_POST[$i];

						$id = $ids[$i];

						$query2 = "SELECT id_opcion, id_pregunta, valor FROM opciones WHERE id_opcion = '$ids[$i]'";
						$resultado2 = $con->query($query2);

						if ($row2 = $resultado2->fetch_assoc()) {
							$id_opcion = $row2['id_opcion'];
							$query3 = "INSERT INTO resultados (id_opcion) 
							VALUES ('$id_opcion')";
							$resultado3 = $con->query($query3);
							if ($resultado3) {
								echo "Resultado ingresado";
								echo "<br/>";
							} else { 
								echo "Error al ingresar resultado";
							} 
						}
					}
				}
			} else {
				echo "<div style='margin-top: 50px;'>ERROR!<br/>La encuesta se encuentra cerrada</div>";
			}
		}

		 ?>

		<br/>
		<a class="btn btn-primary" href="index.php">VOLVER</a>
	</center>

 	<!-- Optional JavaScript -->
 	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
 	<script src="../js/jquery-3.3.1.slim.min.js"></script>
 	<script src="../js/popper.min.js"></script>
 	<script src="../js/bootstrap.min.js"></script>
</body>
</html>