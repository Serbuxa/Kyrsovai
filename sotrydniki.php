<?php
require_once 'config.php';

try{
	$db=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch(PDOException $e){
	print "Error!: " . $e->getMessage();
	die();
}
$surname ='';
$name ='';
$patronymic ='';
$id_dolgnost = 0;
$id = 0;
$sql=sprintf('SELECT s.ID,s.SURNAME,s.`NAME`,s.PATRONYMIC,d.Dolgnost AS DOLGNOST,d.ID AS ID_DOLGNOST FROM `Sotrydniki` AS s JOIN `Dolgnost` AS d ON s.ID_DOLGNOST=d.ID;');
$stmt=$db->query($sql);

$sql2=sprintf('SELECT * FROM `Dolgnost`');
$stmt2=$db->query($sql2);

if (isset($_GET['action'])) {
	// редактирование
	if ($_GET['action'] == 'edit') {
		$id = $_GET['id'];
		$sql3=sprintf('SELECT * FROM `Sotrydniki` WHERE ID = %d', $id);
		$stmt3=$db->query($sql3)->fetch();
		$surname = $stmt3['SURNAME'];
		$name = $stmt3['NAME'];
		$patronymic = $stmt3['PATRONYMIC'];
		$id_dolgnost = $stmt3['ID_DOLGNOST'];
	}
	// удаление
	if($_GET['action'] == 'delete'){
		$id = $_GET['id'];
		$sql3=sprintf('DELETE FROM `Sotrydniki` WHERE ID = %d', $id);
		$db->query($sql3);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Сотрудники</title>
	<link rel="stylesheet" href="styles.css">
	
</head>
<body>
	<table
	border="1"
	align="center"
	style="width:100%; border-radius:5px;">
	<tr><td>

		<table
		border="1"
		align="center"
		style="width:100%; border-radius:5px;">
		<tr><td>

			<table
			border="1"
			bgcolor="#E4EFD9;"
			style="width:100%; border-radius:5px;">
			<!--Создаём строку таблицы-->
			<tr><th>
			<!--Содержание ячейки столбца-->
			<h1>Больница</h1>
			<!--Закрываем таблицу-->
			</th></tr>
			</table>
            <link rel="stylesheet" href="SaytStyles.css">
			<nav class="two">
			  <ul>
				<li><a href="http://217.71.129.139:4825/Sayt.html">Главная</a></li>
				<li><a href="http://217.71.129.139:4825/Bolnica.php">Пациенты</a></li>
				<li><a href="http://217.71.129.139:4825/sotrydniki.php">Сотрудники</a></li>
				<li><a href="http://217.71.129.139:4825/Ob_organizachui.php">Об организации</a></li>
			  </ul>
			</nav>
		</td></tr>
		</table>


        <table
		border="1"
		align="center"
		style="width:100%; border-radius:5px;">
			<tr><td>
				<form action="add_sotr.php" method="post">
					<table
					border="1"
					bgcolor="66 CD AA;"
					align="left"
					style="width:80%; border-radius:5px;">
						<tr><td>
							<input type="text" name="id" hidden value="<?php echo $id;?>"><br>
							<span>Фамилия </span><br>		
							<input type="text" name="s" value="<?php echo $surname;?>"><br>	
							<span>Имя</span><br>
							<input type="text" name="n" value="<?php echo $name;?>"><br>		
							<span>Отчество</span><br>
							<input type="text" name="p" value="<?php echo $patronymic;?>"><br>	
							<span>Должность</span><br>
							<select name="idd">
							<?php
								while ($row = $stmt2->fetch()) {
									if ($id_dolgnost != $row['ID']) 
										echo'<option value="'.$row['ID'].'">'.$row['Dolgnost'].'</option>';
									else
										echo'<option value="'.$row['ID'].'" selected>'.$row['Dolgnost'].'</option>';
								}
							?>			
							</select>
						</td></tr>
					</table>

					<table
					border="1"
					bgcolor="#E4EFD9;"
					align="right"
					style="width:20%;  border-radius:5px;">
						<tr><td>
							<input type="submit" value=" Добавить" class="btn1">
							<input type="submit" value=" Сохранить" class="btn1">
						</td></tr>
					</table>

					<table
					border="1"
					align="right"
					style="width:100%; border-radius:5px;">
						<tr><td>
							<table border="1" style="width:100%; border-radius:5px;"> 
								<caption>Таблица сотрудников</caption>
								<tr>
									<th>Фамилия</th>
									<th>Имя</th>
									<th>Отчество</th>
									<th>Должность</th>
									<th></th>
									<th></th>
								</tr>
								<?php
									while ($row = $stmt->fetch()) {
										echo '<tr>';
										echo '<td>'.$row['SURNAME'].'</td>';
										echo '<td>'.$row['NAME'].'</td>';
										echo '<td>'.$row['PATRONYMIC'].'</td>';
										echo '<td>'.$row['DOLGNOST'].'</td>';
										echo '<td><a href="sotrydniki.php?action=edit&id='.$row['ID'].'">Редактировать</a></td>';
										echo '<td><a href="sotrydniki.php?action=delete&id='.$row['ID'].'">Удалить</a></td>';
										echo '</tr>';
									}
								?>
							</table>
						</td></tr>
					</table>
				</form>
			</td></tr>
		</table>
	</td></tr>
	</table>
</body>
</html>