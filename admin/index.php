<html>
	<head>
	<title>Administrador PhotoAcció</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../imagenes/blue-camera.png"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
	<link rel="stylesheet" href="../css/generic.css">
	</head>
	<?php
					include "../php/bbdd.php";
					session_start();
					if(!empty($_SESSION)){
						if(isset($_SESSION["email"])){
							if($_SESSION["email"] == "admin@admin"){
								$activity = selectUsuari($_SESSION["email"]);
								while ($fila = mysqli_fetch_assoc($activity)) {
										extract($fila);
										$id_soci = $id;
										$social_usu = $social;
										$soci_id_usu = $id;
								}
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
										
								
									$concurs = selectConcurs();
								
								$dataactual = datactual();
									?>
		<body>
			<nav class="navbar navbar-expand-lg  dark-nav">
			<a class="navbar-brand text-black" >
					<img src="../imagenes/blue-camera.png" width="30" height="30" class="d-inline-block align-top" alt=""> Administrador </a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
						</li>
					</ul>
					
															<!-- Canvi Password -->
															<button type="button" class="btn btn-secondary" style="margin-right: 20px;" data-toggle="modal" data-target="#password">
															<i class="fas fa-key"></i> Contrasenya
															</button>
															<div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-key"></i> Modificar Contrasenya</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																<form  method="post" action="">
																<div class="form-group">
																	<input class="form-control" type="password" id="newpass1" name="newpass1" placeholder="Contrasenya NOVA" autocomplete="new-password" required>						
																</div>
																<div class="form-group">
																	<input class="form-control" type="password" id="newpass2" name="newpass2" placeholder="Repeteix la Contrasenya NOVA" autocomplete="new-password" required>						
																</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Tancar</button>
																	<button class="btn btn-primary">Guardar</button>
																</form>
																</div>
																</div>
															</div>
															</div>
															<!-- Canvi Password -->		<a href="../cerrar_sesion.php" class="btn btn-info" ><i class="fas fa-sign-out-alt"></i> Tancar Sessió </a>	
				</div>
			</nav>
			<div class="tot">			
									<div class="container">
									<br><br><?php echo '<h1 class="titol"> '.$dataactual.'</h1>'; 
								
									?><br>
									<!-- Afegir Concurs -->
									<button type="button" class="btn btn-secondary" style="margin-right: 20px;" data-toggle="modal" data-target="#afegirconcurs">
															<i class="fas fa-plus-circle"></i> Crear concurs
															</button>
															<div class="modal fade" id="afegirconcurs" tabindex="-1" role="dialog" aria-labelledby="afegirconcurs" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="afegirconcurs"><i class="fas fa-plus-circle"></i> Crear concurs</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																<form  method="post" action="">
																<div class="form-group">
																<label for="exampleInputEmail1"><b>Nom</b></label>
																	<input class="form-control" type="text" id="nomconcurs" name="nomconcurs" placeholder="Nom del concurs" autocomplete="new-password" required>						
																</div>
																<div class="form-group">
																<label for="exampleInputEmail1"><b>Tema</b></label>
																	<input class="form-control" type="text" id="tema" name="tema" placeholder="Tema del concurs" autocomplete="new-password" required>						
																</div>
																<div class="form-group">
																<label for="exampleInputEmail1"><b>Data tancament</b></label>
																	<input class="form-control" type="date" id="obertura" name="tancament" placeholder="Tancament" autocomplete="new-password" required>						
																</div>
																<div class="form-group">
																<label for="exampleInputEmail1"><b>Enllaç (Url) Bases del concurs</b></label>
																	<input class="form-control" type="text" id="bases" name="bases" placeholder="https://afr.cat/bases/" autocomplete="new-password" required>						
																</div>
																	<input type='hidden' value='0' name="fotosany">
																	<input type="checkbox" id="check" value='1' name="fotosany" /> 
																		<label for="check" > 
																		<span></span>Acceptar només fotos d'aquest any. 
																	</label>
																	<br>
																	<input type='hidden' value='0' name="infantil">
																	<input type="checkbox" id="check" value='1' name="infantil" /> 
																		<label for="check" > 
																		<span></span>Activar participació infantil. 
																	</label>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Tancar</button>
																	<button class="btn btn-primary">Crear</button>
																</form>
																</div>
																</div>
															</div>
															</div>
									<!-- Afegir Concurs -->	<br><br>
									<table class="table table-striped ">
											<thead>
												<tr>
												<th scope="col">Concursos </th>
												<th scope="col">Tema </th>
												<th scope="col"  class="text-center">📅 Obertura</th>
												<th scope="col"  class="text-center">📆 Tancament</th>
												<th scope="col"  class="text-center">📑 Bases</th>
												<th scope="col" class="text-center"></th>
												</tr>
											</thead>
											<tbody>
									<?php	
										
										while ($fila = mysqli_fetch_assoc($concurs)) {
												extract($fila);
												$id_concurs = $id;
												$participat = NULL;
										$activity2 = selectParticipat($id_soci, $id_concurs);
										while ($fila2 = mysqli_fetch_assoc($activity2)) {
												extract($fila2);
											}
											if($tipus == 1){
												$tipus = "Grup A <i class='fas fa-star'></i>";
											}else if($tipus == 2){
												$tipus = "Grup B <i class='fas fa-star'></i>";
											}
											else{
												$tipus = "";
											}
											echo'

												<tr>
												<td> '.utf8_encode ($nom).' <span class="badge badge-pill badge-danger">'.$tipus.'</span> </td>
												<td> '.utf8_encode ($tema).' </td>
												<td  class="text-center">'.utf8_encode ($obertura).'</td>
												<td  class="text-center">'.utf8_encode ($tancament).'</td>
												<td  class="text-center"><a href="'.utf8_encode ($bases).'" class="badge badge-success" target="_blank">Consultar bases</a></td>
												'; 
												
												if($estat == 1){
												if($participat == 1){ echo'
												<td  class="text-center"><button type="button" class="btn btn-danger inhabilitat">Completat</button></td>
													';} else{
														echo '
														<form action="../participa/index.php" method="post">
														<input type="hidden" name="idconcurs" value="'.$id.'" id="idconcurs"/>
														<td  class="text-center"><button type="submit" class="btn btn-primary">Participar</button></td>
														
														</form>
														';
													}}else{
														echo'<span class="badge badge-pill badge-danger"><?php echo $social_usu; ?></span> <td  class="text-center"><button type="button" class="btn btn-dark inhabilitat">Tancat</button></td>';	
													} echo'
												</tr>	
											';
										}	
										?></tbody></table></div> 
											<?php	
															if (isset($_POST["newpass1"])) {								
																$newpass1 = $_POST["newpass1"];
																$newpass2 = $_POST["newpass2"];
																	if($newpass1 == $newpass2){
																		$newpassdef = password_hash($newpass1, PASSWORD_DEFAULT);
																		$updatep = updatePass($newpassdef, $soci_id_usu);
																	if ($updatep == "ok") { 
																		/* echo "<div class='alert alert-success' role='alert'><i class='fas fa-smile-wink'></i> Contrasenya modificada correctament! </div>"; */
																	}
																	 }else{
																		echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Les contrasenyes no coincideixen. </div>";
																		}			
																	}
														?>	
				
										
										</div>
										<?php	
											}else{	print "<script>window.location='../';</script>"; }									
									}else{
										print "<script>window.location='../';</script>";
									}
								}else{
									print "<script>window.location='../';</script>";
								}
