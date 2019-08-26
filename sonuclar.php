<?php session_start(); error_reporting(0);  $sorusayisi = $_SESSION['dogru']+$_SESSION['yanlis']; $yuzde = ($_SESSION['dogru']/$sorusayisi)*100 ?>


<?php 
$json = [
            'dogru'   => $_SESSION['dogru'],
            'yanlis' => $_SESSION['yanlis'],
            'yuzde' => number_format($yuzde,1)
        ];

 echo json_encode($json);

?>