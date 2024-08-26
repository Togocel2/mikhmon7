<?php
if (!isset($_GET['nomor']) || !isset($_GET['nama']))  {
	echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
	echo "<body style='max-width: 480px; height: 540px; margin: auto;  background-color: #555; color: white;  border-radius: 10px; transition: all 3s;'>";
	echo "<center><img src='img/logo.png' style='width:100%;border-radius:10px;margin-bottom:50px;'>";
	echo "<p><hr><b style='font-size:18px;color:white;'><marquee Behavior='alternate'>ANDA MASUK SECARA ILEGAL</marquee></b><hr></center></body>";
	die ();
}

$pesan="Link Aplikasi akan dikirim ke nomor yang Anda Aktivasi.";
$mnomor=$_GET['nomor'];
$mnama =$_GET['nama'];
$key =$_GET['key'];
require_once 'system.database.php';
$cnowa=dtidwa(0);
$owner=dtidwa(2);
$ckey0=cdata($mnomor);
$ckey= $ckey0['status'];
if ($ckey<>$key)  {
	echo "<body bgcolor=#555>";
	echo "<center><img src='../webhook/img/logo.png' style='width:100%;border-radius:10px;margin-bottom:100px;'>";
	echo "<p><hr><h1 style='font-size:48px;color:white;'>SILAHKAN HUB ".$owner." DI NOMOR ".$cnowa."</h1><hr></center>";
	die ();
}
if (isset($_POST['aktifasi']))  {
	if (strlen($_POST['nomor'])<10)  {
		$pesan="Nomor WA Terlalu Pendek";
	}else{
		if (preg_match('/^[0-9]+$/', $_POST['nomor'])) {
			$nowa=nomor($_POST['nomor']);
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
			$key=kuser(15);
			$cookie_name = "key";
			$cookie_value = $key;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); // cookies 7 day
			$cookie_name = "nomor";
			$cookie_value = $nowa;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); // cookies 7 day

			$urlpath=explode("?",$_SERVER['REQUEST_URI']);
			$ltopup =$cekhttps.$_SERVER['HTTP_HOST'].str_replace('mikhmon.php', 'mikhmon1.php',$urlpath[0]);
			$pesan="Silahkan klik link dibawah ini, untuk menggunakan Aplikasi.\n\n".$ltopup."\n";
			$simpan=apkaktifasi($nowa,$key);

			$pilih="wa";

			if (strtoupper($pilih)=="WA") {
				$kirim=kirimwaid($nowa,$simpan."\n".$pesan);
				echo "<script>setTimeout(\"location.href = 'https://wa.me/".$nowa."';\");</script>";
			}else{
				$kirim1=kirimtele($simpan."\n".$pesan);
				echo "<script>setTimeout(\"location.href = 'https://t.me/Rasendria001';\");</script>";
			}
			$pesan="Kode Aktifasu telah dikirim ke nomor $nowa.";
		}else{
			$pesan="Isi Nomor WA dengan ANGKA Only.";
		}
	}

}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body { font-family: Arial, Helvetica, sans-serif;font-size:20px;font-family:timesnewroman;}
.mobile-container {  max-width: 480px; height: 500px; margin: auto;  background-color: #555; color: white;  border-radius: 10px; ;
  transition: all 3s;
}
.topnav { overflow: hidden;  background-color: #333;  position: relative;}
.topnav #myLinks {  display: none;}
.topnav a {  float: left;  color: white;  padding: 14px 16px;  text-decoration: none;  font-size: 16px;}
.topnav a.icon {  float: right;}
.topnav a:hover {  background-color: #ddd;  color: black;}
.active {  background-color: #04AA6D; color: white;}
td {padding:5px 5px;font-size:16px;}
</style>
</head>
<body>
<div class="mobile-container">
<img src="img/logo.png" height="100px" width="100%"><center><br>
<form autocomplete="off" method="post" action="" >
Nomor WA Anda<p><input type="number" name="nomor" style="font-size:20px;border-radius:5px;font-weight:bold;padding:5px 15px;width:150px;" maxlength="20" required="1" value="<?=$mnomor?>" readonly ><br>
<input type="text" name="nama" style="text-align:center;margin-top:10px;font-size:20px;border-radius:5px;font-weight:bold;padding:5px 15px;width:200px;heigh:60px;" maxlength="25" value="<?=$mnama?>" readonly ><p>
<input type="submit" name="aktifasi" style="padding:5px;font-size:20px;border-radius:5px;font-family:timesnewroman;background-color:#adebeb;font-weight:bold;" value=" Aktivasi ">
</form>
<i style="font-size:18px;margin-left:25px"><?=$pesan?></i>
</center>
</body>
</html>
