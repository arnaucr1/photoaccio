<?php
include "../php/bbdd.php";
session_start();
?>
<html>
	<head>
		<title>PhotoAcció</title>
		<meta charset="utf-8" />
		<link rel="icon" type="image/png" href="../imagenes/blue-camera.png"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="../css/generic.css">
	</head>

<?php
 if(!empty($_SESSION)){
	 if(isset($_SESSION["email"])){	
		$conexion = conectar(); 
		$usuari = selectUsuari($_SESSION["email"]);
		while ($fila = mysqli_fetch_assoc($usuari)) {
			extract($fila);
				$nom_usu = $nom;
				$cognoms_usu = $cognoms;
				$email_usu = $email;
				$infantil_usu = $tipus;
				$soci_id_usu = $id;
				$telefon_usu = $telefon;
				$postal_usu = $postal;
				$entitat_usu = $entitat;
				$fede_usu = $fede;
				$social_usu = $social;
		}
			$ciudad = selectCiudad($postal_usu);
			while ($fila = mysqli_fetch_assoc($ciudad)) {
				extract($fila);     
						$ciudad_usu = $nombre;
			}

			$totalPart = totalParticipacions($soci_id_usu);
			while ($fila = mysqli_fetch_assoc($totalPart)) {
				extract($fila);     
						$total_usu = $total;
			}
			if ($entitat != NULL){
			$entitatusu = selectEntitat($entitat_usu);
			while ($fila = mysqli_fetch_assoc($entitatusu)) {
				extract($fila);     
						$entitat_usu = $nom;
						$id_entitat_ext = $id_entitat;
			}
		}
				$completats = totalCompletats($soci_id_usu);
				while ($fila = mysqli_fetch_assoc($completats)) {
					extract($fila);     
							$total_con_usu = $total_cons;
				}?>
										<body>
										<nav class="navbar navbar-expand-lg navbar-dark dark-nav">
											<a class="navbar-brand googlesans" >
													<img src="../imagenes/blue-camera.png" width="30" height="30" class="d-inline-block align-top" alt=""> PhotoAcció </a>
												<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
													<span class="navbar-toggler-icon"></span>
												</button>
												<div class="collapse navbar-collapse" id="navbarSupportedContent">
													<ul class="navbar-nav mr-auto">
										
													</ul>
													<a href="../home/"  style="margin-right:20px"  class="btn btn-primary btn-rodo"><i class="fas fa-home"></i> Tornar a inici </a>		<a href="../cerrar_sesion.php" class="btn btn-info btn-rodo"><i class="fas fa-sign-out-alt"></i> Tancar Sessió </a>
												</div>
											</nav>	<div class="tot">	
												<?php
												if($social_usu == 1){
													$social_usu = "Social Grup A <i class='fas fa-star'></i>";
												}else if($social_usu == 2){
													$social_usu = "Social Grup B <i class='fas fa-star'></i>";
												}
												else{
													$social_usu = "<i class='far fa-star'></i>";
												}
												if($infantil_usu == 1){
													$infantil_usu = "Categoria Infantil";
												}else{
													$infantil_usu = "Categoria Adulta";
												}
												echo '
											
												<div class="container"><br>											
													<div class="row m-y-2">
																<div class="tab-pane" id="edit">
															<h4><i class="fas fa-user-alt"></i> El meu perfil <span class="badge badge-pill badge-danger" style="margin-left:20px; font-size:21px;">'.utf8_encode($social_usu).'</span></h4>
																	<p>Dades custodiades per <a href="https://ionos.es" target="blank_"><img width="90px" src="../imagenes/logo-ionos.png"></a> i administrades per Arnau Canal Rial | web@afr.cat</br>
																	PhotoAcció es una aplicació exclusiva per Acció Fotografica Ripollet. No utilitzem cookies.</p>
																	<span class="badge badge-secondary btn-rodo" style="margin-right:20px; font-size:21px;">Fotos enviades: '.utf8_encode($total_usu).'</span><span class="badge badge-secondary btn-rodo" style="margin-right:20px; font-size:21px;">Concursos participats: '.utf8_encode($total_con_usu).'</span><span class="badge badge-secondary btn-rodo" style="font-size:21px;">'.utf8_encode($infantil_usu).'</span><br><br>
																	<form role="form" action="index.php" method="post">
																		<div class="form-group row">
																			<label class="col-lg-3 col-form-label form-control-label">Nom</label>
																			<div class="col-lg-9">
																				<input class="form-control btn-rodo" type="text" value="'. utf8_encode($nom_usu).'" disabled>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-lg-3 col-form-label form-control-label">Cognoms</label>
																			<div class="col-lg-9">
																				<input class="form-control btn-rodo" type="text" value="'.utf8_encode($cognoms_usu).'" disabled>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-lg-3 col-form-label form-control-label">Email</label>
																			<div class="col-lg-9">
																				<input class="form-control btn-rodo" type="email" value="'.utf8_encode($email_usu).'" disabled>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-lg-3 col-form-label form-control-label">Telèfon</label>
																			<div class="col-lg-9">
																				<input class="form-control btn-rodo" name="telefon" id="telefon" type="number" minlength="9" maxlength="9" value="'.utf8_encode($telefon_usu).'">
																			</div>
																		</div>
																		<input type=hidden name="acces" id="acces">
																		<div class="form-group row">
																			<label class="col-lg-3 col-form-label form-control-label">Població</label>
																			<div class="col-lg-9">
																				<input class="form-control btn-rodo "  type="text" value="'.utf8_encode($ciudad_usu).'" disabled>
																			</div>
																		</div>																		<hr>
																		<div class="form-group row">
																		<label class="col-lg-3 col-form-label form-control-label">Entitat</label>
																		<div class="col-lg-9">
																			<select name="entitat" class="form-control btn-rodo" for="select-box1" id="entitat" >
																		';	if ($entitat == NULL){
																				?><option value="" disabled selected>Selecciona la teva entitat</option> <?php
																			 }else{
																				?><option value="<?php echo utf8_encode($id_entitat_ext); ?> " ><?php echo utf8_encode($entitat_usu); ?></option>' <?php
																			}
																					 $Alava = selectEntitats();
																					 while ($fila2 = mysqli_fetch_assoc($Alava)) {
																						 ?>
																						 <option value="<?php echo $fila2["id_entitat"]; ?>">
																							 <?php echo utf8_encode($fila2["nom"]); ?>
																						 </option>
																						 <?php
																					 }
																		echo '
																		</select>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-lg-3 col-form-label form-control-label">FCF</label>
																			<div class="col-lg-9">
																				<input class="form-control btn-rodo" name="fede" id="fede"  type="number" min="1" pattern="^[0-9]+" value="'.utf8_encode($fede_usu).'" placeholder="Número Federació Catalana de Fotografia">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-lg-3 col-form-label form-control-label"></label>
																			<div class="col-lg-9">
																				<button type="submit" class="btn btn-primary btn-rodo"> Guardar </button>
																			</div>
																		</div>
																	</form>
																	
																</div>  ';
																   	require_once "../php/bbdd.php";
																if (isset($_POST["acces"])) {								
																	$fede = $_POST["fede"];
																	$entitat = $_POST["entitat"];
																	$telefon = $_POST["telefon"];
																	$cognoms = ucwords ( $entitat);		
																	$resultado = update_soci( $telefon, $fede, $entitat, $soci_id_usu);
																		if ($resultado == "ok") {							
																				$updateutf4 = updateutf4($soci_id_usu);
																				print "<script>window.location='index.php';</script>";
																				
																		} else {
																			echo "<center><p>Error al Actualitzar <br> Contacta: web@afr.cat  &#128531;<br></p></center>";
																		}					
																} ?>
															</div><br>
														
															
															<!-- Canvi Password -->
															<button type="button" class="btn btn-secondary btn-rodo" style="margin-right: 20px;" data-toggle="modal" data-target="#password">
															<i class="fas fa-key"></i> Contrasenya
															</button>
															<div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title btn-rodo" id="exampleModalLabel"><i class="fas fa-key"></i> Modificar Contrasenya</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																<form  method="post" action="">
																<div class="form-group">
																	<input class="form-control btn-rodo" type="password" id="newpass1" name="newpass1" placeholder="Contrasenya NOVA" autocomplete="new-password" required>						
																</div>
																<div class="form-group">
																	<input class="form-control btn-rodo" type="password" id="newpass2" name="newpass2" placeholder="Repeteix la Contrasenya NOVA" autocomplete="new-password" required>						
																</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary btn-rodo" data-dismiss="modal">Tancar</button>
																	<button class="btn btn-primary btn-rodo">Guardar</button>
																</form>
																</div>
																</div>
															</div>
															</div>
															<!-- Canvi Password -->
															<!-- Eliminar compte -->
															<button type="button" class="btn btn-danger btn-rodo" data-toggle="modal" data-target="#deletepass">
															<i class="fas fa-trash-alt"></i> Eliminar Compte + Dades
															</button>
															<div class="modal fade" id="deletepass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash-alt"></i> Eliminar Compte</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																<b>A continuació eliminaras totes les teves dades y fotografies del servidor, no podràs recuperar res ni tornar entrar.
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary btn-rodo" data-dismiss="modal">Cancelar</button>
																	<a href="../eliminar/eliminar.php" class="btn btn-danger btn-rodo"><i class="fas fa-trash-alt"></i> CONTINUAR</a>
																</div>
																</div>
															</div>
															</div>
															<!-- Eliminar compte -->
															<br><br>
															<?php	
															if (isset($_POST["newpass1"])) {								
																$newpass1 = $_POST["newpass1"];
																$newpass2 = $_POST["newpass2"];
																	if($newpass1 == $newpass2){
																		$newpassdef = password_hash($newpass1, PASSWORD_DEFAULT);
																		$updatep = updatePass($newpassdef, $soci_id_usu);
																	if ($updatep == "ok") { 
																		echo "<div class='alert alert-success' role='alert'><i class='fas fa-smile-wink'></i> Contrasenya modificada correctament! </div>";
																	}
																	 }else{
																		echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Les contrasenyes no coincideixen. </div>";
																		}			
																	}
														?>
													</div>

												</div></div> 							
												</body>
												</html>	
											
										<?php
											
																						
				}else{
					print "<script>window.location='../';</script>";
				}
			}else{
				print "<script>window.location='../';</script>";
			}
?>
			<script  src="../js/finestra.js"></script>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
			<script src="http://code.angularjs.org/1.2.16/angular.min.js"></script>
			<script src="http://code.angularjs.org/1.2.16/angular-sanitize.min.js"></script>
			<script src="http://cdnjs.cloudflare.com/ajax/libs/bower-angular-translate/2.0.1/angular-translate.min.js"></script>
			<script src="http://rawgithub.com/m-e-conroy/angular-dialog-service/v4.2.0/example/js/ui-bootstrap-tpls-0.11.0.min.js"></script>
			<script src="http://rawgithub.com/m-e-conroy/angular-dialog-service/v4.2.0/dialogs.min.js"></script>
			