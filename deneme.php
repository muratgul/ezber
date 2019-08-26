<!DOCTYPE html>
<html>
<body>
<?php
function sifreleme($string)
{
	$uzunluk = mb_strlen($string);
	
	$rastgele = rand(1,$uzunluk);
	
	if($rastgele==0){
		$harf = mb_substr($string,1);
	}
		$harf = mb_substr($string,$rastgele-1,1);

	$s = null;
	
	for($i=0; $i<=$uzunluk-1; $i++){
		
		if($i != $rastgele-1){
			$s .= "*";
		}else{
			$s .= $harf;
		}
		
	}
	
	return 'Uz: '.$uzunluk.' Say: '.($rastgele).' Harf: '.$harf.' Sifreli: '.$s;	
}

$kelime = 'elma';

echo sifreleme($kelime);

?>
</script>

</body>
</html>