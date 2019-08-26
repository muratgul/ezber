<?php @session_start(); error_reporting(0);



if($_POST['secenek']==1){
	if($_POST['cevap']=='d'){
		$_SESSION['dogru'] += 1;
		echo 'dogru';
	}else{
		$_SESSION['yanlis'] += 1;
		echo 'yanlis';
	}
}




if($_POST['turs']==2){

$kelime = @$_SESSION['eng'][$_POST['kelime']];

//strcasecmp

	
if(strlen($kelime)>0){

if(strcasecmp(trim($kelime), $_POST['dkelime']) == 0){
		echo 'dogru';
		$_SESSION['dogru'] += 1;
	}else{
		echo 'yanlis';
		$_SESSION['yanlis'] += 1; }

}


}else{
$kelime = @$_SESSION['tur'][$_POST['kelime']];	

//echo 'kelime : '.strlen($kelime).'<br>';
//echo 'dkelime : '.strlen($_POST['dkelime']).'<br>';
	
if(strlen(trim($kelime))>0){

if(strcasecmp(trim($kelime), $_POST['dkelime']) == 0){
		echo 'dogru';
		$_SESSION['dogru'] += 1;
	}else{
		echo 'yanlis';
		$_SESSION['yanlis'] += 1; 
		}

}


}




?>