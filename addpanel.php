<!DOCTYPE html>
<html>
<head>
	<title>Добавление авто</title>
	<link rel="shortcut icon" href="\Images\file.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="index.css">
	<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
</head>
<body>
	<script>
		if (window.history.replaceState ) {
  			window.history.replaceState( null, null, window.location.href );
		}
		function ChangeImage(input) {
			if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
					document.getElementById("Image").src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function SubClick() {
            if (document.getElementById("ModelTB").value == "" || document.getElementById("ImageTB").value == "" || document.getElementById("YearTB").value == ""|| document.getElementById("CountTB").value == "" || document.getElementById("TypeTB").value == "" || document.getElementById("DashTB").value == ""|| document.getElementById("ColorTB").value == "" || document.getElementById("EngineTB").value == "" || document.getElementById("BoxTB").value == ""|| document.getElementById("CostTB").value == "")
                alert("Пожалуйста заполните все поля для ввода");
            else
                document.getElementById("Holiks").submit();
        }
	</script>
	<?php
		require_once('connection.php');
		include('authscript.php');
		$Login = $_GET['Login'];
        $Pass = $_GET['Pass'];
        $IDUser = 0;
        $Check = Auth($_GET['Login'],$_GET['Pass']);
        if ($Check == true) {
            $stmt = $dsh->prepare("Select * From users Where `Login` = '".$Login."'");
			$stmt ->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $IDUser = $result[0]['ID'];
        }
		function LoadOption($table,$tablename,$dsh,$Name,$IDOption,$NameOption){
			echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>".$Name.":<select id=".$IDOption." name=".$NameOption.">";
			$stmt = $dsh->prepare("Select * From ".$table);
			$stmt ->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $key => $value)
				echo "<option>".$result[$key][$tablename]."</option>";
			echo "</select></p>";
        }
        if (isset($_POST['Hid'])) {
            $file = file_get_contents($_FILES['ImageTB']['tmp_name']);
            $stmt = $dsh->prepare("INSERT INTO `cars` (`ModelCar`, `YearOfIssue`, `Typeauto`, `Dash`, `Color`, `Engine`, `Transmission`, `IDUser`, `Cost`, `Count`, `Status`,`Image`) VALUES (:Model, :YearI, :TypeA, :DashT, :Color, :Engine, :Transmission, :ID, :Cost, :CountS, 'Доступен',:ImageS);");
			$stmt->execute(['Model' => $_POST['ModelTB'],'YearI' => $_POST['YearTB'],'ImageS' => $file,'TypeA' => $_POST['TypeTB'],'DashT' => $_POST['DashTB'],'Color' => $_POST['ColorTB'],'Engine' => $_POST['EngineTB'],'Transmission' => $_POST['BoxTB'],'Cost' => $_POST['CostTB'],'ID'=> $IDUser,':CountS' => $_POST['CountTB']]);
			echo "<script type='text/javascript'>alert('Данные успешно добавлены');</script>";
        }
    ?>
	<header>
	<div align=left><img src="\Images\file.png" width="200"><b><p align=center style="color:orange;font-size:500%;font-family:Arial;bottom: 245px;position: relative;">Добавление автомобиля</p></b></div>
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
		<p align="center" style="font-size:25px;font-family:Arial;color:#6ca6e1;margin:0;padding:0;">Добавление авто:</p>
		<div style="background-color: #222c2a;">
        	<?
				if ($Check == true) {
					echo "<form method=POST id=Holiks enctype=multipart/form-data>";
					echo "<div style=background-color:#222c2a;><p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Модель:<input id=ModelTB name=ModelTB type=text></p>";
					echo "<p align=center><img id=Image alt='' width=350/></p>";
					echo "<p align=center><input type=file onchange=ChangeImage(this); id=ImageTB name=ImageTB accept='image/png, image/jpeg' /></p>";
					LoadOption("years","Year",$dsh,"Год выпуска","YearTB","YearTB");
					LoadOption("typeauto","TypeName",$dsh,"Тип авто","TypeTB","TypeTB");
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Пробег:<input id=DashTB name=DashTB type=text></p>";
					LoadOption("colors","ColorName",$dsh,"Цвет","ColorTB","ColorTB");
					echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Двигатель:<input id=EngineTB name=EngineTB type=text></p>";
					LoadOption("transmission","TransmissionName",$dsh,"Коробка","BoxTB","BoxTB");
                    echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Цена:<input id=CostTB name=CostTB type=text></p>";
                    echo "<p align=center style=color:#1990b3;font-family:Arial;font-size:120%;>Количество:<input id=CountTB name=CountTB type=text></p>";
					echo "<p align=center><input type=button name=ClickB id=button value=Купить onClick=SubClick();></p><input type=hidden name=Hid id=Hid></form>";
				}
            	echo "<hr style=width:auto; size=6 color=#151716 /></div>";
        ?>
        </div>
	</main><br><br><br><br><br><br><br><br><br><br><br><br>
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
