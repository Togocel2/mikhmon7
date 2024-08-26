<?php
$pesan="Kode Aktifasi akan dikirim ke nomor yang Anda input.";
require_once 'system.database.php';
$okk="0";
$apk="x";
if (isset($_GET['apk']))  {
	$apk=$_GET['apk'];
}else{
	$apk="X";
}
if (isset($_GET['nomor']))  {
	$nomor=$_GET['nomor'];
}else{
	$nomor="";
	$apk="*";
}
if (isset($_GET['key']))  {
	$key=$_GET['key'];
}else{
	$key="";
//	$apk="*";
}
if (isset($_GET['mrouter']))  {
	$mrouter=$_GET['mrouter'];
}else{
	$mrouter="";
}

$mfile="idwa.txt";
if (file_exists($mfile)) {
	$misi	= explode("|",file_get_contents($mfile));
	$nowa	=$misi[0];
	$apiwa	=$misi[1];
	$nama	=$misi[2];
	$ckey	=$misi[3];
	if (strlen($nowa)<10)  {
		$pesan = " Silahkan isi ID WA dimenu Admin Setting pada Aplikasi Mikhmon.";
		$okk="0";
	}else{
		if (strlen($apiwa)<5)  {
			$pesan = " Silahkan isi API KEY WA dimenu Admin Setting pada Aplikasi Mikhmon.";
			$okk="0";
		}else{
			$okk="1";
			$pesan  .="<br>".$apiwa;
		}
	}
}else{
	$pesan = " Silahkan isi ID WA dan API Key dimenu Admin Setting pada Aplikasi Mikhmon.";
	$okk="0";
}
if (isset($_POST['save']))  {
	if (empty($_POST['mrouter'])) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nSilahkan pilih router yang akan digunakan.\n\nTerimakasih."); } 
		</script>';
	}elseif (strlen($_POST['mnomor'])<10) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nID WA Harapuntuk diisi.\n\nTerimakasih."); } 
		</script>';
	}elseif (strlen($_POST['nama'])<5) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nMinimal 5 Huruf .\n\nTerimakasih."); } 
		</script>';
	}else{	
		$mnomor=nomor($_POST['mnomor']);
		$mkey=kuser(15);
		if ($mnomor==$nowa)  {
			$simpan=apkdaftar($mnomor,$_POST['nama'],"",$_POST['saldo'],$mkey);
		}else{
			$simpan=apkdaftar($mnomor,$_POST['nama'],$_POST['mrouter'],$_POST['saldo'],$mkey);
		}
		$scheme = $_SERVER['REQUEST_SCHEME'];
		if (strpos(strtolower($scheme), 'http') !== false){
			$cekhttps=$scheme."://";
			$okkk=explode(".",$_SERVER['HTTP_HOST']);
			if ($okkk[1]=="ngrok") {
				$cekhttps="https://";
			}
		}else{
			$cekhttps="https://";
		}
		$urlpath=$_SERVER['REQUEST_URI'];
		$ltopup1=explode("?",$cekhttps.$_SERVER['HTTP_HOST'].$urlpath);
		$ltopup =$ltopup1[0];
		$pesan="Silahkan klik link dibawah ini, untuk Bertransaksi.\n\n".$ltopup."?nomor=".$mnomor."&key=".$mkey."\n\nTerimakasih dan Selamat ".sapaan()."\n";
		$kirim=apkkirimwa1($mnomor,$pesan);
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nData sudah disimpan dan LINK Aktifasi Reseller telah dikirim.\n\nTerimakasih."); } 
		</script>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body { font-family: Arial, Helvetica, sans-serif;font-size:16px;font-family:timesnewroman;color:white;}
.mobile-container {  max-width: 480px; height: 540px; margin: auto;  background-color: #555; color: white;  border-radius: 10px; transition: all 3s;}
.topnav { overflow: hidden;  background-color: #333;  position: relative;}
.topnav #myLinks {  display: none;}
.topnav a {  float: left;  color: white;  padding: 10px 12px;  text-decoration: none;  font-size: 16px;}
.topnav a.icon {  float: right;}
.topnav a:hover {  background-color: #ddd;  color: black;}
.active {  background-color: #04AA6D; color: white;}
td {padding:2px 2px;font-size:16px;}
select {padding:2px 2px;font-size:18px;color:white;background-color:green;border-radius:10px;}
.search-box{ width: 90%; position: relative; display: inline-block; font-size: 14px; padding-left:10px;}
.search-box input[type="text"]{ height: 32px; padding: 5px 10px; border: 1px solid #CCCCCC; font-size: 14px; }
.result{ position: absolute; z-index: 999; top: 100%; left: 5px; }
.search-box input[type="text"], .result{ width: 100%; box-sizing: border-box; padding-left:10px;font-size:16px;font-weight:bold;border-radius:5px;}
    /* Formatting result items */
.result p{ color:white; margin: 0; padding: 7px 10px; border: 1px solid #CCCCCC; border-top: none; cursor: pointer; }
.result p:hover{ color:white; background: #f2f2f2; }

a:link {color: white; text-decoration: none; }
a:visited { color: white; text-decoration: none;}
a:hover { color: white; text-decoration: none;}
a:active { color: white; text-decoration: none;}

</style>
</head>
<body>
<div class="mobile-container">
<img src="img/logo.png" height="100px" width="100%">
<div style="padding-left:10px;padding-right:10px">
<form action="" method="post">
<?php
if ($ckey<>$key)  {
	$okk="0";
	$pesan="Silahkan HUB ".$nowa." untuk informasi lebih lanjut.";
}
if ($okk=="0")  {
	echo "<center>
		<p><i style='font-size:18px;margin-left:20px'>".$pesan."</i><hr>
		<p><img src='img/book.png' height='150px'><hr>
	</center>";
}else{
//owner
	if ($nomor==$nowa)  {
//registrasi
		$router=explode("!",crouter());
		if ($apk=="1") {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=1&nomor=".$nomor."&key=".$key."'>Reseller</a>
				<a href='?apk=11&nomor=".$nomor."&key=".$key."'>Lihat</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>

			<h4>PENDAFTARAN RESELLER</h4>

			<table>
			<tr><td>No WA</td><td>:</td><td>
			<input type='number' name='mnomor' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:150px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			<tr><td>Nama</td><td>:</td><td>
			<input type='text' name='nama' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:200px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			<tr><td>Router</td><td>:</td><td>
			<select name='mrouter' style='padding:5px;width:175px;'>
			<option value=''>Piih Router</option>";
			for ($i=0 ; $i<count($router)-1 ; $i++)  {
				$xrouter=explode("|",$router[$i]);
				$no=$i+1;
				echo "<option value=$xrouter[0]> ".$no.". ".$xrouter[0]." </option>";
			}
			echo "
			</select>
			</td></tr>
			<tr><td>Saldo</td><td>:</td><td>
			<input type='number' name='saldo' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:100px;heigh:50px;' maxlength='20' placeholder='Bonus' value=''>
			</td></tr>
			<tr><td>Saldo</td><td>:</td><td>
			<input type='submit' name='save' style='padding:5px;font-size:16px;border-radius:5px;font-family:timesnewroman;background-color:#0099cc;color:white;' value=' Simpan '>
			</td></tr>
			</table>
			";
		}elseif ($apk=="11")  {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=1&nomor=".$nomor."&key=".$key."'>Reseller</a>
				<a href='?apk=11&nomor=".$nomor."&key=".$key."'>Lihat</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<h4>DATA RESELLER</h4>
			";
			$data=lreseller();
			echo "<div class='overflow box-bordered mr-t-10' style='max-height: 10vh'>
				<table id='dataTable' class='table table-bordered table-hover text-nowrap'>
				<tr><th>NO</th><th>NAMA</th><th>ID WA</th></tr>";
				for ($i=0 ; $i<count($data) ; $i++)  {
					$isidt=$data[$i];
					$no=$i+1;
					echo "<tr><td>".$no."</td><td>".$isidt['nama_seller']."</td><td>".$isidt['nomer_tlp']."</td></tr>";
					if (!empty($isidt['keterangan'])) {
						echo "<tr><td colspan='2'></td><td><b style='color:white;'>".$isidt['keterangan']."</b></td></tr>";
					}
				}
				echo "</table>
			</div>";
		}elseif ($apk=="2")  {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=2&nomor=".$nomor."&key=".$key."'>Umum</a>
				<a href='?apk=21&nomor=".$nomor."&key=".$key."'>Pelanggan</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<h4>PEMBUATAN VCR UMUM.</h4>
			<form action='' method='post' >
			<table>
			<tr><td>Router</td><td>:</td><td>
			<select name='mrouter' style='padding:5px;width:150px;'  onchange='location = this.value; loader()' title='Piih Profies'>
			<option value=''>Pilih Router</option>";
			for ($i=0 ; $i<count($router)-1 ; $i++)  {
				$xrouter=explode("|",$router[$i]);
				$no=$i+1;
				if ($xrouter[0]==$mrouter) {
					echo "<option value='?apk=2&nomor=".$nomor."&key=".$key."&mrouter=".$xrouter[0]."' selected> ".$no.". ".$xrouter[0]." </option>";
				}else{
					echo "<option value='?apk=2&nomor=".$nomor."&key=".$key."&mrouter=".$xrouter[0]."'> ".$no.". ".$xrouter[0]." </option>";
				}
			}
			echo "
			</select>
			</td></tr>
			<tr><td>Profile</td><td>:</td><td>
			<select name='mpofile' style='padding:5px;width:250px;' >
			<option value=''>Pilih Profile</option>";
			$dvcr	= cvoucher($mrouter);
			$vcr	= explode("*",$dvcr);
			for ($i = 1; $i < count($vcr); $i++) {
				$pvcr	= explode("*",$vcr[$i]);
				$pvcr0	= explode("|",$pvcr[0]);
				$Vcr	= "VCR ".substr("    ".$pvcr0[4],-3);
				$Vrp	= rupiah(trim($pvcr0[3]));
				$sped   =substr("   ".$pvcr0[6],strlen($pvcr0[4])-9);
				$text	="<b>".$Vcr."  ".$sped."  ".$Vrp."</b>\n";
				echo "<option value='".$pvcr0[0]."'>".$text."</option>";
			}
			echo "
			</select>
			</td></tr>
			<tr><td>No WA</td><td>:</td><td>
			<input type='number' name='mnomor' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:150px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			<tr><td></td><td></td><td>
			<input type='submit' name='kirim' style='padding:5px;font-size:16px;border-radius:5px;font-family:timesnewroman;background-color:#0099cc;color:white;' value=' Kirim '>
			</td></tr>
			</table>
			</form>
			";
		}elseif ($apk=="21")  {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=22&nomor=".$nomor."&key=".$key."'>Register</a>
				<a href='?apk=23&nomor=".$nomor."&key=".$key."'>List</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<h4>PEMBUATAN VCR PELANGGAN.</h4>";
		}else{
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=1&nomor=".$nomor."&key=".$key."'>Reseller</a>
				<a href='?apk=2&nomor=".$nomor."&key=".$key."'>Vcr</a>
				<a href='?apk=3&nomor=".$nomor."&key=".$key."'>Report</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<div style='padding-left:10px;padding-right:10px'>
			<p>Selamat ".sapaan()." ".$nama.".<p>Ini adalah Aplikasi Distribusi Voucher.<p>Silahkan ketuk lambang  <i class='fa fa-bars'> </i>
			<hr><center><img src='./img/mickey1.png' style='height:200px;border-radius:10px;'></center>
			</div>";
		}
	}else{
//reseller
		$info=cdata($nomor);
		$nama=$info['nama_seller'];
		if ($apk=="1")  {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Re-Seller</a>
			<div id='myLinks'>
				<a href='?apk=1&nomor=".$nomor."&key=".$key."'>VCR</a>
				<a href='?apk=2&nomor=".$nomor."&key=".$key."'>DAFTAR</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
		
			<div style='padding-left:10px;padding-right:10px'>
			<p>Buat VCR
			</div>";
		}elseif ($apk=="2")  {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Re-Seller</a>
			<div id='myLinks'>
				<a href='?apk=22&nomor=".$nomor."&key=".$key."'>Register</a>
				<a href='?apk=23&nomor=".$nomor."&key=".$key."'>List</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<h4>MENDAFTARKAN PELANGGAN.</h4>";
		}elseif ($apk=="3")  {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Re-Seller</a>
			<div id='myLinks'>
				<a href='?apk=22&nomor=".$nomor."&key=".$key."'>Voucher</a>
				<a href='?apk=23&nomor=".$nomor."&key=".$key."'>Pelnggan</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<h4>LAPORAN.</h4>";
		}else{
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0&nomor=".$nomor."&key=".$key."' class='active'>Re-Seller</a>
			<div id='myLinks'>
				<a href='?apk=1&nomor=".$nomor."&key=".$key."'>VCR</a>
				<a href='?apk=2&nomor=".$nomor."&key=".$key."'>USER</a>
				<a href='?apk=3&nomor=".$nomor."&key=".$key."'>Report</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<div style='padding-left:10px;padding-right:10px'>
			<p>Selamat ".sapaan()." ".$nama.".<p>Ini adalah Aplikasi Distribusi Voucher.<p>Silahkan ketuk lambang  <i class='fa fa-bars'> </i>
			<hr><center><img src='./img/mickey2.png' style='height:200px;border-radius:10px;'></center>
			</div>";
		}
	}
}
?>	
</form>	
</div>
</div>
<script>
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
</body>
</html>
