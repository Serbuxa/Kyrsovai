<?php
require_once 'config.php';

try{
	$db=new PDO('pgsql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch(PDOException $e){
	print "Error!: " . $e->getMessage();
	die();
}

if(isset($_POST['token'])){
	$token=$_POST['token'];
	$sql=sprintf('SELECT "ID" FROM "users" WHERE "TOKEN" LIKE \'%s\' AND "EXPIRATION" > CURRENT_TIMESTAMP', $token);
	$stmt=$db->query($sql)->fetch();
	
	if(isset($stmt['ID'])){
		$surname=null;
		$name=null;
		$id_group=0;
		$logo=null;
		if(isset($_POST['surname']) && isset($_POST['name'])){
			$surname= $_POST['surname'];
			$name= $_POST['name'];
		}
		else{
			$result='{"error": {"text": "Не переданы параметры"}}';
			die($result);
		}
		
		$sql = 'INSERT INTO "students" ("NAME","SURNAME") VALUES (:name, :surname)';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":surname", $surname);
		$num = $stmt->execute();
		$result = '{"response": {"text": "Запрос успешно выполнен"}}';
	}
	else{
		$result = '{"error": {"text": "Неверный или просроченный токен"}}';
	}
}
else{
	$result = '{"errror": {"text": "Не передан токен"}}';
}
echo $result;
?>