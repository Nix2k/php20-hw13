<?php
	function clearInput($input) {
		return htmlspecialchars(strip_tags($input));
	}

	require_once './db-config.php';
	
	try {
    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
    	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	$sql = "SELECT * FROM `tasks`";	
	$data = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Мои дела</title>
</head>
<body>

<h1>Список дел</h1>

<table>
	<tr>
		<th>id</th>
		<th>Название</th>
		<th>Выполнено</th>
		<th>Дата добавления</th>
		<th colspan="2"></th>
	</tr>
<?php
	if ($data) {
		foreach ($data as $row) {
			echo "<tr><td>".$row['id']."</td><td>".$row['description']."</td><td>".$row['is_done']."</td><td>".$row['date_added']."</td><td><a href='done.php?id='".$row['id']."'>Выполнено</a></td><td><a href='delete.php?id='".$row['id']."'>Удалить</a></td></tr>";
		}
	}
	else {
		echo "Нет результатов";
	}
?>
</table>

</body>
</html>