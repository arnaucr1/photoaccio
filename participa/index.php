<meta charset="UTF-8">
  						<title>PhotoAcció</title>
						  <meta charset="UTF-8">
						  <meta name="viewport" content="width=device-width, initial-scale=1">
  						<link rel="icon" type="image/png" href="../imagenes/blue-camera.png"/>
						<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
						<link rel="stylesheet" href="../css/generic.css">
						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
						
						<nav class="navbar navbar-expand-lg  dark-nav">
			<a class="navbar-brand text-black googlesans" >
					<img src="../imagenes/blue-camera.png" width="30" height="30" class="d-inline-block align-top " alt=""> PhotoAcció </a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							
						</li>
						
					</ul>
					<a href="../home/"  class="btn btn-primary btn-rodo"><i class="fas fa-home"></i> Tornar a inici </a>	
				</div>
			</nav>
			<div class="tot">
			<div class="container" style=" text-align:center; height:600px; ">
			
<?php
include "../php/bbdd.php";
session_start();
 if(!empty($_SESSION)){
	 if(isset($_SESSION["email"])){	
		
		$idconcurs = "";
		if(isset($_POST["idconcurs"]))
		{
			$_SESSION['cedula'] =  $idconcurs = $_POST["idconcurs"];
		}
		elseif(isset($_SESSION["cedula"]))
		{
			$idconcurs = $_SESSION['cedula'];
		}
		
		$conn = conectar();
		$sql = "SELECT id FROM socis WHERE email=\"$_SESSION[email]\" limit 1";
		$result = $conn->query($sql);
															
		if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$soci_id = $row["id"] ;
			}
		}
		$participat = "";
		$participacio = selectParticipat($soci_id, $idconcurs);
			while ($fila = mysqli_fetch_assoc($participacio)) {
				extract($fila);     
				
			}
		if($participat == null){	
					$con = conectar(); 
					$sql1= "select * from socis where (email=\"$_SESSION[email]\") ";
					$query = $con->query($sql1);
					while ($r=$query->fetch_array()) {
					$id=$r["id"]; 									
					break;
				}
				$carpetaDestino2="../img/$idconcurs";
				@mkdir($carpetaDestino2);
					$conexion = conectar();
					$query = "SELECT * FROM concurs where id='$idconcurs' ";
					$query_searched = mysqli_query($conexion,$query);
					$count_results = mysqli_num_rows($query_searched);	
					while ($row_searched = mysqli_fetch_array($query_searched)) {                                       
						$concurs = $row_searched['nom']; 						
						}
					?> <h1 class='googlesans'> <?php echo utf8_encode($concurs); ?></h1>
					<?php
			
						# definimos la carpeta destino
						$carpetaDestino="../img/$idconcurs/$id/";
						# si hay algun archivo que subir
						if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0])					
						{
							# recorremos todos los arhivos que se han subido
							for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)					
							{
								 # si es un formato de imagen					
								if($_FILES["archivo"]["type"][$i]=="image/jpeg" || $_FILES["archivo"]["type"][$i]=="image/pjpeg" || $_FILES["archivo"]["type"][$i]=="image/gif" || $_FILES["archivo"]["type"][$i]=="image/png" )					
								{
									
									# si exsite la carpeta o se ha creado					
									if(file_exists($carpetaDestino) || @mkdir($carpetaDestino, true))					
									{	
										$origen=$_FILES["archivo"]["tmp_name"][$i];
										
										
										$destino=$carpetaDestino.$_FILES["archivo"]["name"][$i];
										# movemos el archivo
									
										if(@move_uploaded_file($origen, $destino))
										{

										$image_file = $destino;
										$l = strtolower($image_file);
										$parse_file_name = explode(".", $l);
										$file_ext = end($parse_file_name); 
										error_reporting(E_ERROR | E_PARSE);
										if(!exif_read_data($image_file)){
											$nomfoto = $_FILES["archivo"]["name"][$i];
											$participat = 1;
											$socis_id = $id;
											$concurs_id= $idconcurs;
											$insertar = insertar_participacio($socis_id, $concurs_id, $participat, $nomfoto);
											
										echo "<br><br><div class='alert alert-success btn-rodo' role='alert'>".$_FILES["archivo"]["name"][$i]." | L'imatge no te dades exif.  <b> Pujada correctament </b> 🙂</div>";			
										}else{
											
											$exif_data = exif_read_data($image_file);
											$photos[] = [
												'DateTime' =>$exif_data['DateTime']
											];
											foreach($photos as $data):
											$datafoto = $data['DateTime'];
										endforeach;
										/* if($datafoto < "2019:00:00 00:00:00"){ */

											echo "<br><br><div class='alert btn-rodo alert-danger' role='alert'>".$_FILES["archivo"]["name"][$i]." | <b><i class='fas fa-exclamation-triangle'></i> Error: l'imatge no es de 2019 </b> <i class='fas fa-exclamation-triangle'></i></div>";	
											unlink($destino);
										/* }else{ */
											$nomfoto = $_FILES["archivo"]["name"][$i];
											$participat = 1;
											$socis_id = $id;
											$concurs_id= $idconcurs;
											$insertar = insertar_participacio($socis_id, $concurs_id, $participat, $nomfoto);
											
										echo "<br><br><div class='alert alert-success btn-rodo' role='alert'>".$_FILES["archivo"]["name"][$i]." | <b>Pujada correctament </b> 🙂</div>";										
										/* } */
									}
										}else{
											echo "<br>No se ha podido mover el archivo: ".$_FILES["archivo"]["name"][$i];
										}
									}else{
										echo "<br>No se ha podido crear la carpeta: ".$carpetaDestino;
									}
								}else{
									if(empty($_FILES["archivo"]["name"][$i])){

									echo "<div class='button-4'>".$_FILES["archivo"]["name"][$i]." Sense imatge 🤨 </div> ";

									}else{
									
										
									echo "<div class='button-3 btn-rodo'>".$_FILES["archivo"]["name"][$i]." |  <u>Error de format</u> o <u>Imatge masa gran.</u> &#128530 </div> ";
									}
								}
							}
						}else{
							echo "<br><span class='badge  btn-rodo badge-warning'>🧐 Assegura't que les fotos siguin les correctes i compleixin les bases 🧐</span>";
					
							echo "<br><br><div class='text-b'> Fes click als + per pujar les imatges.</div><br><br>";
							
							?>

			<center>	<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data" name="inscripcion">								
								<div class="wrapper">
									<div class="box">
										<div class="js--image-preview"></div>
										<div class="upload-options">
											<label>
												<input type="file" accept="image/x-png,image/jpeg" name="archivo[]" class="image-upload"  />
											</label>
										</div>
									</div>

									<div class="box">
										<div class="js--image-preview"></div>
										<div class="upload-options">
											<label>
												<input type="file" accept="image/x-png,image/jpeg" name="archivo[]" class="image-upload" />
											</label>
										</div>
									</div>

									<div class="box">
										<div class="js--image-preview"></div>
										<div class="upload-options">
											<label>
												<input type="file" accept="image/x-png,image/jpeg" name="archivo[]" class="image-upload" />
											</label>
										</div>
									</div>

									<div class="box">
										<div class="js--image-preview"></div>
										<div class="upload-options">
											<label>
												<input type="file" accept="image/x-png,image/jpeg"  name="archivo[]" class="image-upload" />
											</label>
										</div>
									</div>
								</div><br><br><br>
							<button class="btn btn-success btn-rodo btn-enviar">Enviar Fotos <i class="fa fa-rocket" aria-hidden="true"></i></button>
						</form>	</center>
					
					    <script  src="../js/index.js"></script>
						<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  
					</body>
					</div>	</div>					
					</html> 
					<?php
						}
						
				}else{
					print "<script>window.location='../home/';</script>";
				}
	 }
			}else{
				print "<script>window.location='../index.php';</script>";
			}