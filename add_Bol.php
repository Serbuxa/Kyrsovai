<?php
require_once 'config.php';
try{
	$db=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch(PDOException $e){
	print "Error!: " . $e->getMessage();
	die();
}

$ID = $_POST['id'];
$name = $_POST['n'];
$surname = $_POST['s'];
$patr = $_POST['p'];
$ID_Sotrydniki= $_POST['ids'];

if ($ID == 0) {
	$sql=sprintf("INSERT INTO `Pachientui` (`Name`,`Surname`,`Patronymic`,`ID_Sotrydniki`) VALUES ('%s','%s','%s',%d)", $name, $surname,$patr,$ID_Sotrydniki);
	$db->query($sql);
}
else {
	$sql=sprintf("UPDATE `Pachientui` SET `Name` = '%s', `Surname` = '%s', `Patronymic` = '%s', `ID_Sotrydniki` = %d WHERE `ID`=%d", $name, $surname,$patr,$ID_Sotrydniki,$ID);
	$db->query($sql);
}

?>
<meta http-equiv="refresh" content="0;url=Bolnica.php">