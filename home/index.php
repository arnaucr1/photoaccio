<html>
	<head>
	<title>PhotoAcció</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../imagenes/blue-camera.png"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/generic.css">
	</head>
	<?php
					include "../php/bbdd.php";
					session_start();
					if(!empty($_SESSION)){
						if(isset($_SESSION["email"])){	
							if($_SESSION["email"] == "admin@admin"){
								header('Location: ../admin/');		
							}else{
								$activity = selectUsuari($_SESSION["email"]);
								while ($fila = mysqli_fetch_assoc($activity)) {
										extract($fila);
										$id_soci = $id;
										$social_usu = $social;
								}
								if($social_usu == 1){
									$social_usu = "A <i class='fas fa-star'></i>";
									$concurs = selectConcursA();
								
								}else if($social_usu == 2){
									$social_usu = "B <i class='fas fa-star'></i>";
									$concurs = selectConcursB();	
								}
								else{
									$social_usu = "<i class='far fa-star'></i>";
									$concurs = selectConcurs();
								}
								$dataactual = datactual();
								$hora = strftime("%H");
								if($hora >= "13" AND $hora <= "20"){
									$momentdia = "Bona tarda :)";
								}else if($hora >= "5" AND $hora <= "13"){
									$momentdia = "Bon dia!";
								}else{
									$momentdia = "<i class='fas fa-moon'></i> Bona nit,";
								}
									?>
		<body>
			<nav class="navbar navbar-expand-lg  dark-nav">
			<a class="navbar-brand text-black googlesans" >
					<img src="../imagenes/blue-camera.png" width="30" height="30" class="d-inline-block align-top" alt=""> PhotoAcció </a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
						</li>
					</ul>
					 	<a href="../perfil/" style="margin-right:20px;" class="btn btn-personalized btn-rodo"><i class="fas fa-user-alt"></i> El meu perfil </a>		<a href="../cerrar_sesion.php" class="btn btn-info btn-rodo" ><i class="fas fa-sign-out-alt"></i> Tancar Sessió </a>	
				</div>
			</nav>
			<div class="tot">			
									<div class="container"> 
									<?php echo '<h1 class="titol googlesans">'. $momentdia.' '.utf8_encode ($nom).'</h1>'; ?>
									<br>
									<table class="table table-striped ">
											<thead>
												<tr>
												<th scope="col"><span class="badge badge-concurs btn-rodo txt-concrs"><i class="fas fa-medal"></i> Concursos oberts</span> </th>
												<th scope="col"><span class="badge btn-rodo txt-concrs">Tema</span> </th>
												<th scope="col"  class="text-center"><span class="badge  btn-rodo txt-concrs"><i class="fas fa-calendar-check"></i> Obertura</span></th>
												<th scope="col"  class="text-center"><span class="badge  btn-rodo txt-concrs"><i class="far fa-calendar-times"></i> Tancament</span></th>
												<th scope="col"  class="text-center"><span class="badge  btn-rodo txt-concrs"><i class="fas fa-book"></i> Bases</span></th>
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
												<td  class="text-center"><a href="'.utf8_encode ($bases).'" class="badge badge-success btn-rodo" target="_blank">Consultar bases</a></td>
												'; 
												
												if($estat == 1){
												if($participat == 1){ echo'
												<td  class="text-center"><button type="button" class="btn btn-danger inhabilitat btn-rodo">Completat</button></td>
													';} else{
														echo '
														<form action="../participa/index.php" method="post">
														<input type="hidden" name="idconcurs" value="'.$id.'" id="idconcurs"/>
														<td  class="text-center"><button type="submit" class="btn btn-primary btn-rodo">Participar</button></td>
														
														</form>
														';
													}}else{
														echo'<span class="badge badge-pill badge-danger"><?php echo $social_usu; ?></span> <td  class="text-center"><button type="button" class="btn btn-dark inhabilitat btn-rodo">Tancat</button></td>';	
													} echo'
												</tr>	
											';
										}	
										?>
										</tbody></table><span class="badge badge-light">Concursos disponibles avui <?php echo $dataactual; ?> organitzats per Acció Fotogràfica Ripollet.</span></div> 

				<div class="container">
					<br><br>
						<table class="table table-striped ">
											<thead>
												<tr>
												<th scope="col"><span class="badge badge-concurs2 btn-rodo txt-concrs"><i class="fas fa-trophy"></i> Classificacions </span> </th>
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
												$tipus = "A <i class='fas fa-star'></i>";
											}else if($tipus == 2){
												$tipus = "B <i class='fas fa-star'></i>";
											}
											else{
												$tipus = "";
											}
											echo'

												<tr>
												<td> '.utf8_encode ($nom).' <span class="badge badge-pill badge-danger">'.$tipus.'</span> </td>
												'; 
												 echo'
												</tr>	
											';
										}	
										?></tbody></table>Proximament</div> 
										
										</div>
										<?php }										
									}else{
										print "<script>window.location='../';</script>";
									}
									
								}else{
									print "<script>window.location='../';</script>";
								}
