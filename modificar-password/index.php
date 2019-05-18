<?php
include "../php/bbdd.php";
session_start();
 if(!empty($_SESSION)){
	 if(isset($_SESSION["email"])){	
		$conexion = conectar(); 
		$query = "SELECT * FROM socis where email=\"$_SESSION[email]\"  ";
		$query_searched = mysqli_query($conexion,$query);
		$count_results = mysqli_num_rows($query_searched);
		while ($row_searched = mysqli_fetch_array($query_searched)) {  
					$soci_id = $row_searched['id'];                                     		
					$pass_org = $row_searched['pass'];
								
			}
		
		
					?>
<head>
	<title>PhotoAcció </title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../imagenes/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">  <!-- Iconos -->
	<link rel="stylesheet" type="text/css" href="../css/modifica_soci/style.css">
	<link rel="stylesheet" href="../css/loader.css" />
	
<!--===============================================================================================-->
</head>
<body>
	 <!-- PRELOADER -->
	 <div class="preloader">
			<div class="loader">
			<div class="loader-inner"></div>
			</div>
		</div>
	<!-- PRELOADER -->
	<div class="limitador">
		<div class="todo">
			<div class="caja">				
				<form class="formulario" action="" method="post" >
					<span class="titulo">
					<i class="fa fa-lock" aria-hidden="true"></i> Contrasenya </span>
				<br>
				
					
					<div class="input" >
						<input class="caja-input" type="password" id="passw" name="passw"  autocomplete="new-password" placeholder="Contrasenya ACTUAL o Codi d'accés" required>					
						<span class="icono">
						<i class="fa fa-unlock-alt" aria-hidden="true"></i>
						</span>
					</div>	<br><br>
					<div class="input" >
						<input class="caja-input" type="password" id="passw1" name="passw1" autocomplete="new-password"  placeholder="Contrasenya NOVA" required>					
						<span class="icono">
						<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>	
					<div class="input" >
						<input class="caja-input" type="password" id="passw2" name="passw2"  autocomplete="new-password" placeholder="REPETEIX Contrasenya NOVA" required>					
						<span class="icono">
						<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="todo-form-btn">
						<button type="submit" class="caja-titulo-btn">
						Modificar
						</button>
					</div><br>
					</span>
				<?php
				require_once "../bbdd.php";
				if (isset($_POST["passw"])) {								
					
					$passw = $_POST["passw"];

					$passw1 = $_POST["passw1"];
					$passw2 = $_POST["passw2"];

			

					if(password_verify($_POST["passw"], $pass_org)){
							if($passw1 == $passw2){
								$password_hash2 = password_hash($passw2, PASSWORD_DEFAULT);
								$resultado = update_pass($password_hash2, $soci_id);

								if ($resultado == "ok") {							
										$updateutf4 = updateutf4($soci_id);
										print "<script>window.location='../perfil';</script>";
								} else {
									echo "<center><p>Error al Actualitzar <br> Contacta: web@afr.cat  &#128531;<br></p></center>";
								}
							}else{
								echo "<center><p>Contrasenyes <u> NO COINCIDEIXEN </u><br></p></center>";
							}


					}else{
						echo "<center><p><u>CONTRASEÑA ACTUAL</u> incorrecte<br></p></center>";
					}
					
										
				}
				?>
				<br><br>
					<div class="text-center">
						<a class="txt4" href="../perfil/">
						<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Tornar al perfil							
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

  <script src="../js/jquery-2.1.4.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
<?php	
	}else{
		header('Location: ../');
	}
	}else{
        header('Location: ../');
        }