<html>

<head>
	<title>Skrypt</title>
	
	<style>
* {
    font-family: monospace;
}

    .btn {
		position: fixed;
		top: 5px;
		right: 5px;
        background-color:red;
        cursor:pointer;
    }
	
	
	
	table, th, td {
  text-transform:uppercase;
}

</style>
</head>


<body>
<?php
mb_internal_encoding("UTF-8");
//$output = shell_exec('xxd -g 1 crash.bin');
//$fp = fopen('data.txt', 'w');
//ftruncate($fp, 0);
//fwrite($fp, $output);
//fclose($fp);


?>
<button class="btn" onclick="wybierz(this);" id="ktory">Wybieranie zakresu</button>
<table style="table-layout: fixed;" border=1>
<?php


$licznik = 0;
$file = fopen("data.txt","r");

while(! feof($file))
  {
	  $licznik2 = 0;
	  $linia = fgets($file);
	  
	  $linia_pierwszy = substr($linia, 0, 8); 
	  $linia_ostatni = substr($linia, -17); 
	  
		?>
			<tr>
				<td style="width: 65px;" bgcolor="#C0C0C0"><?php echo htmlentities($linia_pierwszy); ?></td>
			
				<?php
					for($i=1; $i <= 16; $i++)
					{

						$licznik++;
						$linia_out = substr($linia, 9+$licznik2*3, 2);
						$licznik2++;
						?>
						<td style="width: 50px;" class="wart" id="<?php echo $licznik; ?>" 
						
						<?php if ($linia_out!="  ") {?>
						onclick="zmien(this);"
						<?php } ?>
						
						><?php echo $linia_out; ?></td>

					<?php
					}
					?>
			
				<td style="width: 90px;" bgcolor="#C0C0C0"><?php echo htmlentities($linia_ostatni); ?></td>
			</tr>
		<?php  

  }

fclose($file);


?>
</table>
<form><input type="text" id="formularz"></form>
</body>

<script>
	var wartosciZmienione = "";
	var idZmienionych = [];
	var sprawdz = 0;
	var sprawdz2 = 0;
	var pierwszy = document.getElementById('1');
	var ostatni = document.getElementById('2');;
	var przycisk2;
	var pierwszySprawdz;
	
	var target = document.getElementsByClassName('wart');
	
	for(i = 0; i < target.length; i++){
		var observer = new MutationObserver(function(mutations) {
			for(y = 0; y < idZmienionych.length; y++){
				wartosciZmienione = wartosciZmienione + ","
				+ document.getElementById(idZmienionych[y]).innerHTML;
			}
			document.getElementById('formularz').value=wartosciZmienione;
			wartosciZmienione = "";
		});
		observer.observe(target[i], { 
		  attributes: true, 
		  attributeFilter: ['style']});
	}
	function zmien(element){
		if(sprawdz == 1){
			if(sprawdz2 == 0){
				pierwszy = element;
				pierwszySprawdz = pierwszy.style.backgroundColor;
				element.style.backgroundColor = "yellow";
				sprawdz2 = 1;
			}
			else{
				ostatni = element;
				sprawdz2 = 2;
				dzialaj();
			}
		}
		else{
			if(element.style.backgroundColor != ""){
				element.style.backgroundColor = "";
				const index = idZmienionych.indexOf(element.id);
				idZmienionych.splice(index, 1);
			}
			else{
				element.style.backgroundColor = "#800000";
				idZmienionych.push(element.id);
			}
		}
	}
	function wybierz(przycisk){
		if(sprawdz == 1){
			przycisk.style.backgroundColor = "";
			if(pierwszy.style.backgroundColor == "yellow"){
				pierwszy.style.backgroundColor = "";
				sprawdz2 = 0;
			}
			sprawdz = 0;
		}
		else{
			przycisk.style.backgroundColor = "green";
			sprawdz = 1;
			return;
		}
	}
	var globalna = [];
	function dzialaj(){
		liczPierwszy = parseInt(pierwszy.id);
		liczOstatni = parseInt(ostatni.id);
		if(pierwszySprawdz == ""){
			pierwszy.style.backgroundColor = "";
		}
		else{
			pierwszy.style.backgroundColor = "#800000";
		}
		if(liczPierwszy>liczOstatni){
			pomocnicz = pierwszy;
			pomocniczOst = ostatni;
			ostatni = pomocnicz;
			pierwszy = pomocniczOst;
			liczPierwszy = parseInt(pierwszy.id);
			liczOstatni = parseInt(ostatni.id);
		}
		if(sprawdz2 == 2){
			sprawdz2 = 0;
			var lokalna = [];
			for(i=liczPierwszy;i<=liczOstatni;i++){
				var element = document.getElementById(i);
				if(element.style.backgroundColor != ""){
					element.style.backgroundColor = "";
					const index = idZmienionych.indexOf(element.id);
					idZmienionych.splice(index, 1);
				}
				else{
					lokalna.push(String(element.id));
					element.style.backgroundColor = "#800000";
				}
			}
			globalna = lokalna;
			setTimeout(function(){
				var pomocniczaa = idZmienionych;
				idZmienionych = idZmienionych.concat(globalna);
					if(document.getElementById('1').style.backgroundColor != ""){
						document.getElementById('1').style.backgroundColor = "";
						document.getElementById('1').style.backgroundColor = "#800000";
					}
					else{
						document.getElementById('1').style.backgroundColor = "#800000";
						document.getElementById('1').style.backgroundColor = "";
					}
				},1);
			lokalna = [];
			pierwszySprawdz = "";
			pierwszy = document.getElementById('1');
			ostatni = document.getElementById('2');
		}
	}
</script>
</html>