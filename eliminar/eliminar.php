<?php
include "../php/bbdd.php";
session_start();
 if(!empty($_SESSION)){
	 if(isset($_SESSION["email"])){	
		$participat = NULL;
			$conn = conectar();

			$sql = "SELECT id FROM socis WHERE email=\"$_SESSION[email]\"  limit 1";
			$result = $conn->query($sql);
															
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				 $id = $row["id"] ;
				}
			}
		$email = $_SESSION["email"];
	
			$eliminar = eliminar($email);
			$eliminar2 = eliminar_partis($id);

            if($eliminar == "ok"){
        
               						
                 print "<script>window.location='../';</script>";	
            }else{
                echo "<center><p>Error al eliminar<br> Contacta: web@afr.cat  &#128531;<br></p></center>";
            }
							
				}
			}else{
				print "<script>window.location='../';</script>";
			}
