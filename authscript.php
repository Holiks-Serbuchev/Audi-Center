<?php
function Auth($Login,$Pass){
    require('connection.php');
    $stmt = $dsh->prepare("Select * From users Where Status = 'Доступен' And Login = :Login");
    $stmt->execute(['Login' => $Login]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(($result[0]['Password'] == $Pass))
        return true;
}
function GetFullInformation($Login,$Check){
    if ($Check == true) {
        require('connection.php');
        $stmt = $dsh->prepare("Select * From users Where Status = 'Доступен' And Login = :Login");
        $stmt->execute(['Login' => $Login]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>