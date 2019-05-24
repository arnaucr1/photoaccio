<!DOCTYPE html>
<html lang="es">
<head>
	<title>PhotoAcció</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="../imagenes/blue-camera.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
<!--===============================================================================================-->
</head>
<body>
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="jumbotron" style="border-radius:16px;">
				<form  method="post" action="">
				<h1 class="text-center">Registra't</h1> <br>
					<div class="form-group">
						<input class="form-control btn-rodo" type="text" id="nom" name="nom" placeholder="Nom"  required>
					</div>
					<div class="form-group">
						<input class="form-control btn-rodo" type="text" id="cognoms" name="cognoms" placeholder="Cognoms" required>						
						<span class="icono">
					</div>
					<div class="form-group">
						<input class="form-control btn-rodo" type="email" id="email" name="email" placeholder="Correu Electrònic" autocomplete="new-password" required>						
					</div>
					<div class="form-group">
						<input class="form-control btn-rodo" type="number" id="telefon" name="telefon" placeholder="Telèfon de contacte" required>	
					</div>
					<div class="form-group"> 
                    <select name="ciudad" class="form-control btn-rodo" id="ciudad" required>
					<option value="" disabled selected>Selecciona Població</option>
						<?php
							include "../php/bbdd.php";
                            $Alava = selectCiudades("Alava");
                            while ($fila2 = mysqli_fetch_assoc($Alava)) { ?>
                                <option value="<?php echo $fila2["id_Ciudad"]; ?>">
                                <?php echo utf8_encode($fila2["nombre"]); ?>
                                </option><?php }?>
					</select>
					</div>
					<div class="form-group">
						<input class="form-control btn-rodo" type="password" id="pass1" name="pass1" placeholder="Contrasenya" autocomplete="new-password" required>						
					</div>
					<div class="form-group">
						<input class="form-control btn-rodo" type="password" id="pass2" name="pass2" placeholder="Repeteix la Contrasenya" autocomplete="new-password" required>						
					</div>
					<div class="input" style="border-radius: 30px;" >
					<input type='hidden' value='0' name="infantil">
						<input type="checkbox" id="check" value='1' name="infantil" /> 
							<label for="check" > 
							<span><!-- This span is needed to create the "checkbox" element --></span>Participació Infantil 🎈 
						</label>
					</div>
						<input type="checkbox" id="check" name="condicions" required/> 
							<label for="check2" > 
							Confirmes <b>haver llegit</b> i <b>acceptar</b> les <a href="../condicions/" class="control2" target="_blank">condicions d'ús.</a>
						</label>
					<br><br><a class="btn btn-info btn-rodo" href="../" style="color:white;" ><i class="fas fa-arrow-left"></i></a> <button class="btn btn-primary btn-rodo">Completar  </button>
					<?php
				require_once "../php/bbdd.php";
				if (isset($_POST["nom"])) {
					$telefon = $_POST["telefon"];
					$postal = $_POST["ciudad"];
					$nom = $_POST["nom"];
					$cognoms = $_POST["cognoms"];
					$email = $_POST["email"];
					$pass1 = $_POST["pass1"];
					$pass2 = $_POST["pass2"];
					$infantil = $_POST["infantil"];
					$nom = ucwords($nom);
					$cognoms = ucwords($cognoms); 
					if($email == "admin@admin"){
						echo "ERROR admin@admin no es pot registrar";
					}else{
					if ($pass1 == $pass2){
						$password_hash = password_hash($pass1, PASSWORD_DEFAULT);
						$insertar = insertar_soci($nom, $cognoms, $email, $password_hash, $infantil, $telefon, $postal);
						if ($insertar == "ok") { 
							$conexion = conectar(); 
							$query = "SELECT * FROM socis ";
							$query_searched = mysqli_query($conexion,$query);
							$count_results = mysqli_num_rows($query_searched);
							while ($row_searched = mysqli_fetch_array($query_searched)) {
										$idu = $row_searched['id'];
								}
								$updateutf = updateutf($idu);
								$updateutf2 = updateutf2($idu);
								$updateutf3 = updateutf3($idu);
								$updateutf4 = updateutf3($idu);
								print "<script>window.location='../';</script>";	
							} else {
								echo "<br><br><div class='alert alert-success btn-rodo' role='alert'><i class='fas fa-exclamation-triangle'></i> Ep! Correu ja registrat! </div>";
							}
					} else{
						echo "<br><br><div class='alert alert-success btn-rodo' role='alert'>ATENCIÓ: Revisa les contrasenyes!</div>";
					}
				}
			}
				?>
			</form>
		</div>
		<div class="alert alert-primary btn-rodo" role="alert">Aplicació desenvolupada per Arnau Canal Rial, <a class='alert-link' href="https://paypal.me/arnaucanal2"> convida'm a un cafè :) </a></div>
    </div>
 </div>
</body>
</html>
