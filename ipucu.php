
<?php session_start();

function sifreleme($string)
{
	$uzunluk = mb_strlen($string);
	
	$rastgele = rand(1,$uzunluk-1);
	
	$harf = mb_substr($string,$rastgele-1,1);

	$s = null;
	
	for($i=0; $i<=$uzunluk-1; $i++){
		
		if($i != $rastgele-1){
			$s .= "*";
		}else{
			$s .= $harf;
		}
		
	}
	
	return $s;	
}





if($_POST['tur']=='tr'){
	
	$kelime = trim($_SESSION['eng'][$_POST['indis']]);
	
	echo sifreleme($kelime);
	
}elseif($_POST['tur']=='en'){
	
	$kelime = trim($_SESSION['tur'][$_POST['indis']]);
	echo sifreleme($kelime);
}



?>