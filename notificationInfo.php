<?php
session_start();

$_SESSION['fullName']=$_POST['fullName'];
$_SESSION['email']=$_POST['email'];
$_SESSION['country']=$_POST['country'];
$_SESSION['address']=$_POST['address'];
$_SESSION['suite']=$_POST['suite'];
$_SESSION['city']=$_POST['city'];
$_SESSION['state']=$_POST['state'];
$_SESSION['zipcode']=$_POST['zipcode'];
$_SESSION['phone']=$_POST['phone'];
$_SESSION['hardBookQty']=$_POST['hardBookQty'];
$_SESSION['paperbackBookQty']=$_POST['paperbackBookQty'];
$_SESSION['booktype']=$_POST['booktype'];

header("Location: ../checkout.html");
?>