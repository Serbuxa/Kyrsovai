<?php
require_once 'config.php';
try{
	$db=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch(PDOException $e){
	print "Error!: " . $e->getMessage();
	die();
}

$id = $_POST['id'];
$name = $_POST['n'];
$surname = $_POST['s'];
$patr = $_POST['p'];
$id_dolgnost= $_POST['idd'];

if ($id == 0) {
	$sql=sprintf("INSERT INTO `Sotrydniki` (`NAME`,`SURNAME`,`PATRONYMIC`,`ID_DOLGNOST`) VALUES ('%s','%s','%s',%d)", $name, $surname,$patr,$id_dolgnost);
	$db->query($sql);
}
else {
	$sql=sprintf("UPDATE `Sotrydniki` SET `NAME` = '%s', `SURNAME` = '%s', `PATRONYMIC` = '%s', `ID_DOLGNOST` = %d WHERE `ID`=%d", $name, $surname,$patr,$id_dolgnost,$id);
	$db->query($sql);
}

?>
<meta http-equiv="refresh" content="0;url=sotrydniki.php">