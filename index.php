<?php
	include "php/bbdd.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>PhotoAcció</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="imagenes/blue-camera.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
<!--===============================================================================================-->
</head>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!empty($_POST)){
	if(isset($_POST["recuemail"])){

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';

$emailrecu = $_POST["recuemail"];

$soci_id_usu = NULL;
$conexion = conectar(); 
		$usuari = selectUsuari($_POST["recuemail"]);
		while ($fila = mysqli_fetch_assoc($usuari)) {
			extract($fila);
				$soci_id_usu = $id;
		}
		$newpass1 = NULL;
		if (!empty($soci_id_usu)) {
			function generateRandomString($length = 10) {
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
				return $randomString;
			}
		
			$newpass1 = generateRandomString();

			$newpassdef = password_hash($newpass1, PASSWORD_DEFAULT);
			$updatep = updatePass($newpassdef, $soci_id_usu);
			$mail = new PHPMailer();

			//Luego tenemos que iniciar la validación por SMTP:
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.1and1.es"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
			$mail->Username = "web@afr.cat"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
			$mail->Password = "Oloroncr8998"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
			$mail->Port = 587; // Puerto de conexión al servidor de envio. 
			$mail->From = "web@afr.cat"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
			$mail->FromName = "PhotoAccio"; //A RELLENAR Nombre a mostrar del remitente. 
			$mail->AddAddress($emailrecu); // Esta es la dirección a donde enviamos 
			$mail->IsHTML(true); // El correo se envía como HTML 
			$mail->Subject = "Contrasenya temporal"; // Este es el titulo del email. 
			$body = "MISSATGE AUTOMATIC: S'ha generat una nova contrasenya al teu compte de PhotoAccio. Es aquesta: <b>". $newpass1 ."</b>"; 
			$body .= "<br><br> Inicia sessio amb la clau proporcionada i ves a <b>El meu perfil</b> i modifica la contrasenya per una teva."; $mail->Body = $body;  $exito = $mail->Send(); // Envía el correo.
			if($exito){ echo ''; }else{ echo ''; } 
			
				}
			}
			
		}
?>
<body>
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="jumbotron" style="border-radius:16px;">
				<form  method="post" action="">
				<h1 class="text-center titol"><img src="imagenes/blue-camera.png" width="50" height="50" class="d-inline-block align-top" alt=""> PhotoAcció</h1>
				<h6 class="text-center">Versió 4.3</h6> 
					<div class="form-group">
					<label for="exampleInputEmail1"><b>Correu electrònic</b></label>
						<input  class="form-control btn-rodo"  type="email" id="username" name="username" placeholder="Escriu el teu correu electrònic" required>
						<small id="emailHelp" class="form-text text-muted">Mai compartirem el teu correu electrònic.</small>
					</div>
					<div class="form-group">
					<label for="exampleInputEmail1"><b>Contrasenya</b></label>
						<input class="form-control btn-rodo" type="password" id="pass"  placeholder="Escriu la teva contrasenya" name="pass" required>
					</div>
					<button class="btn btn-primary btn-rodo">Entrar </button><br><br>
					<a class="btn btn-info btn-rodo" style="color:white;"  data-toggle="modal" data-target="#password" ><i class="fas fa-key"></i> </a>	<a class="btn btn-success btn-rodo" href="registre/"> Registre  <i class="fa fa-plus-circle" aria-hidden="true"></i></a>			
				
				
				</form>
				<?php
						
							if(!empty($_POST)){
								if(isset($_POST["username"])){	
									$password=null;
									$con = conectar(); 
									$sql1= "select pass from socis where (email=\"$_POST[username]\") ";
									$query = $con->query($sql1);
									while ($r=$query->fetch_array()) {
									$password=$r["pass"]; 									
									break; }
									$email = $_POST["username"];
									if(password_verify($_POST["pass"], $password)){
										session_start(); 
										$_SESSION["email"] = $email;
										header('Location: home/');				
									}else{
										echo "<br><div class='alert alert-secondary' role='alert'><i class='fas fa-exclamation-triangle'></i> Dades incorrectes, per <a class='alert-link' >recuperar contrasenya al botó <i class='fas fa-key'></i></a></a></div>";
									}
								}
							}
							?>
			</div>
			<div class="alert alert-primary mic" role="alert">Aplicació desenvolupada per Arnau Canal Rial, <a class='alert-link' href="https://paypal.me/arnaucanal2"> convida'm a un cafè :) </a></div>
	</div>
    </div>
</div>
<div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-key"></i> Recuperar contrasenya</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																<form  method="post" action="">
																	<p>Escriu el correu electrònic registrat al PhotoAcció i rebràs una contrasenya temporal per entrar.
																		<br><br>
																		Si en 10 minuts no reps cap correu contacta amb web@afr.cat
																	</p>
																<div class="form-group">
																	<input class="form-control btn-rodo" type="email" id="recuemail" name="recuemail" placeholder="Correu electrònic" autocomplete="new-password" required>						
																</div>
															
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary btn-rodo" data-dismiss="modal">Tancar</button>
																	<button class="btn btn-primary btn-rodo">Recuperar</button>
																</form>
																</div>
																</div>
															</div>
															</div>		
</body>
</html>