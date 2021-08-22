<?php
        require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>О нас</title>
	<link rel="shortcut icon" href="\Images\file.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<header>
	<div align=left><img src="\Images\file.png" width="200"><b><p align=center style="color:orange;font-size:500%;font-family:Arial;bottom: 245px;position: relative;">О нас</p></b></div>
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
	<p align="center" style="font-size:25px;font-family:Arial;color:#6ca6e1;margin:0;padding:0;">О нас:</p>
	<div style="background-color: #222c2a;">
	<p align=center style=color:orange;font-family:Arial;font-size:120%;>Адрес: Михайловский пр-д, 3, Москва</p>
	<p align=center style=color:orange;font-family:Arial;font-size:120%;>Контакты: +74957558181</p>
    <p align=center><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9520.261030130589!2d37.67145385999182!3d55.73309848625295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb3094c9287737cb8!2z0JDRg9C00Lgg0KbQtdC90YLRgCDQotCw0LPQsNC90LrQsA!5e0!3m2!1sru!2sru!4v1608429422748!5m2!1sru!2sru" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></p>
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