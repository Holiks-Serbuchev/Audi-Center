<?php
        require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Покупка авто</title>
	<link rel="shortcut icon" href="\Images\file.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="index.css">
    <script>
        function SubClick() {
            if (document.getElementById("SurnameTB").value == "" || document.getElementById("NameTB").value == "" || document.getElementById("PatrTB").value == "" || document.getElementById("TelephoneTB").value == "")
                alert("Пожалуйста заполните все поля для ввода");
            else
                document.getElementById("Holiks").submit();
        }
    </script>
</head>
<body>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
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
        <p align="center" style="font-size:25px;font-family:Arial;color:#6ca6e1;padding:0;margin:0;">Покупка авто:</p>
        <div style="background-color: #222c2a;">
		<form method="POST" id="Holiks">
        <p align="center" style="font-size:20px;font-family:Arial;color:orange;">Введите фамилию:</p>
        <p align=center><input type="input" name="SurnameTB" id="SurnameTB" value="" required></p>
        <p align="center" style="font-size:20px;font-family:Arial;color:orange;">Введите имя:</p>
        <p align=center><input type="input" name="NameTB" id="NameTB" value="" required></p>
        <p align="center" style="font-size:20px;font-family:Arial;color:orange;">Введите отчество:</p>
        <p align=center><input type="input" name = "PatrTB" id="PatrTB" value="" required></p>
        <p align="center" style="font-size:20px;font-family:Arial;color:orange;">Введите номер телефона:</p>
        <p align=center><input type="input" name = "TelephoneTB" id="TelephoneTB" value="" required></p>
        <p align=center><input type="button" name="ClickB" id="button" value="Купить" onClick="SubClick();"></p>
        <input type="hidden" name="Hid" id="Hid">
        </form><br><br><br>
        </div>
	</main><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
<?
    if (isset($_POST['Hid'])) {
        try {
            $stmt = $dsh->prepare("INSERT INTO `orders` (`IDCar`,`Surname`,`Name`,`Patronymic`,`TelephoneNum`) VALUES(:ID,:Sur,:N,:Patr,:Tel)");
            $stmt->bindValue(':ID',$_GET['Auto']);
            $stmt->bindValue(':Sur',$_POST['SurnameTB']);
            $stmt->bindValue(':N',$_POST['NameTB']);
            $stmt->bindValue(':Patr',$_POST['PatrTB']);
            $stmt->bindValue(':Tel',$_POST['TelephoneTB']);
            $stmt->execute();
            $stmt2 = $dsh->query('Select MAX(IDOrder) From orders');
            $stmt2 ->execute();
            $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            echo "<p align=center style=color:orange;> Ваш номер заказа: ".$result[0]['MAX(IDOrder)']."</p>";
            $stmt3 = $dsh->prepare("UPDATE `cars` SET `Count` = Count - 1 WHERE IDCar = :ID");
            $stmt3 ->execute([':ID' => $_GET['Auto']]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
?>