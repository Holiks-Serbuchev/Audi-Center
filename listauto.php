<!DOCTYPE html>
<html>
<head>
	<title>Покупка авто</title>
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
		function ChangeImage(input,num) {
			if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
					document.getElementById("Image" + num).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
	</script>
	<?php
		$CountEnter = 0;
		require_once('connection.php');
		include('authscript.php');
		if (isset($_POST['Delete'])) {
			$stmt = $dsh->prepare("UPDATE `cars` SET `Status` = 'Удален' WHERE `cars`.`IDCar` = :ID");
			$stmt->execute([':ID' => $_POST['Hid']]);
			echo "<script>alert('Данные успешно удалены');</script>";
		}
		if (isset($_POST['BoughtB'])) {
			$CustomArray = GetFullInformation($_GET['Login'],true);
			$stmt = $dsh->prepare("INSERT INTO `orders` (`IDCar`,`IDUser`,`Status`) VALUES(:ID,:IDUser,'Доступен')");
            $stmt->bindValue(':ID',$_POST['Hid']);
            $stmt->bindValue(':IDUser',$CustomArray[0]['ID']);
			$stmt->execute();
            $stmt3 = $dsh->prepare("UPDATE cars SET `Count` = Count - 1 WHERE IDCar = :Hid");
            $stmt3 ->execute([':Hid' => $_POST['Hid']]);
			echo "<script>alert('Заказ успешно добавлен');</script>";
		}
		if (isset($_POST['Update'])) {
			try {
				$Sql;
				$file = null;
				if ($_FILES['ImageTB']['name'] == "") {
					$Sql = "UPDATE `cars` SET `ModelCar` = :Model,`YearOfIssue` = :YearI,`TypeAuto` = :TypeA,`Dash` = :DashT,`Color` = :Color,`Engine` = :Engine,`Transmission` = :Transmission,`Cost` = :Cost WHERE `cars`.`IDCar` = :ID";
				}
				else
					$Sql = "UPDATE `cars` SET `ModelCar` = :Model,`YearOfIssue` = :YearI,`TypeAuto` = :TypeA,`Dash` = :DashT,`Color` = :Color,`Engine` = :Engine,`Transmission` = :Transmission,`Cost` = :Cost,`Image` = :ImageS WHERE `cars`.`IDCar` = :ID";
				$stmt = $dsh->prepare($Sql);
				if ($_FILES['ImageTB']['name'] == "")
					$stmt->execute([':ID' => $_POST['Hid'],':Model' => $_POST['ModelTB'],'YearI' => $_POST['YearTB'],'TypeA' => $_POST['TypeTB'],'DashT' => $_POST['DashTB'],'Color' => $_POST['ColorTB'],'Engine' => $_POST['EngineTB'],'Transmission' => $_POST['BoxTB'],'Cost' => $_POST['CostTB']]);
				else{
					$file = file_get_contents($_FILES['ImageTB']['tmp_name']);
					$stmt->execute([':ID' => $_POST['Hid'],':Model' => $_POST['ModelTB'],'YearI' => $_POST['YearTB'],'TypeA' => $_POST['TypeTB'],'DashT' => $_POST['DashTB'],'Color' => $_POST['ColorTB'],'Engine' => $_POST['EngineTB'],'Transmission' => $_POST['BoxTB'],'Cost' => $_POST['CostTB'],'ImageS' => $file]);
				}
				echo "<script>alert('Данные успешно изменены');</script>";
			} catch (\Throwable $th) {
				
			}
		}
		$Login = $_GET['Login'];
		$Pass = $_GET['Pass'];
		$Check = Auth($_GET['Login'],$_GET['Pass']);
		$CustomArray = GetFullInformation($_GET['Login'],$Check);
		function LoadOption($table,$tablename,$dsh,$Name,$NameOption,$SelectValue){
			echo "<p align=center >".$Name.":<select name=".$NameOption.">";
			$stmt = $dsh->prepare("Select * From ".$table);
			$stmt ->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $key => $value){
				if ($result[$key][$tablename] == $SelectValue)
					echo "<option selected>".$result[$key][$tablename]."</option>";
				else
					echo "<option>".$result[$key][$tablename]."</option>";
			}
			echo "</select></p>";
		}
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
		<p align="center" style="font-size:25px;font-family:Arial;color:#6ca6e1;padding:0;margin:0;">Покупка авто:</p>
		<div style="background-color: #222c2a;">
        	<?
        	$stmt = $dsh->prepare("Select * From cars Where Status = 'Доступен' And Count <> '0' ORDER BY YearOfIssue DESC");
        	$stmt ->execute();
        	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        	foreach ($result as $key => $value) {
				if ($Check == true && $Login != "" && $Pass != "" && $CustomArray[0]['Staff'] == "Администратор") {
					echo "<form method=POST enctype=multipart/form-data>";
					echo "<div style=background-color:#222c2a;><p align=center >Модель:<input name=ModelTB type=text value='".$result[$key]['ModelCar']."'></p>";
					echo "<p align=center><img id=Image$key src='data:image/*;base64,", base64_encode($result[$key]['Image']), "' alt='' width=350/></p>";
					echo "<p align=center><input type=file onchange=ChangeImage(this,$key); id=ImageTB name=ImageTB accept='image/png, image/jpeg' /></p>";
					LoadOption("years","Year",$dsh,"Год выпуска","YearTB",$result[$key]['YearOfIssue']);
					LoadOption("typeauto","TypeName",$dsh,"Тип авто","TypeTB",$result[$key]['Typeauto']);
					echo "<p align=center >Пробег:<input name=DashTB type=text value=".$result[$key]['Dash']."></p>";
					LoadOption("colors","ColorName",$dsh,"Цвет","ColorTB",$result[$key]['Color']);
					echo "<p align=center >Двигатель:<input name=EngineTB type=text value='".$result[$key]['Engine']."'></p>";
					LoadOption("transmission","TransmissionName",$dsh,"Коробка","BoxTB",$result[$key]['Transmission']);
					echo "<p align=center >Цена:<input name=CostTB type=text value=".$result[$key]['Cost']."></p>";
				}
				else{
					echo "<div style=background-color:#222c2a;><form method=POST><p align=center style=color:orange;font-family:Arial;font-size:120%;>".$result[$key]['ModelCar']."</p>";
					echo "<p align=center><img src='data:image/*;base64,", base64_encode($result[$key]['Image']), "' alt='' width=350/></p>";
					echo "<p align=center >Год выпуска: ".$result[$key]['YearOfIssue']."</p>";
					echo "<p align=center >Тип авто: ".$result[$key]['Typeauto']."</p>";
					echo "<p align=center >Пробег: ".$result[$key]['Dash']."</p>";
					echo "<p align=center >Цвет: ".$result[$key]['Color']."</p>";
					echo "<p align=center>Двигатель: ".$result[$key]['Engine']."</p>";
					echo "<p align=center>Коробка: ".$result[$key]['Transmission']."</p>";
					echo "<p align=center>Цена: ".$result[$key]['Cost']."</p>";	
				}
				if ($Check == true && $Login != "" && $Pass != ""){
					echo "<input type=hidden value='".$result[$key]['IDCar']."' name=Hid>";
					if ($CustomArray[0]['Staff'] == "Администратор"){
						?><p align=center><input type=submit value=Изменить name="Update"><input type=submit value=Удалить name=Delete></p></form><?}
					else if ($CustomArray[0]['Staff'] != "Администратор"){
						?><button type="submit" name="BoughtB" id=<?php echo $result[$key]['IDCar']?> style="top:30px;">Купить в один клик</button></form><?}	
				}
				else
					echo "<p align=center >Покупать на сайте может только зарегистрированный пользователь</p>";
				?>
				</form><?
				echo "<hr style=width:auto; size=6 color=#565656 /></div>";
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
