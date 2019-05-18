<?php
function desconectar($conexion) {
    mysqli_close($conexion);
}
function conectar() {   
    $conexion = mysqli_connect("82.223.15.247:3306", "arnauafr", "Oloroncr89", "photoaccio");    
    if (!$conexion) {
        die("Base de dades: <font color='red'> DESCONECTADA </font> <a style='text-decoration:none;' href='javascript:location.reload()'> [ ACTUALITZAR ]</a>  ");
    } 
    return $conexion;
}
function insertar_soci($nom, $cognoms, $email, $password_hash, $infantil, $telefon, $postal){
   $con = conectar("root");
   $registrar = "INSERT INTO socis (id, nom, cognoms, email, pass, tipus, telefon, postal) VALUES ('', '$nom', '$cognoms', '$email', '$password_hash', $infantil, $telefon, '$postal')";
   $resultado = mysqli_query($con, $registrar);
   desconectar($con);
   return $resultado;
}
function insertar_participacio($socis_id, $concurs_id, $participat){
    $con = conectar("root");
    $registrar = "INSERT INTO participacions (socis_id, concurs_id, participat) VALUES ($socis_id, $concurs_id, $participat)";
    $resultado = mysqli_query($con, $registrar);
    desconectar($con);
    return $resultado;
 }
function updateutf($idu){
    $conexion = conectar($idu);
    $insert = "UPDATE socis SET nom = CONVERT(BINARY CONVERT(nom USING latin1) USING utf8) where id = $idu"; 
    $resultado = mysqli_query($conexion, $insert);
    desconectar($conexion);
    return $resultado;
 }
 function updateutf2($idu){
    $conexion = conectar($idu);
    $insert = "UPDATE socis SET cognoms = CONVERT(BINARY CONVERT(cognoms USING latin1) USING utf8) where id = $idu"; 
    $resultado = mysqli_query($conexion, $insert);
    desconectar($conexion);
    return $resultado;
 }
 function updateutf3($idu){
    $conexion = conectar($idu);
    $insert = "UPDATE socis SET email = CONVERT(BINARY CONVERT(email USING latin1) USING utf8) where id = $idu"; 
    $resultado = mysqli_query($conexion, $insert);
    desconectar($conexion);
    return $resultado;
 }
 function updateutf4($id){
    $conexion = conectar($id);
    $insert = "UPDATE socis SET entitat = CONVERT(BINARY CONVERT(entitat USING latin1) USING utf8) where id = $id"; 
    $resultado = mysqli_query($conexion, $insert);
    desconectar($conexion);
    return $resultado;
 }
 function eliminar($email){
    $con = conectar("root");
    $eliminar = "DELETE FROM socis WHERE email='$email' ";
    $resultado = mysqli_query($con, $eliminar);
    desconectar($con);
    return $resultado;
}
function eliminar_partis($id){
    $con = conectar("root");
    $eliminar = "DELETE FROM participacions WHERE socis_id=$id ";
    $resultado = mysqli_query($con, $eliminar);
    desconectar($con);
    return $resultado;
}
function update_soci( $telefon, $fede, $entitat, $soci_id){
    $con = conectar("root");
    $registrar = "UPDATE socis SET telefon=$telefon, fede='$fede', entitat='$entitat' WHERE id='$soci_id' ";
    $resultado = mysqli_query($con, $registrar);
    desconectar($con);
    return $resultado;
}
function update_pass($password_hash2, $soci_id){
    $con = conectar("root");
    $registrar = "UPDATE socis SET pass='$password_hash2' WHERE id='$soci_id' ";
    $resultado = mysqli_query($con, $registrar);
    desconectar($con);
    return $resultado;
}
function selectCiudades($provincia) {
    $connect = conectar();
    $select = "SELECT * FROM ciudad WHERE provincia='Barcelona'";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectEntitats() {
    $connect = conectar();
    $select = "SELECT * FROM entitats";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectUsuari($email) {
    $connect = conectar();
    $select = "SELECT * FROM socis where email='$email'";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectConcurs() {
    $connect = conectar();
    $select = "SELECT * FROM concurs where estat=1 and tipus=0 order by id DESC limit 4 ";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectConcursA() {
    $connect = conectar();
    $select = "SELECT * FROM concurs where estat=1 and tipus=0 or tipus=1 order by id DESC limit 4 ";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectConcursB() {
    $connect = conectar();
    $select = "SELECT * FROM concurs where estat=1 and tipus=0 or tipus=2 order by id DESC limit 4 ";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectParticipat($soci_id2, $id_concurs) {
    $connect = conectar();
    $select = "SELECT participat FROM participacions WHERE socis_id=$soci_id2 and concurs_id=$id_concurs limit 1";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectCiudad($postal_usu) {
    $connect = conectar();
    $select = "SELECT nombre FROM ciudad where id_ciudad=$postal_usu";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function totalParticipacions($soci_id_usu) {
    $connect = conectar();
    $select = "SELECT count(socis_id) as total FROM participacions where socis_id=$soci_id_usu";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function totalCompletats($soci_id_usu) {
    $connect = conectar();
    $select = "SELECT count(*) as total_cons FROM (SELECT concurs_id FROM participacions  where socis_id=$soci_id_usu  GROUP BY concurs_id)  as total_con";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function selectEntitat($entitat_usu) {
    $connect = conectar();
    $select = "SELECT * FROM entitats where id_entitat=$entitat_usu ";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function updatePass($entitat_usu, $soci_id_usu) {
    $connect = conectar();
    $select = "UPDATE `photoaccio`.`socis` SET `pass`='$entitat_usu' WHERE `id`='$soci_id_usu'";
    $result = mysqli_query($connect, $select);
    desconectar($connect);
    return $result;
}
function datactual() {
    
    $week_days = array ("Diumenge", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte");  
    $months = array ("", "de Gener", "de Febrer", "de Març", "d'Abril", "de Maig", "de Juny", "de Juliol", "d'Agost", "de Setembre", "d'Octubre", "de Novembre", "de Desembre");  
    $year_now = date ("Y");  
    $month_now = date ("n");  
    $day_now = date ("j");  
    $week_day_now = date ("w");  
    $date = $week_days[$week_day_now] . ", " . $day_now . " " . $months[$month_now] . " de " . $year_now;   
return $date;
}