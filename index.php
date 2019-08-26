<?php session_start(); error_reporting(0) ?>

<?php

	date_default_timezone_set('Europe/Istanbul');
	function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

if(!$_SESSION['giris']){

$ipno2 = getUserIpAddr().' - '.date("d.m.Y H:i:s")."\n";
$log2 = fopen('giris.txt', 'a');
fwrite($log2, $ipno2);
fclose($log2);
$_SESSION['giris'] = true;
}

	?>

<!DOCTYPE html>
<html>
<head>
	<title>EZBER 2.0</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>
<style type="text/css">
body{
	background:url(regal.png);
}
.cardfalse{
	background-color: #cd0000 !important;
    color: white !important;
}
.cardtrue{
	background-color: #238c00 !important;
    color: white !important;
}
.trueorfalset, .trueorfalsef{
	float: right;
    top: 7px;
    position: absolute;
    right: 8px;
    display: none;
}
</style>
<img src="ok2.png" style="width:1px; height:1px; top:-5000px;" alt="" />
<img src="false2.png" style="width:1px; height:1px; top:-5000px;" alt="" />
	<div class="container" style="xbackground:#fff; xpadding:10px; xopacity:0.5;">

	<?php if($_GET['do']=='Yeni'){
		unset($_SESSION['eng']);
		unset($_SESSION['tur']);
		$_SESSION['dogru'] = 0;
		$_SESSION['yanlis'] = 0;
	}
		?>

	<script type="text/javascript">
	
	
			$(document).ready(function(){
			process();

$('#dkelime').focus();
		   $('#dkelime').bind("enterKey",function(e){
		   	var var1 = $("#sayi").val();
		   	var var2 = $("#tursayi").val();
		     kontrol(var1,var2);
		   });

		   $('#dkelime').keyup(function(e){
		     if(e.keyCode == 13)
		     {
		        $(this).trigger("enterKey");
		     }
		   });
});
	

		function Secenek(val){
			
			
			$.ajax(
		        {
				type: "POST",
				url: 'hafiza.php',
				data: {secenek:1,cevap:val},
				success: function (response)
						{
							
							if(response == 'dogru'){
								playAudiox();
								$('.sonuc').html('<img src="ok2.png" alt="" />');
								$('.trueorfalset').css('display','block');
								$('.cardx').addClass('cardtrue');
								setTimeout(process, 1000);
								$('.sonuc').delay(1000).html(' ');
								$('#dkelime').focus();
							}else{
						  playAudio();
								$('.sonuc').html('<img src="false2.png" alt="" />');
								$('.trueorfalsef').css('display','block');
								$('.cardx').addClass('cardfalse');
								setTimeout(process, 1000);
								$('.sonuc').delay(1000).html(' ');
								$('#dkelime').focus();
								
							}
							
						},
		        }
       		);
		}



		$('#dkelime').keypress(function(event){
	
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				alert('You pressed a "enter" key in textbox');	
			}
			event.stopPropagation();
		});

var x = document.getElementById("myAudio"); 




		
		
		function process()
		{
			
			$('#yeni_kelime_sor').addClass('btn-danger');
			$('#yeni_kelime_sor').text('Bekleyin');
			$("#yeni_kelime_sor").attr("disabled", true);
			
			$.ajax(
		        {
		            type: "POST",
		            url: 'process.php',
		            data: {},
		            success: function (response)
		                    {
								
		                      $(".sorudiv").html(response);

							  sonuclar();
							  
								$('#dkelime').focus();
								$('#yeni_kelime_sor').text('Yeni Kelime Sor');
								$("#yeni_kelime_sor").attr("disabled", false);
								$('#yeni_kelime_sor').removeClass('btn-danger');
								$('#yeni_kelime_sor').addClass('btn-info');
		                    },
		        }
       		);
		
		}
		
		function sonuclar()
		{
			 $.ajax({
                type: 'post',
                dataType: 'json',
				data: {},
                url: 'sonuclar.php',

                success: function (data) {
                
				$('.dogrusayisi').html(data.dogru);
				$('.yanlissayisi').html(data.yanlis);
				$('.progress').html('<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: '+data.yuzde+'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">'+data.yuzde+'%</div>');

                }
                
            });
		
	
			
			
		}
	
		function dysonuclar()
		{
			
			/*
			
			$.ajax(
		        {
		            type: "POST",
		            url: 'sonuclar.php',
		            data: {},
		            success: function (response)
		                    {
		                      $(".dysonuclar").html(response);
		
		                    },
		        }
       		);
			*/
		}
		
	

		function kontrol(indis,tur){
	
			var dkelime = $('#dkelime').val();

			$.ajax(
		        {
		            type: "POST",
		            url: 'hafiza.php',
		            data: {kelime:indis,turs:tur,dkelime:dkelime},
		            success: function (response)
		                    {
													
						
								
		                      if(response == 'dogru'){
								playAudiox();
								$('.sonuc').html('<img src="ok2.png" alt="" />');
								$('.trueorfalset').css('display','block');
								$('.cardx').addClass('cardtrue');
								setTimeout(process, 1000);
								$('.sonuc').delay(1000).html(' ');
								$('#dkelime').focus();
							}else{	  
							playAudio();
								$('.sonuc').html('<img src="false2.png" alt="" />');
								$('.trueorfalsef').css('display','block');
								$('.cardx').addClass('cardfalse');
								setTimeout(process, 1000);
								$('.sonuc').delay(1000).html(' ');
								$('#dkelime').focus();
							}
						
							
		                        
		                    },
		        }
       		);
		}
	</script>
	
	<?php
	//print_r($_SESSION['eng']);
	//print_r($_SESSION['tur']);
	?>

<audio id="myAudiox">
  <source src="correct.mp3" type="audio/mpeg">
  
</audio>
	
<audio id="myAudio">
  <source src="im_recv.mp3" type="audio/mpeg">

</audio>


<script>
var x = document.getElementById("myAudio"); 
var y = document.getElementById("myAudiox"); 

function playAudio() { 
  x.play(); 
} 

function playAudiox() { 
  y.play(); 
} 

</script>
<?php if(!$_POST['ekleme']){ ?>
<?php if(!$_SESSION['tur']) { ?>
<br>
<!--
<form action="index.php" method="GET">
<div class="row">
<div class="col-6"><input placeholder="Kelime Sayısı" type="text" name="count" value="<?php //echo $_GET['count'] ?>" class="form-control"></div>
<div class="col-6"><button type="submit" class="btn btn-danger"> Oluştur </button></div>
</div>
</form>
-->
<br>

<form action="./" method="post">

	<h6>Ezberlenecek kelimeleri aşağıya yazınız</h6>
	<small>Her satırda bir kelime yazılacaktır.</small>
	<br>
	<br>

<div class="row">


<?php //if(!$_GET['count']){ $ksayisi = 10; }else{ $ksayisi = $_GET['count']; } ?>
<!--
<?php //for($i=1; $i<=$ksayisi; $i++){ ?>
	<div class="col-6"><input placeholder="<?php //echo $i ?>.Eng" type="text" name="eng[]" class="form-control"></div>
	<div class="col-6"><input placeholder="<?php //echo $i ?>.Tur" type="text" name="tur[]" class="form-control"></div><br><br>
<?php //} ?>
-->

<div class="col-6">İngilizce Kelimeler: <textarea class="form-control" name="english" id="" cols="30" rows="10" placeholder="Apple<?php echo "\n" ?>Banana<?php echo "\n" ?>Day<?php echo "\n" ?>Moon"></textarea></div>
<div class="col-6">Türkçe Kelimeler: <textarea class="form-control" name="turkce" id="" cols="30" rows="10" placeholder="Elma<?php echo "\n" ?>Muz<?php echo "\n" ?>Gün<?php echo "\n" ?>Ay"></textarea></div>



</div>

<br>
	<input type="hidden"  name="ekleme" value="ekleme"/>
	<button type="submit" class="btn btn-danger" onclick="process()"> Ekle </button>
</form>
<br>
<?php } } ?>


<?php


if($_POST['ekleme']=='ekleme'){ //ekleme yapılmışsa

	$eng_kelimeler=array();
	$tur_kelimeler=array();
	
	$list_tur = explode("\n",$_POST['turkce']);
	$list_eng = explode("\n",$_POST['english']);
	
	if(!$_SESSION['eng']){
		$metin = "=================="."\n";
		$metin .= $_POST['turkce']."\n";
		$metin .= "-----------------"."\n";
		$metin .= $_POST['english']."\n";
		$metin .= "=================="."\n";
		$log22 = fopen('kelimeler.txt', 'a');
		fwrite($log22, $metin);
		fclose($log22);
	}

	foreach ($list_eng as $eng => $keyeng) {
		if(strlen($keyeng)>0){
		$eng_kelimeler[$eng] = $keyeng;
		} 
	}

	foreach ($list_tur as $tur => $keytur) {
		if(strlen($keytur)>0){
		$tur_kelimeler[$tur] = $keytur; 
		}
	}


$_SESSION['eng'] = array_filter($eng_kelimeler);
$_SESSION['tur'] = array_filter($tur_kelimeler);

/*
$sss = str_replace("\n",",",$_POST['turkce']);

//$eklenecek = date("d.m.Y H:i:s").' - '.$_POST['turkce'].' - '.$_POST['english']."\n";

$log_kelime = fopen('kelimeler.txt', 'a');
fwrite($log_kelime, $sss);
fclose($log_kelime);
*/


$_SESSION['dizi_sayisi'] = count(array_filter($eng_kelimeler));

if(count(array_filter($eng_kelimeler))==0){
	echo '<h4>Lütfen her iki tarafıda doldurunuz!</h4><br><br>';
	echo '<a href="./" class="btn btn-info">Anladım</a>';
	$_SESSION['eng']=null;
	$_SESSION['tur']=null;
	
	exit;
}elseif(count(array_filter($tur_kelimeler))==0){
	echo '<h4>Lütfen her iki tarafıda doldurunuz!</h4><br><br>';
	echo '<a href="./" class="btn btn-info">Anladım</a>';
	$_SESSION['eng']=null;
	$_SESSION['tur']=null;
	exit;
}

} //ekleme yapılmışsa
?>


<?php if($_SESSION['eng']){  ?>

<div class="sorudiv"></div>

<p class="sonuc"></p>
<a class="btn btn-info" href="javascript:" onclick="process()" id="yeni_kelime_sor">Yeni Kelime Sor</a>

<br>
<br>
<div class="xdysonuclar"></div>

<div class="row">
<div class="col-sm-12 col-md-3">
<ul class="list-group">
  <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
    Doğru Sayısı
    <span class="badge badge-success badge-pill dogrusayisi">0</span>
  </li>
  <li class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
    Yanlış Sayısı
    <span class="badge badge-danger badge-pill yanlissayisi">0</span>
  </li>
</ul>
</div>
</div>
<br>
<div class="card">
  <div class="card-body">
<h6 class="cart-title">Başarı Yüzdesi : </h6>
<div class="progress">
  
</div>
</div>
</div>

<?php // } ?>
<br>
<br>
<a class="btn btn-warning" href="index.php?do=Yeni">Bu kelimeleri öğrendim diğerleri gelsin.</a>

<?php } ?>

</div>
</body>
</html>