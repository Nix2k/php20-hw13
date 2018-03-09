<?php

	require_once './db-config.php';
	
	function clearInput($input) {
		return htmlspecialchars(strip_tags($input));
	}

	try {
    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
    	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	$order = '';

	if (isset($_GET['sort'])) {
		$sort = clearInput($_GET['sort']);
		switch ($sort) {
			case 'desc':
				$order = ' ORDER BY `description`';
				break;
			case 'status':
				$order = ' ORDER BY `is_done`';
				break;
			case 'date':
				$order = ' ORDER BY `date_added`';
				break;
		}
	}

	$sql = "SELECT * FROM `tasks`".$order;
	$data = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Задачи</title>
</head>
<body>

<h1>Мои задачи</h1>
<form action="newtask.php" method="GET">
	<input type="text" name="desc" placeholder="Описание">
	<input type="submit" name="newtask" value="Добавить задачу">
</form>
<table>
	<tr>
		<th>id</th>
		<th><a href="index.php?sort=desc">Описание</a></th>
		<th><a href="index.php?sort=status">Статус</a></th>
		<th><a href="index.php?sort=date">Дата добавления</a></th>
		<th colspan="3">Действия</th>
	</tr>
<?php
	if ($data) {
		foreach ($data as $row) {
			$id = $row['id'];
			if ($row['is_done']==0) {
				$is_done = '<span style="color: red;">Не выполнено</span>';
				$workflow = "<a href='done.php?id=$id'>Выполнено</a>";
			}
			else {
				$is_done = '<span style="color: green;">Выполнено</span>';
				$workflow = "<a href='reopen.php?id=$id'>Открыть заново</a>";
			}
			echo "<tr><td>$id</td><td>".$row['description']."</td><td>$is_done</td><td>".$row['date_added']."</td><td>$workflow</td><td><a href='edit.php?id=$id'>Редактировать</a></td><td><a href='delete.php?id=$id'>Удалить</a></td></tr>";
		}
	}
	else {
		echo "Нет результатов";
	}
?>
</table>

</body>
</html>