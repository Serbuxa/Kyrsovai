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
$ID_Sotrydniki=0;
$Vupiska='';
$id_Vupiska=0;
$ID=0;
$sql=sprintf('SELECT p.ID, p.Surname,p.Name,p.Patronymic,s.SURNAME FROM `Pachientui` AS p JOIN `Sotrydniki` AS s ON p.ID_Sotrydniki=s.ID;');
$stmt=$db->query($sql);

$sql2=sprintf('SELECT * FROM `Vupiska`');
$stmt2=$db->query($sql2);

$sql4=sprintf('SELECT * FROM `Sotrydniki`');
$stmt4=$db->query($sql4);

if (isset($_GET['action'])) {
	// редактирование
	if ($_GET['action'] == 'edit') {
		$ID = $_GET['id'];
		$sql3=sprintf('SELECT * FROM `Pachientui` WHERE ID = %d', $ID);
		$stmt3=$db->query($sql3)->fetch();
		$surname = $stmt3['Surname'];
		$name = $stmt3['Name'];
		$patronymic = $stmt3['Patronymic'];
		$ID_Sotrydniki = $stmt3['ID_Sotrydniki'];
	}
	// удаление
	if($_GET['action'] == 'delete'){
		$ID = $_GET['id'];
		$sql3=sprintf('DELETE FROM `Pachientui` WHERE ID = %d', $ID);
		$db->query($sql3);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Пациенты</title>
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
				align="center"
				bgcolor="#E4EFD9;"
				style="width:100%; border-radius:5px;">
					<tr><th>
						<h1>Больница</h1>
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

				<form action="add_Bol.php" method="post">
					<table
					border="1"
					bgcolor="66 CD AA"
					align="left"
					style="width:80%; border-radius:5px;">
						<tr><td>
							<input type="text" name="id" hidden value="<?php echo $ID;?>"><br>	
							<span>Фамилия </span><br>
							<input type="text" name="s" value="<?php echo $surname;?>"><br>	
							<span>Имя</span><br>
							<input type="text" name="n" value="<?php echo $name;?>"><br>		
							<span>Отчество</span><br>
							<input type="text" name="p" value="<?php echo $patronymic;?>"><br>
							<span>Лечащий врач</span><br>	
								<select name="ids">
											<?php
												while ($row = $stmt4->fetch()) {
													if ($ID != $row['ID']) 
														echo'<option value="'.$row['ID'].'">'.$row['SURNAME'].'</option>';
													else
														echo'<option value="'.$row['ID'].'" selected>'.$row['SURNAME'].'</option>';
												}
											?>
								</select><br>
								<span>Выписка</span><br>
								<select >
									<?php
										while ($row = $stmt2->fetch()) {
											if ($id_Vupiska != $row['ID']) 
												echo'<option value="'.$row['ID'].'">'.$row['Vupiska'].'</option>';
											else
												echo'<option value="'.$row['ID'].'" selected>'.$row['Vupiska'].'</option>';
										}
									?>
								</select>
						</td></tr>					
					</table>
					<table
					border="1"
					align="right"
					bgcolor="#E4EFD9;"
					style="width:20%; border-radius:5px;">
						<tr><td>
							<input type="submit" value=" Добавить " class="btn1">
							<input type="submit" value=" Сохранить " class="btn1">
						</td></tr>	
					</table>
					<table
					border="1"
					align="right"
					style="width:100%; border-radius:5px;">
						<tr><td>
							<table border="1" style="width:100%; border-radius:5px;">  
								<caption>Таблица Пациентов</caption>
								<tr>
									<th>Фамилия</th>
									<th>Имя</th>
									<th>Отчество</th>
									<th>Врач</th>
									<th></th>
									<th></th>
								</tr>
								 <?php 
									while ($row = $stmt->fetch()) {
										echo '<tr>';
										echo '<td>'.$row['Surname'].'</td>';
										echo '<td>'.$row['Name'].'</td>';
										echo '<td>'.$row['Patronymic'].'</td>';
										echo '<td>'.$row['SURNAME'].'</td>';
										echo '<td><a href="Bolnica.php?action=edit&id='.$row['ID'].'">Редактировать</a></td>';
										echo '<td><a href="Bolnica.php?action=delete&id='.$row['ID'].'">Удалить</a></td>';
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