<?php  ?>
<script type="text/javascript">


	$(document).ready(function(){
		
		$("#various5").fancybox({
				'width'				: '400px',
				'height'			: '400px',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			
			$("#various6").fancybox({
				'width'				: '400px',
				'height'			: '400px',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			
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

function ipucu(val1,val2)
{
	$("#ipucubuton").attr("disabled", true);
	
	$.ajax(
		{
			type: "POST",
			url: 'ipucu.php',
			data: {tur:val1,indis:val2},
		
			success: function (response)
					{
					  //$(".ipucu").text('<br><span class="badge badge-success"><h6>'+response+'</h6></span>');
					  $('#dkelime').attr("placeholder",response);
					  $('#dkelime').css('background','#ffdfbf');
					  //$('#dkelime').val(response);
					  $('#dkelime').focus();
					},
		}
	);
	
	
}

</script>
<?php
session_start();
error_reporting(0);
if($_SESSION['dizi_sayisi'] > 3){
$secenek_rast = rand(1,2);
}else{
$secenek_rast = 2;
}


$tursayi = rand(1,2);
$sayi = rand(0,$_SESSION['dizi_sayisi']-1);

if($_SESSION['tur']) {
if($tursayi==1){
?>
<br>
<div class="row">
	<div class="col-sm-12 col-md-6">
		<div class="card cardx">
		  <div class="card-body">
			<h4><?php echo ucfirst($_SESSION['eng'][$sayi]) ?></h4>
			<div class="trueorfalset"><img src="ok2.png" alt="" /></div>
			<div class="trueorfalsef"><img src="false2.png" alt="" /></div>
			
			
		  </div>
		</div>
		
		<br>
		<div class="card">
		<div class="card-body">
		<?php if($secenek_rast==2){ ?>
			<button class="btn btn-sm btn-warning" id="ipucubuton" title="İpucu" onclick="ipucu('en',<?php echo $sayi ?>)"><i class="fa fa-lightbulb-o"></i></button>
		<?php } ?>

			<a class="btn btn-sm btn-danger" id="various5" title="Telaffuz"	href="https://dictionary.cambridge.org/tr/okunuş/ingilizce/<?php echo ucfirst($_SESSION['eng'][$sayi]) ?>" target="_blank"><i class="fa fa-volume-up"></i></a>
			<a class="btn btn-sm btn-danger" id="various6" title="Telaffuz"	href="https://tureng.com/tr/turkce-ingilizce/<?php echo ucfirst($_SESSION['eng'][$sayi]) ?>" target="_blank"><i class="fa fa-volume-up"></i></a>
			<br>
			<div class="ipucu"></div>
			</div>
			</div>
	</div>
</div>


<?php }else{ ?>
<br>
<div class="row">
	<div class="col-sm-12 col-md-6">
<div class="card cardx">
  <div class="card-body">
    <h4><?php echo ucfirst($_SESSION['tur'][$sayi]) ?></h4>
	<div class="trueorfalset"><img src="ok2.png" alt="" /></div>
	<div class="trueorfalsef"><img src="false2.png" alt="" /></div>
  </div>
</div>
<br>
		<?php if($secenek_rast==2){ ?>
		<div class="card">
		<div class="card-body">
			<button class="btn btn-sm btn-warning" title="İpucu" id="ipucubuton" onclick="ipucu('tr',<?php echo $sayi ?>)"><i class="fa fa-lightbulb-o"></i></button>
			<br>
<div class="ipucu"></div>
		
			</div>
			</div>
		<?php } ?>
</div>
</div>
<?php }

//echo $_SESSION['tur'][$sayi];

//include('hafiza.php');
//print_r($_SESSION['tur']).'<br><br>';
//print_r($_SESSION['eng']);
?>
<?php if($_SESSION['tur']) { //eğer ezberlenecek kelime girilmişse ?>
<br>

<?php if($secenek_rast==1){ ?>

<div class="row">
	<div class="col-sm-12 col-md-6">
		<?php
		
			$r_sayi = range(0,$_SESSION['dizi_sayisi']-1); //dizideki sayı
			$dogru_kelime_indis = $sayi; //doğru cevabın indisi
			if($tursayi==1){
			$son_array = $_SESSION['eng'];
			}else{
			$son_array = $_SESSION['tur'];
			}
			unset($son_array[$sayi]); //doğru cevabın indisini sil
			foreach($son_array as $sa => $key){
				$filtreli_rakam[] = $sa; //geriye kalan indisleri diziye aktar 
			}
			shuffle($filtreli_rakam); //geri kalan indisleri karıştır
		
			for($z=1;$z<=2;$z++){
				$srakam[] = $filtreli_rakam[$z]; //ilk iki indisi diziye aktar
			}
			
			$srakam[] = $sayi; //doğru indisi diziye ekle
			
			$_SESSION['dogru_cevap'] = $sayi;
			
			//print_r($_SESSION['eng']);
			
			shuffle($srakam); //diziyi karıştır
			foreach($srakam as $sr){
				
				if($sayi == $sr){
					$dc = 'd';
				}else{
					$dc = 'y';
				}				
		?>
			<button class="btn btn-success" onclick="Secenek('<?php echo $dc ?>')"><?php  if($tursayi==2){ echo ucfirst($_SESSION['eng'][$sr]); }else{ echo ucfirst($_SESSION['tur'][$sr]); }  ?></button>
		<?php  } ?>
		<?php  ?>
	</div>
</div>
<br>
<?php }else{ ?>

<div class="row">
	<div class="col-sm-12 col-md-6">
		<input type="text" class="form-control" name="dkelime" id="dkelime" placeholder="Yanıtı buraya girdikten sonra Enter'a basınız" autocomplete="off"><br>
		<input type="hidden" id="sayi" value="<?php echo $sayi; ?>">
		<input type="hidden" id="tursayi" value="<?php echo $tursayi; ?>">
	</div>
	<!--
	<div class="col-sm-6">
		<button class="btn btn-danger" onclick="kontrol(<?php //echo $sayi; ?>,<?php //echo $tursayi; ?>)">Doğrula</button>
	</div>
	-->
</div>

<?php } ?>

<?php } //eğer ezberlenecek kelime girilmişse 
} ?>