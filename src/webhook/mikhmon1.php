<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$pesan="Kode Aktifasi akan dikirim ke nomor yang Anda input.";
require_once 'system.database.php';
require_once '../lib/formatbytesbites.php';
require_once '../lib/routeros_api.class.php';

if(!isset($_COOKIE['nomor'])) {
	$nomor="";
}else{
	$nomor=$_COOKIE['nomor'];
}
if(!isset($_COOKIE['key'])) {
	$key="";
}else{
	$key=$_COOKIE['key'];
}
$okk="0";
$apk="x";
if (isset($_GET['apk']))  {
	$apk=$_GET['apk'];
}else{
	$apk="X";
}

if (isset($_GET['mprofile']))  {
	$mprofile=$_GET['mprofile'];
}else{
	$mprofile="";
}

if (isset($_GET['mrouter']))  {
	$mrouter=$_GET['mrouter'];
}else{
	$mrouter="";
}
if (isset($_GET['mnomor']))  {
	$mnomor=$_GET['mnomor'];
}else{
	$mnomor="";
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
$nama="";	

if (isset($_POST['abatal']))  {
	echo "<script>setTimeout(\"location.href = '?apk=a10';\");</script>";
}
if (isset($_POST['rbatal']))  {
	echo "<script>setTimeout(\"location.href = '?apk=r10';\");</script>";
}

if (isset($_POST['dispalyvcr']))  {
	
}

if (isset($_POST['tdepo']))  {
	$depo=preg_replace('/[Rp. ]/','',$_POST['depo']);
	$simpan=tdeposit($mnomor, creseller($mnomor), intval($depo), $nowa);
	$kirim=kirimwaid($mnomor,$simpan);
	$apk="11";
	echo "<script>setTimeout(\"location.href = '?apk=13&mnomor=$mnomor';\");</script>";
}
if (isset($_POST['kdepo']))  {
	$depo=preg_replace('/[Rp. ]/','',$_POST['depo']);
	$simpan=tdeposit($mnomor, creseller($mnomor), intval($depo)*(-1), $nowa);
	$kirim=kirimwaid($mnomor,$simpan);
	$apk="11";
	echo "<script>setTimeout(\"location.href = '?apk=13&mnomor=$mnomor';\");</script>";
}
if (isset($_POST['kirim']))  {
	$kirim=kirimwaid($_POST['mnomor'],"Kirim Vcr");
	$mnomor="";
}
if (isset($_POST['saver']))  {
	$mnomor=nomor($_POST['mnomor']);
	$nama=ucwords($_POST['nama']);	
	if (strlen($_POST['mnomor'])<10) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nID WA Harap diisi.\n\nTerimakasih."); } 
		</script>';
	}elseif (strlen($_POST['nama'])<5) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nMinimal 5 Huruf .\n\nTerimakasih."); } 
		</script>';
	}else{	
		$mnomor=nomor($_POST['mnomor']);
		$simpan=apkdaftarr($nomor,$mnomor,$nama);
		$kirim=kirimwaid($nomor,$simpan);
		$mnomor="";
		$nama="";
	}
}

if (isset($_POST['phbook']))  {
	$mnomor=nomor($_POST['pnomor']);
	$nama=ucwords($_POST['pnama']);	
	if (strlen($_POST['pnomor'])<10) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nID WA Harap diisi.\n\nTerimakasih."); } 
		</script>';
	}elseif (strlen($_POST['pnama'])<5) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nMinimal 5 Huruf .\n\nTerimakasih."); } 
		</script>';
	}else{	
		$mnomor=nomor($_POST['pnomor']);
		$simpan=apkdaftarr($nomor,$mnomor,ucwords($_POST['pnama']));
		$kirim=kirimwaid($mnomor,$simpan);
		$mnomor="";
		$nama="";
		echo "<script>setTimeout(\"location.href = '?apk=31';\");</script>";
	}
}

if (isset($_POST['rphbook']))  {
	$mnomor=nomor($_POST['pnomor']);
	$nama=ucwords($_POST['pnama']);	
	if (strlen($_POST['pnomor'])<10) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nID WA Harap diisi Min 10 digit.\n\nTerimakasih."); } 
		</script>';
	}elseif (strlen($_POST['pnama'])<5) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nMinimal 5 Huruf .\n\nTerimakasih."); } 
		</script>';
	}else{	
		$mnomor=nomor($_POST['pnomor']);
		$simpan=apkdaftarr($nomor,$mnomor,ucwords($_POST['pnama']));
		$kirim=kirimwaid($mnomor,$simpan);
		$mnomor="";
		$nama="";
		echo "<script>setTimeout(\"location.href = '?apk=r31';\");</script>";
	}
}

if (isset($_POST['asave']))  {
	$mnomor=nomor($_POST['mnomor']);
	$nama=ucwords($_POST['nama']);	
	if (empty($_POST['mrouter'])) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nSilahkan pilih router yang akan digunakan.\n\nTerimakasih."); } 
		</script>';
	}elseif (strlen($_POST['mnomor'])<10) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nID WA Harap untuk diisi. Min 10 digit.\n\nTerimakasih."); } 
		</script>';
	}elseif (strlen($_POST['nama'])<5) {
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nMinimal 5 Huruf .\n\nTerimakasih."); } 
		</script>';
	}else{	
		$mnomor=nomor($_POST['mnomor']);
		$mkey=kuser(15);
		$simpan=apkdaftar($mnomor,ucwords($_POST['nama']),$_POST['mrouter'],$mkey,strtoupper($_POST['awalan']));
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
		$ltopup2=$ltopup1[0];
		$ltopup =str_replace('mikhmon1.php', 'mikhmon.php',$ltopup2);
		$nama=str_replace(' ', '%20',ucwords($_POST['nama']));
		$pesan="Silahkan klik link dibawah ini, untuk melakukan Aktifasi.\n\n".$ltopup."?nomor=".$mnomor."&nama=".$nama."&key=".$mkey."\n\nTerimakasih dan Selamat ".sapaan()."\n";
		$kirim=kirimwaid($mnomor,$pesan);
		$nama="";
		$mnomor="";
		echo '<script type="text/javascript">
		window.onload = function () { alert("INFORMASI,\n\nData sudah disimpan dan LINK Aktifasi telah dikirim.\n\nTerimakasih."); } 
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
.topnav a {  float: left;  color: white;  padding: 10px 12px;  text-decoration: none;  font-size: 16px; font-weight:bold;}
.topnav a.icon {  float: right;}
.topnav a:hover {  background-color: #ddd;  color: black;}
.active {  background-color: #04AA6D; color: white;}

.search-box{ width: 90%; position: relative; display: inline-block; font-size: 14px; padding-left:10px;}
.search-box input[type="text"]{ height: 32px; padding: 5px 10px; border: 1px solid #CCCCCC; font-size: 14px; }
.result{ position: absolute; z-index: 999; top: 100%; left: 5px; }
.search-box input[type="text"], .result{ width: 100%; box-sizing: border-box; padding-left:10px;font-size:16px;font-weight:bold;border-radius:5px;}
    /* Formatting result items */
.result p{ color:white; margin: 0; padding: 7px 10px; border: 1px solid #CCCCCC; border-top: none; cursor: pointer; }
.result p:hover{ color:white; background: #f2f2f2; }

table {background-color:#004d80;padding:5px;border:1px solid white;border-radius:5px ;width:100%;}
caption {margin-top:10px;padding:5px;font-weight:bold;font-size:20px;background-color:white;color:black;border-radius:0px;}
td {padding:2px 2px 1px;font-size:14px;font-weight:bold;font-family:times;}
select {padding:2px 2px;font-size:14px;font-family:times;color:white;background-color:#004d4d;border-radius:5px;}
option {font-size:14px;background-color:blue;}
input[type=submit], input[type=button] {margin-right:20px;margin-bottom:10px;padding:5px 10px;font-size:16px;border:1px solid silver;border-radius:5px;font-family:times;background-color:#0099e6;color:white;font-weight:bold;}

a:link {color: white; text-decoration: none; }
a:visited { color: white; text-decoration: none;}
a:hover { color: white; text-decoration: none;}
a:active { color: white; text-decoration: none;}
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>
</head>
<body>
<div class="mobile-container">
<img src="img/logo.png" height="100px" width="100%">
<div style="padding-left:10px;padding-right:10px">
<form action="" method="post" name="autoSumForm">
<?php
$data=cdata($nomor);
if (isset($data['status'])){
	$mstatus=$data['status'];
}else{
	$mstatus="12";
}
if ($mstatus<>$key)  {
	$okk="0";
	$pesan="Silahkan cek <b>WhatsApp</b> Anda. Dan lakukan Aktifasi Aplikasi.";
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
		$data=creseller($nomor);
		$router=explode("!",crouter());
		if ($apk=="10") {
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=10'>Reseller</a>
				<a href='?apk=11'>Saldo</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<table><caption>PENDAFTARAN RESELLER</caption>
			<tr><td>&nbsp</td><td></td><td>
			<tr><td>No WA</td><td>:</td><td>
			<input type='number' name='mnomor' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:150px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			<tr><td>Nama</td><td>:</td><td>
			<input type='text' name='nama' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:200px;heigh:50px;' maxlength='20' required='1' value=''>
			<tr><td>Router</td><td>:</td><td>
			<select name='mrouter' style='padding:5px;width:175px;'>
			<option value=''>Piih Router</option>";
			for ($i=0 ; $i<count($router)-1 ; $i++)  {
				$xrouter=explode("|",$router[$i]);
				$no=$i+1;
				echo "<option value='".$no.". ".$xrouter[0]."'> ".$no.". ".$xrouter[0]." </option>";
			}
			$no=$no+1;
			echo "
			<option value='".$no.". ALL'>".$no.". ALL</option>
			</select>
			</td></tr>
			<tr><td>Prefix</td><td>:</td><td>
			<input type='text' name='awalan' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:20px;heigh:50px;' maxlength='2' required='1' value=''>
			</td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td></td><td></td><td>
			<input type='submit' name='asave' value=' Simpan '>
			</td></tr>
			</table>
			";
		}elseif ($apk=="11")  {
//pecarian tambah saldo
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=10'>Daftar</a>
				<a href='?apk=11'>Saldo</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<div class='search-box'>
				<P style='font-weight:bold;'>CARI RE-SELLER</P>
				<input type='text' autocomplete='off' name='cbarang' placeholder='Klik disini...' value=''/>
				<div class='result'></div>
			</div>
			";
		}elseif ($apk=="111")  {
//INPUT SALDO RESELER 
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
				<a href='?apk=10'>Daftar</a>
				<a href='?apk=11'>Saldo</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
					<i class='fa fa-bars'></i>
				</a>
			</div>
			";
//			$data=creseller($mnomor);
			echo "
			<table><caption>DATA DETAIL RESELLER</caption>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td>Nama</td><td>:</td><td>".$data['nama_seller']."</td></tr>
			<tr><td>ID WA</td><td>:</td><td>".$data['id_user']."</td></tr>
			<tr><td>Router</td><td>:</td><td>".$data['keterangan']."</td></tr>
			<tr><td>Prefix</td><td>:</td><td>".$data['type']."</td></tr>
			<tr><td>Saldo</td><td>:</td><td>".rupiah($data['saldo'])."</td></tr>
			<tr><td style='text-align:right;'>Rp. +/<b>-</b></td><td>:</td><td>
			<input type='text' name='depo' id='rupiah' onFocus='startCalc();' onBlur='stopCalc();' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:150px;heigh:50px;text-align:right;' maxlength='20' required='1' value=''>
			</td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td colspan='3' align='center'>
			<input type='submit' name='kdepo' value=' Kurang '>
			<input type='submit' name='tdepo' value=' Tambah '>
			</td></tr>
			</table>
			";
		}elseif ($apk=="13")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
				<a href='?apk=10'>Daftar</a>
				<a href='?apk=11'>Saldo</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
					<i class='fa fa-bars'></i>
				</a>
			</div>
			";
//			$data=creseller($mnomor);
			echo "
			<table><caption>DETAIL RESELLER</caption>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td>Nama</td><td>:</td><td>".$data['nama_seller']."</td></tr>
			<tr><td>ID WA</td><td>:</td><td>".$data['id_user']."</td></tr>
			<tr><td>Router</td><td>:</td><td>".$data['keterangan']."</td></tr>
			<tr><td>Prefix</td><td>:</td><td>".$data['type']."</td></tr>
			<tr><td>Sales Vcr</td><td>:</td><td>".$data['voucher_terjual']."  Vcr.</td></tr>
			<tr><td>Sales Rp.</td><td>:</td><td>".rupiah($data['jumlah_debit_terjual'])."</td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td style='font-size:24px;color:cyan;'>Saldo</td><td>:</td><td style='font-size:24px;color:cyan;'><a style='color:cyan;' href='?apk=111&mnomor=".$data['id_user']."'>".rupiah($data['saldo'])."</a></td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td colspan='3'>".ltrim(ucwords(penyebut($data['saldo'])))." Rupiah.</td></tr>
			</table>
			";
		}elseif ($apk=="a10")  {
//buat vcr admin
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
					<a href='?apk=a10'>Voucher</a>
					<a href='?apk=a20'>Laporan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<table><caption>PEMBUATAN VOUCHER</caption>
			<tr><td>Saldo</td><td>:</td><td>".rupiah($data['saldo'])."</td></tr>";
			$drouter=crouter();
			$idrouter=explode("!",$drouter);
			if ($data['keterangan']=="ALL") {
				echo "
				<tr><td>Router</td><td>:</td><td>
				<select name='mrouter' style='padding:5px;width:200px;'  onchange='location = this.value; loader()' >
				<option value=''>Pilih Router</option>";
				for ($i=0 ; $i<count($idrouter)-1 ; $i++)  {
					$n=$i+1;
					$router1=$idrouter[$i];
					$router2=explode("|",$router1);
					$router=$n.". ".$router2[0];
					$sele="";
					if ($router==$mrouter) {$sele="selected";}
					echo "<option value='?apk=a10&mrouter=".$router."' ".$sele.">".$router."</option>";
				}
				echo "</td></tr>
				</select>
				";
			}else{
				echo "<tr><td>Router</td><td>:</td><td>".$data['keterangan']."</td></tr>";
				$mrouter=$data['keterangan'];
			}
			echo "
			<tr><td>Voucher</td><td>:</td><td>
			<select name='profile' style='padding:5px;width:200px;'  onchange='location = this.value; loader()' >
			<option value=''>Pilih Voucher</option>";			
			$dvcr	= cvoucher(explode(" ",ltrim($mrouter))[1]);
			$vcr	= explode("*",$dvcr);
			$harga="";
			$durasi="";
			for ($i = 1; $i < count($vcr); $i++) {
				$pvcr	= explode("*",$vcr[$i]);
				$pvcr0	= explode("|",$pvcr[0]);
				$Vcr	= "VCR ".substr("    ".$pvcr0[4],-3);
				$Vrp	= rupiah(trim($pvcr0[3]));
				$sped   =substr("   ".$pvcr0[6],strlen($pvcr0[4])-9);
				$text	="<b>".$Vcr."  ".$sped."  ".$Vrp."</b>\n";
				if (ltrim($pvcr0[0])==ltrim($mprofile)) {
					echo "<option value='?apk=a10&mrouter=".$mrouter."&mprofile=".$pvcr0[0]."' selected>".$pvcr0[0]."</option>";
					$harga=$Vrp;
					$durasi=$pvcr0[1];
				}else{
					echo "<option value='?apk=a10&mrouter=".$mrouter."&mprofile=".$pvcr0[0]."'>".$pvcr0[0]."</option>";
				}
			}
			echo "
			</select>
			</td></tr>
			<tr><td>Harga</td><td>:</td><td style='border-radius:2px;padding:5px;'><b style='background-color:#004d4d;border-radius:2px;padding:5px 15px 5px;'>".$harga." / ".$durasi."</b></td></tr>
			<tr><td>Pelanggan</td><td>:</td><td>
			<select name='tujuan' style='padding:5px;width:200px;' onchange='location = this.value; loader()'>
			<option value=''>Pilih Pelanggan</option>";
			$dtpell=lpelanggan($nomor);
			for ($i=0 ; $i<count($dtpell) ; $i++)  {
				$isi=$dtpell[$i];
				$sele="";
				if (ltrim($isi['Token'])==ltrim($_GET['tujuan'])) {$sele="selected";$tujuan=$isi['Token'];}
				echo "<option value='?apk=a10&mrouter=".$mrouter."&mprofile=".$mprofile."&tujuan=".$isi['Token']."' ".$sele." >".$isi['ipserver']."-".$isi['Token']."</option>";
			}
			$mkode=strtoupper($data['type'].$pvcr0[4]."-".kuser(6));
			echo "
			</select>
			</td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td colspan='3' align='center'>
			<input type='submit' name='abatal'  value=' Batal '>
			<a href='?apk=a101&router=".$mrouter."&profile=".$mprofile."&tujuan=".$tujuan."&mkode=".$mkode."'><input type='button' name='kirimvcr'  value=' Buat Voucher '></a>
			</td></tr>
			<tr><td colspan='3' align='center' style='color:white;background-color:black;border:1px solid white;border-radius:10px;padding:10px;'>Jika Pelanggan diisi, maka Voucher akan di kirim ke WA.</td></tr>
			</tabe>
			";
		}elseif ($apk=="a101")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
					<a href='?apk=a10'>Voucher</a>
					<a href='?apk=a20'>Laporan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>";
			$router="";
			$kode="1";
			if (isset($_GET['router'])) {
				$router=$_GET['router'];
				if (strlen($router)==0) {
					$kode="0";
					echo "<script>setTimeout(\"location.href = '?apk=a10';\");</script>";
				}
			}
			$profile="";
			if (isset($_GET['profile'])) {
				$profile=$_GET['profile'];
				if (strlen($profile)==0) {
					$kode="0";
					echo "<script>setTimeout(\"location.href = '?apk=a10';\");</script>";
				}
			}
			$tujuan="";
			if (isset($_GET['tujuan'])) {
				$tujuan=$_GET['tujuan'];
			}
			$dtvcr=explode("|",cvdetail(explode(" ",ltrim($router))[1], $profile));
			if ($kode=="0") {
				$mkode="#YOU-OK#";
			}else{
				$mkode=$_GET['mkode'];
			}
			$data1=creseller($nomor);
//			if ($dtvcr[2]>$data1['saldo']) {
//				$mket="Saldo Anda Kurang";
//				echo "<script>setTimeout(\"location.href = '?apk=a103&mket=".$mket."';\");</script>";
//			}
			$markup=$dtvcr[3]-$dtvcr[2];
			if (strlen($tujuan)<>0) {
				echo "<table><caption>KIRIM KE</caption>
				<tr><td>ID WA</td><td>:</td><td>".$tujuan."</td></tr>
				<tr><td>ID Nama</td><td>:</td><td>".cnpelanggan($tujuan)['ipserver']."</td></tr>
				</table>";
			}
			echo "
			<center>
			<table style='margin-top:10px;border:1px solid white;padding:10px;width:100%;background-color:black;'>
			<tr><td>".$dtvcr[1]."</td><td style='text-align:right;'>".$dtvcr[0]."</td></tr>
			<tr><td></td><td style='text-align:center;background-color:blue;font-size:28px;font-weight:bold;font-family:times;border-radius:5px;border:2px solid white;'>".$mkode."</td></tr>
			<tr><td></td>
			<tr><td>".rupiah($dtvcr[3])."</td><td style='text-align:right;'>".$dtvcr[5]."</td></tr>
			</table>
			<p><a href='?apk=a102&router=".$dtvcr[5]."&profile=".$dtvcr[0]."&durasi=".$dtvcr[4]."&tujuan=".$tujuan."&mkode=".$mkode."&harga=".$dtvcr[3]."&markup=".$markup."'><input type='button' name='kirimvcr' value=' Bayar '></a>
			</center>";
		}elseif ($apk=="a102")  {
			$drtr	= explode("|",crouter1($_GET['router']));
			$mkode		=$_GET['mkode'];
			$profile	=$_GET['profile'];
			$durasi		=$_GET['durasi'];
			$tujuan		=$_GET['tujuan'];
			$mtgl=date('d/m/Y');
			$mtime=date('H:i:s');
			$vfile	= "vc-APK-".$data['nama_seller']."-".substr($mtgl,0,2).".".substr($mtgl,3,2).".".substr($mtgl,6,4).".".substr($mtime,0,2).".".substr($mtime,3,2);
			$mket="Sukses.";
			$API = new RouterosAPI();
			$API->debug = false;
			if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
				$ISI = $API->comm("/ip/hotspot/user/print", ["?name" => $mkode, ]);
				if (empty($ISI)) {
//admin
					$ok="Yes";
					if ($ok=="Yes") {
						$add_user_api = $API->comm("/ip/hotspot/user/add", [
						"server" => 'all',
						"profile" => $profile,
						"name" => $mkode,
						"password" => $mkode,
						"limit-uptime" => $durasi,
						"comment" => $vfile,
//						"limit-bytes-out" => '',
//						"limit-bytes-in" => '',
//						"limit-bytes-total" => '',
						]);
						$cekvalidasiadd = json_encode($add_user_api);
						if (strpos(strtolower($cekvalidasiadd), '!trap')) {
						$ARRAY2 = $API->comm("/ip/hotspot/user/remove", ["numbers" => $add_user_api, ]);
						$mket="Gagal.";
						}
					}
				}else{
					$mket="Gagal. [0890]";
				}
			}else{
				$mket="Tidak bisa terhubung dengan Router ".$drtr[0];
			}
			if ($mket=="Sukses.") {
				$simpan=apkbelivoucher($nomor, $data['nama_seller'], $_GET['harga'], $_GET['markup'], $mkode, $mkode, $durasi."-".$profile, "Success", $nowa);
				$kirim="Konfimasi Pembelian Vcr.\n\n".$mkode;
				if (strlen($tujuan)<>0) {
					$kirimwa=kirimwaid($tujuan,$kirim);
				}
			}
			echo "<script>setTimeout(\"location.href = '?apk=a103&mket=".$mket."&harga=".$_GET['harga']."&markup=".$_GET['markup']."&sawal=".$simpan."&profile=".$profile."&mkode=".$mkode."&tujuan=".$tujuan."';\");</script>";
		}elseif ($apk=="a103")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
					<a href='?apk=a10'>Voucher</a>
					<a href='?apk=a20'>Laporan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>";
			if ($_GET['mket']=="Sukses.") {
				$sakhir=$_GET['sawal']-$_GET['harga']+$_GET['markup'];
				echo "<table><caption>STATUS</caption>
				<tr><td width='35%'>&nbsp</td><td></td><td></td></tr>
				<tr><td>Voucher</td><td>:</td><td>".$_GET['profile']."</td></tr>
				<tr><td>Kode Vcr</td><td>:</td><td>".$_GET['mkode']."</td></tr>
				<tr><td>Saldo Awal</td><td>:</td><td>".rupiah($_GET['sawal'])."</td></tr>
				<tr><td>Harga Jual</td><td>:</td><td>".rupiah($_GET['harga'])."</td></tr>
				<tr><td>Profit</td><td>:</td><td>".rupiah($_GET['markup'])."</td></tr>
				<tr><td>Saldo Akhir</td><td>:</td><td>".rupiah($_GET['sawal']-$_GET['harga']+$_GET['markup'])."</td></tr>
				<tr><td>&nbsp</td><td></td><td></td></tr>
				<tr><td colspan='3' style='color:white;background-color:black;padding:10px;border:1px solid white;border-radius:10px;font-weight:bold;font-family:times;'>".ltrim(ucwords(penyebut($sakhir)))." Rupiah.<br>Terimaksih dan Selamat ".sapaan()."</td></tr>
				</table>";
			}	
			echo "<p><hr><b style='font-size:18px;color:white;'><marquee Behavior='alternate'>".$_GET['mket']."</marquee></b><hr>";
		}elseif ($apk=="a20")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
					<a href='?apk=a20'>L-Harian</a>
					<a href='?apk=a201'>L-Bulanan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<h4>Laporan-Harian</h4>			
			";
		}elseif ($apk=="a201")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
					<a href='?apk=a20'>L-Harian</a>
					<a href='?apk=a201'>L-Bulanan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<h4>Laporan-Bulanan</h4>			
			";
		}elseif ($apk=="30")  {
//phbook
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=30'>Input</a>
				<a href='?apk=31'>PhoneBook</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>			
			<table><caption>INPUT PHONE BOOK</caption>
			<tr><td>&nbsp</td><td></td><td>
			<tr><td>No WA</td><td>:</td><td>
			<input type='number' name='pnomor' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:150px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			<tr><td>Nama</td><td>:</td><td>
			<input type='text' name='pnama' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:200px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			</td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td></td><td></td><td>
			<input type='submit' name='phbook' value=' Simpan '>
			</td></tr>
			</table>
			";
		}elseif ($apk=="31")  {
			$dpell=lpelanggan($nomor);
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
				<div id='myLinks'>
					<a href='?apk=30'>Input</a>
					<a href='?apk=31'>PhoneBook</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<p>
			<div style='overflow-x:auto;'>
			<table>
			<caption>PHONE BOOK</caption><tr><th>No</th><th>Nomor</th><th style='text-align:left;'>Nama</th></tr>";
			for ( $i=0 ; $i<count($dpell) ; $i++ ) {
				$disi=$dpell[$i];
				$no=$i+1;
				echo "<tr><td style='font-size:16px;text-align:right;'>".$no.".</td><td style='font-size:16px;text-align:right;width:25%;'>".$disi['Token']."</td><td style='font-size:16px;'>".$disi['ipserver']."</td></tr>";
			}
			echo "</table></div>
			";
		}else{
//awal tampilan admin
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0' class='active'>Admin</a>
			<div id='myLinks'>
				<a href='?apk=11'>Reseller</a>
				<a href='?apk=a10'>Vcr</a>
				<a href='?apk=31'>PhBook</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>
			<div style='padding-left:10px;padding-right:10px'>
			<p>Selamat ".sapaan()." ".$nama.".<p>Ini adalah Aplikasi Distribusi Voucher.<p>Silahkan ketuk lambang  <i class='fa fa-bars'> </i>
			<center><img src='./img/mickey1.png' style='height:200px;border-radius:10px;margin-top:20px;'></center>
			</div>";
		}
	}else{
//reseller
//reseller
		$data=creseller($nomor);
		if ($apk=="r10")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Re-Seller</a>
				<div id='myLinks'>
					<a href='?apk=r10'>Voucher</a>
					<a href='?apk=r20'>Laporan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<table><caption>PEMBUATAN VOUCHER</caption>
			<tr><td>Saldo</td><td>:</td><td><b style='background-color:#004d4d;border-radius:2px;padding:5px 15px 5px;'>".rupiah($data['saldo'])."</b></td></tr>";
			$drouter=crouter();
			$idrouter=explode("!",$drouter);
			if ($data['keterangan']=="ALL") {
				echo "
				<tr><td>Router</td><td>:</td><td>
				<select name='mrouter' style='padding:5px;width:200px;'  onchange='location = this.value; loader()' >
				<option value=''>Pilih Router</option>";
				for ($i=0 ; $i<count($idrouter)-1 ; $i++)  {
					$n=$i+1;
					$router1=$idrouter[$i];
					$router2=explode("|",$router1);
					$router=$n.". ".$router2[0];
					$sele="";
					if ($router==$mrouter) {$sele="selected";}
					echo "<option value='?apk=r10&mrouter=".$router."' ".$sele.">".$router."</option>";
				}
				echo "</td></tr>
				</select>
				";
			}else{
				echo "<tr><td>Router</td><td>:</td><td>".$data['keterangan']."</td></tr>";
				$mrouter=$data['keterangan'];
			}
			echo "
			<tr><td>Voucher</td><td>:</td><td>
			<select name='profile' style='padding:5px;width:200px;'  onchange='location = this.value; loader()' >
			<option value=''>Pilih Voucher</option>";			
			$dvcr	= cvoucher(explode(" ",ltrim($mrouter))[1]);
			$vcr	= explode("*",$dvcr);
			$harga="";
			$durasi="";
			for ($i = 1; $i < count($vcr); $i++) {
				$pvcr	= explode("*",$vcr[$i]);
				$pvcr0	= explode("|",$pvcr[0]);
				$Vcr	= "VCR ".substr("    ".$pvcr0[4],-3);
				$Vrp	= rupiah(trim($pvcr0[3]));
				$sped   =substr("   ".$pvcr0[6],strlen($pvcr0[4])-9);
				$text	="<b>".$Vcr."  ".$sped."  ".$Vrp."</b>\n";
				if (ltrim($pvcr0[0])==ltrim($mprofile)) {
					echo "<option value='?apk=r10&mrouter=".$mrouter."&mprofile=".$pvcr0[0]."' selected>".$pvcr0[0]."</option>";
					$harga=$Vrp;
					$durasi=$pvcr0[1];
				}else{
					echo "<option value='?apk=r10&mrouter=".$mrouter."&mprofile=".$pvcr0[0]."'>".$pvcr0[0]."</option>";
				}
			}
			echo "
			</select>
			</td></tr>
			<tr><td>Harga</td><td>:</td><td style='border-radius:2px;padding:5px;'><b style='background-color:#004d4d;border-radius:2px;padding:5px 15px 5px;'>".$harga." / ".$durasi."</b></td></tr>
			<tr><td>Pelanggan</td><td>:</td><td>
			<select name='tujuan' style='padding:5px;width:200px;' onchange='location = this.value; loader()'>
			<option value=''>Pilih Pelanggan</option>";
			$dtpell=lpelanggan($nomor);
			for ($i=0 ; $i<count($dtpell) ; $i++)  {
				$isi=$dtpell[$i];
				$sele="";
				if (ltrim($isi['Token'])==ltrim($_GET['tujuan'])) {$sele="selected";$tujuan=$isi['Token'];}
				echo "<option value='?apk=r10&mrouter=".$mrouter."&mprofile=".$mprofile."&tujuan=".$isi['Token']."' ".$sele." >".$isi['ipserver']."-".$isi['Token']."</option>";
			}
			$mkode=strtoupper($data['type'].$pvcr0[4]."-".kuser(6));
			echo "
			</select>
			</td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td colspan='3' align='center'>
			<input type='submit' name='rbatal'  value=' Batal '>
			<a href='?apk=r101&router=".$mrouter."&profile=".$mprofile."&tujuan=".$tujuan."&mkode=".$mkode."'><input type='button' name='kirimvcr'  value=' Buat Voucher '></a>
			</td></tr>
			<tr><td colspan='3' align='center' style='color:white;background-color:black;border:1px solid white;border-radius:10px;padding:10px;'>Jika Pelanggan diisi, maka Voucher akan di kirim ke WA.</td></tr>
			</tabe>
			";
		}elseif ($apk=="r101")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Re-Seller</a>
				<div id='myLinks'>
					<a href='?apk=r10'>Voucher</a>
					<a href='?apk=r20'>Laporan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>";
			$router="";
			$kode="1";
			if (isset($_GET['router'])) {
				$router=$_GET['router'];
				if (strlen($router)==0) {
					$kode="0";
					echo "<script>setTimeout(\"location.href = '?apk=r10';\");</script>";
				}
			}
			$profile="";
			if (isset($_GET['profile'])) {
				$profile=$_GET['profile'];
				if (strlen($profile)==0) {
					$kode="0";
					echo "<script>setTimeout(\"location.href = '?apk=r10';\");</script>";
				}
			}
			$tujuan="";
			if (isset($_GET['tujuan'])) {
				$tujuan=$_GET['tujuan'];
			}
			$data=explode("|",cvdetail(explode(" ",ltrim($router))[1], $profile));
			if ($kode=="0") {
				$mkode="#YOU-OK#";
			}else{
				$mkode=$_GET['mkode'];
			}
			$data1=creseller($nomor);
			if ($data[2]>$data1['saldo']) {
				$mket="Saldo Anda Kurang";
				echo "<script>setTimeout(\"location.href = '?apk=r103&mket=".$mket."';\");</script>";
			}
			$markup=$data[3]-$data[2];
			if (strlen($tujuan)<>0) {
				echo "<table><caption>KIRIM KE</caption>
				<tr><td>ID WA</td><td>:</td><td>".$tujuan."</td></tr>
				<tr><td>ID Nama</td><td>:</td><td>".cnpelanggan($tujuan)['ipserver']."</td></tr>
				</table>";
			}
			echo "
			<center>
			<table style='margin-top:10px;border:1px solid white;padding:10px;width:100%;background-color:black;'>
			<tr><td>".$data[1]."</td><td style='text-align:right;'>".$data[0]."</td></tr>
			<tr><td>&nbsp</td><td style='background-color:blue;font-size:28px;font-weight:bold;font-family:times;border-radius:5px;border:2px solid white;text-align:center;'>".$mkode."</td></tr>
			<tr><td>".rupiah($data[3])."</td><td style='text-align:right;'>".$data[5]."</td></tr>
			</table>
			<p><a href='?apk=r102&router=".$data[5]."&profile=".$data[0]."&durasi=".$data[4]."&tujuan=".$tujuan."&mkode=".$mkode."&harga=".$data[3]."&markup=".$markup."'><input type='button' name='kirimvcr' value=' Bayar '></a>
			</center>";
		}elseif ($apk=="r102")  {
			$drtr	= explode("|",crouter1($_GET['router']));
			$mkode		=$_GET['mkode'];
			$profile	=$_GET['profile'];
			$durasi		=$_GET['durasi'];
			$tujuan		=$_GET['tujuan'];
			$mtgl=date('d/m/Y');
			$mtime=date('H:i:s');
			$vfile	= "vc-APK-".$data['nama_seller']."-".substr($mtgl,0,2).".".substr($mtgl,3,2).".".substr($mtgl,6,4).".".substr($mtime,0,2).".".substr($mtime,3,2);
			$mket="Sukses.";
			$API = new RouterosAPI();
			$API->debug = false;
			if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
				$ISI = $API->comm("/ip/hotspot/user/print", ["?name" => $mkode, ]);
				if (empty($ISI)) {
					$ok="Yes";
					if ($ok=="Yes") {
						$add_user_api = $API->comm("/ip/hotspot/user/add", [
						"server" => 'all',
						"profile" => $profile,
						"name" => $mkode,
						"password" => $mkode,
						"limit-uptime" => $durasi,
						"comment" => $vfile,
//						"limit-bytes-out" => '',
//						"limit-bytes-in" => '',
//						"limit-bytes-total" => '',
						]);
						$cekvalidasiadd = json_encode($add_user_api);
						if (strpos(strtolower($cekvalidasiadd), '!trap')) {
							$ARRAY2 = $API->comm("/ip/hotspot/user/remove", ["numbers" => $add_user_api, ]);
							$mket="Gagal.";
						}
					}
				}else{
					$mket="Gagal.[0890]";
				}
			}else{
				$mket="Tidak bisa terhubung dengan Router ".$drtr[0];
				echo $mket;
			}
			if ($mket=="Sukses.") {
				$simpan=apkbelivoucher($nomor, $data['nama_seller'], $_GET['harga'], $_GET['markup'], $mkode, $mkode, $durasi."-".$profile, "Success", $nowa);
				$kirim="".$mkode;
				$kirimwa=kirimwaid($tujuan,$kirim);
			}
			echo "<script>setTimeout(\"location.href = '?apk=r103&mket=".$mket."&harga=".$_GET['harga']."&markup=".$_GET['markup']."&sawal=".$simpan."&profile=".$profile."&mkode=".$mkode."';\");</script>";
		}elseif ($apk=="r103")  {
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Re-Seller</a>
				<div id='myLinks'>
					<a href='?apk=r10'>Voucher</a>
					<a href='?apk=r20'>Laporan</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>";
			if ($_GET['mket']=="Sukses.") {
				$sakhir=$_GET['sawal']-$_GET['harga']+$_GET['markup'];
				echo "<table><caption>STATUS</caption>
				<tr><td width='35%'>&nbsp</td><td></td><td></td></tr>
				<tr><td>Voucher</td><td>:</td><td>".$_GET['profile']."</td></tr>
				<tr><td>Kode Vcr</td><td>:</td><td>".$_GET['mkode']."</td></tr>
				<tr><td>Saldo Awal</td><td>:</td><td>".rupiah($_GET['sawal'])."</td></tr>
				<tr><td>Harga Jual</td><td>:</td><td>".rupiah($_GET['harga'])."</td></tr>
				<tr><td>Profit</td><td>:</td><td>".rupiah($_GET['markup'])."</td></tr>
				<tr><td>Saldo Akhir</td><td>:</td><td>".rupiah($_GET['sawal']-$_GET['harga']+$_GET['markup'])."</td></tr>
				<tr><td>&nbsp</td><td></td><td></td></tr>
				<tr><td colspan='3' style='color:white;background-color:black;padding:10px;border:1px solid white;border-radius:10px;font-weight:bold;font-family:times;'>".ltrim(ucwords(penyebut($sakhir)))." Rupiah.<br>Terimaksih dan Selamat ".sapaan().".</td></tr>
				</table>";
			}
			echo "<p><hr><b style='font-size:18px;color:white;'><marquee Behavior='alternate'>".$_GET['mket']."</marquee></b><hr>";
		}elseif ($apk=="r30")  {
//phbook
			echo "<div class='topnav'>
			<a href='mikhmon1.php?apk=0' class='active'>Re-Seller</a>
			<div id='myLinks'>
				<a href='?apk=r30'>Input</a>
				<a href='?apk=r31'>PhoneBook</a>
			</div>
			<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
				<i class='fa fa-bars'></i>
			</a>
			</div>			
			<table><caption>INPUT PHONE BOOK</caption>
			<tr><td>&nbsp</td><td></td><td>
			<tr><td>No WA</td><td>:</td><td>
			<input type='number' name='pnomor' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:150px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			<tr><td>Nama</td><td>:</td><td>
			<input type='text' name='pnama' style='font-size:16px;border-radius:5px;font-weight:bold;padding:5px 5px;width:200px;heigh:50px;' maxlength='20' required='1' value=''>
			</td></tr>
			</td></tr>
			<tr><td>&nbsp</td><td></td><td></td></tr>
			<tr><td></td><td></td><td>
			<input type='submit' name='rphbook' value=' Simpan '>
			</td></tr>
			</table>
			";
		}elseif ($apk=="r31")  {
//list pb
			$dpell=lpelanggan($nomor);
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Re-Seller</a>
				<div id='myLinks'>
					<a href='?apk=r30'>Input</a>
					<a href='?apk=r31'>PhoneBook</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<p>
			<div style='overflow-x:auto;'>
			<table>
			<caption>PHONE BOOK</caption><tr><th>No</th><th>Nomor</th><th style='text-align:left;'>Nama</th></tr>";
			for ( $i=0 ; $i<count($dpell) ; $i++ ) {
				$disi=$dpell[$i];
				$no=$i+1;
				echo "<tr><td style='font-size:16px;text-align:right;'>".$no.".</td><td style='font-size:16px;text-align:right;width:25%;'>".$disi['Token']."</td><td style='font-size:16px;'>".$disi['ipserver']."</td></tr>";
			}
			echo "</table></div>
			";
		}else{
			echo "
			<div class='topnav'>
				<a href='mikhmon1.php?apk=0' class='active'>Re-Seller</a>
				<div id='myLinks'>
					<a href='?apk=r10'>Vocher</a>
					<a href='?apk=r31'>PhoneBook</a>
				</div>
				<a href='javascript:void(0);' class='icon' onclick='myFunction()'><i class='fa fa-bars'></i></a>
			</div>
			<div style='padding-left:10px;padding-right:10px'>
				<p>Selamat ".sapaan()." ".$data['nama_seller']."<br>Saldo : ".rupiah($data['saldo'])."<br>Router : ".$data['keterangan']." - Prefix [ ".$data['type']." ]<hr>
				<center><img src='./img/mickey2.png' style='height:250px;border-radius:10px;margin-top:20px;'></center>
			</div>";
		}
	}
}
?>	
</form>
<script type="text/javascript">
        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>	
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
