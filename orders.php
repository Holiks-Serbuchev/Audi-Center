<!DOCTYPE html>
<html>
<head>
	<title>Заказы</title>
	<link rel="shortcut icon" href="\Images\file.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<script>
		if (window.history.replaceState ) {
  			window.history.replaceState( null, null, window.location.href );
		}
	</script>
	<?php
		$CountEnter = 0;
		require_once('connection.php');
		include('authscript.php');
		if (isset($_POST['Delete'])) {
			$stmt = $dsh->prepare("UPDATE `orders` SET `Status` = 'Удален' WHERE `orders`.`IDOrder` = :ID");
			$stmt->execute([':ID' => $_POST['Hid']]);
			echo "<script>alert('Данные успешно удалены');</script>";
		}
		$Login = $_GET['Login'];
		$Pass = $_GET['Pass'];
		$Check = Auth($_GET['Login'],$_GET['Pass']);
		$CustomArray = GetFullInformation($_GET['Login'],$Check);
    ?>
	<header>
	<div align=left><img src="\Images\file.png" width="200"><b><p align=center style="color:orange;font-size:500%;font-family:Arial;bottom: 245px;position: relative;">Покупка автомобиля</p></b></div>
	</header>
	<br>
	<?php
		echo "<p align=center><input type=button value=Главная страница onclick=location.href='index.php'>";
		echo "<input type=button value=Покупка автомобилей onclick=location.href='listauto.php?Login=".$Login."&Pass=".$Pass."'>";
		echo "<input type=button value=Авторизация onclick=location.href='auth.php'>";
		echo "<input type=button value=Регистрация onclick=location.href='reg.php'>";
		if ($Check == true && $Login != "" && $Pass != "" && $CustomArray[0]['Staff'] == "Администратор")
			echo "<input type=button value=Добавить onclick=location.href='addpanel.php?Login=".$Login."&Pass=".$Pass."'></p>";
		else if ($Check == true && $Login != "" && $Pass != "" && $CustomArray[0]['Staff'] != "Администратор")
			echo "<input type=button value=Заказы onclick=location.href='orders.php?Login=".$Login."&Pass=".$Pass."'></p>";
	?>
	<main>
		<p align="center" style="font-size:25px;font-family:Arial;color:#6ca6e1;padding:0;margin:0;">Заказы:</p>
		<div style="background-color: #222c2a;">
        	<?
        	$stmt = $dsh->prepare("SELECT orders.IDOrder,u.Login,u.`Password`,u.`Status`,c.IDCar,c.ModelCar,c.Image,c.YearOfIssue,c.Typeauto,c.Dash,c.Color,c.`Engine`,c.Transmission,c.Cost FROM orders JOIN cars AS c ON orders.IDCar = c.IDCar JOIN users AS u ON orders.IDUser = u.ID AND u.Login ='".$Login."' And orders.Status != 'Удален'");
        	$stmt ->execute();
        	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        	foreach ($result as $key => $value) {
                if ($Check == true && $Login != "" && $Pass != "") {
                    echo "<div style=background-color:#222c2a;><form method=POST><p align=center style=color:orange;font-family:Arial;font-size:120%;>".$result[$key]['ModelCar']."</p>";
                    echo "<p align=center><img src='data:image/*;base64,", base64_encode($result[$key]['Image']), "' alt='' width=350/></p>";
                    echo "<p align=center >Год выпуска: ".$result[$key]['YearOfIssue']."</p>";
                    echo "<p align=center >Тип авто: ".$result[$key]['Typeauto']."</p>";
                    echo "<p align=center >Пробег: ".$result[$key]['Dash']."</p>";
                    echo "<p align=center >Цвет: ".$result[$key]['Color']."</p>";
                    echo "<p align=center>Двигатель: ".$result[$key]['Engine']."</p>";
                    echo "<p align=center>Коробка: ".$result[$key]['Transmission']."</p>";
                    echo "<p align=center>Цена: ".$result[$key]['Cost']."</p>";
                    echo "<form method==POST><input type=hidden value='".$result[$key]['IDOrder']."' name=Hid><p align=center><input type=submit value=Удалить заказ name=Delete></p></form>";	
                }
                else
                    echo "<p align=center>Данная страница не доступна</p>";	
			}
        ?>
        </div>
	</main>
	<footer>
        <div>
			<ul style="list-style: none;padding-left:10px;">
				<li><a href="index.php">Офицальный дилер AudiIndustries</a><hr style="width:auto;padding:0; margin:0.5px;" size=2 color=#565656/></li>
				<li><a href="about.php">О нас</a><hr style="width:auto;padding:0; margin:0.5px;" size=2 color=#565656/></li>
                <li><p style="color:black;font-size:17px;padding:0; margin:0.5px;">© 1999-2020 ООО "Audi"</p></li>
				<li><p align=right style="padding:0; margin:1px;"><a href="https://www.youtube.com/channel/UCO5ujNeWRIwP4DbCZqZWcLw"><img src="\Images\youtube.ico" width="40" ></a>
				<a href="https://www.facebook.com/audiofficial/"><img src="\Images\facebook.ico" width="40"></a></p></li>
            </ul>
        </div>
    </footer>
</body>
</html>
