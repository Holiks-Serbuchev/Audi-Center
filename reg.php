<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
	<link rel="shortcut icon" href="\Images\file.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<script>
		if (window.history.replaceState ) {
  			window.history.replaceState( null, null, window.location.href );
		}
		function SubClick() {
            if (document.getElementById("SurTB").value == "" || document.getElementById("NameTB").value == "" || document.getElementById("PatrTB").value == "" || document.getElementById("TelTB").value == "" || document.getElementById("LoginTB").value == "" || document.getElementById("PassTB").value == "")
                alert("Пожалуйста заполните все поля для ввода");
            else
                document.getElementById("Holiks").submit();
        }
	</script>
	<?php
		require_once('connection.php');
		include('authscript.php');
		if (isset($_POST['Hid'])) {
				$stmt = $dsh->prepare("INSERT INTO `audicenter`.`users` (`Surname`, `Name`, `Patronymic`, `TelephoneNum`, `Login`, `Password`, `Staff`, `Status`) VALUES (:Sur, :Name, :Patr, :Tel,  :Login, :Pass, 'Пользователь', 'Доступен')");
				$stmt->bindValue(':Sur',$_POST['SurTB']);
				$stmt->bindValue(':Name',$_POST['NameTB']);
				$stmt->bindValue(':Patr',$_POST['PatrTB']);
				$stmt->bindValue(':Tel',$_POST['TelTB']);
				$stmt->bindValue(':Login',$_POST['LoginTB']);
				$stmt->bindValue(':Pass',$_POST['PassTB']);
				$stmt->execute();
				echo "<script>alert('Вы успешно зарегестрировались');</script>";
				$Link = "listauto.php?Login=".$_POST['LoginTB']."&Pass=".$_POST['PassTB'];
				echo "<script/>window.location = '".$Link."';</script>";
		}
    ?>
	<header>
	<div align=left><img src="\Images\file.png" width="200"><b><p align=center style="color:orange;font-size:500%;font-family:Arial;bottom: 245px;position: relative;">Регистрация</p></b></div>
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
		<p align="center" style="font-size:25px;font-family:Arial;color:#6ca6e1;margin:0;padding:0;">Форма заполнения:</p>
		<div style="background-color: #222c2a;">
        	<?
					echo "<form method=POST id=Holiks enctype=multipart/form-data>";
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Фамилия:</p>";
					echo "<p align=center><input id=SurTB name=SurTB type=text></p>";
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Имя:</p>";
					echo "<p align=center><input id=NameTB name=NameTB type=text></p>";
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Отчество:</p>";
					echo "<p align=center><input id=PatrTB name=PatrTB type=text></p>";
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Номер телефона:</p>";
					echo "<p align=center><input id=TelTB name=TelTB type=text></p>";
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Логин:</p>";
					echo "<p align=center><input id=LoginTB name=LoginTB type=text></p>";
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Пароль:</p>";
					echo "<p align=center><input id=PassTB name=PassTB type=password></p>";
					echo "<p align=center><input type=button name=ClickB id=button value=Зарегистрироваться onClick=SubClick();></p>";
					echo "<input type=hidden name=Hid id=Hid>";
					echo "<br><br><br><br><br><br>";
            		echo "<div><hr style=width:auto; size=6 color=#151716 /></div></form>";
        	?>
        </div>
	</main><br><br><br><br><br><br><br><br>
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