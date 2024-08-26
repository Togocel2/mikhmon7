<?php
error_reporting(0);
date_default_timezone_set('Asia/Makassar');
if (!isset($_SESSION["mikhmon"])) {
	header("Location:../admin.php?id=login");
} else {
	require_once 'system.database.php';
	include_once('./lib/routeros_api.class.php');
	include_once('./lib/formatbytesbites.php');
	$file = './webhook/webhookk.php';
	$scheme = $_SERVER['REQUEST_SCHEME'];
	if (strpos(strtolower($scheme), 'http') !== false){
		$cekhttps="https://";
	}else{
		$cekhttps=$scheme."://";
	}
	$urlpath	=$_SERVER['REQUEST_URI'];
	$urlpath1	=explode('?',$urlpath);
	$urltele	=$cekhttps.$_SERVER['HTTP_HOST'].$urlpath1[0].'webhook/Core.php';
	if (isset($_POST["save"])) {
		$midtele 	= ($_POST['idtele']);
		$mnamatele 	= ($_POST['namatele']);
		$mbottele 	= ($_POST['bottele']);
		$mtokentele = ($_POST['tokentele']);
		
		$mtulis = $midtele."|".$mnamatele."|".$mbottele."|".$mtokentele."|".$urltele."|";
		$handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
		fwrite($handle, $mtulis);
		fclose($handle);

		$set=setwebhook($urltele,$mtokentele);
		
		if ($session=="") {
			echo "<script>setTimeout(\"location.href = './admin.php?id=webhook';\");</script>";
		}else{
			echo "<script>setTimeout(\"location.href = '?hotspot=webhook&session=$session';\");</script>";
		}
		
		
		$getwebhhok=getWebhookInfo($mtokentele);
		$jsonget=json_decode($getwebhhok,true);
		$result=$jsonget['result'];
		if(!empty($result['url'])){
			$urlaktif="Web Hook Sudah Aktif.";
		}else{
			$urlaktif="Web Hook Tidak Aktif.";
		}
		$text="Hai,..@".$mnamatele.".\n\n".$urlaktif."\n\nSelamat ".sapaan()." dan Terimakasih.\n.";
		$mtbot=sendMessage($midtele, $text, $mtokentele);
	}

	if (file_exists($file)) {
		$misi		= file_get_contents("./webhook/webhookk.php");
		$misi0		= explode("|",$misi);
		$idtele		= $misi0[0];
		$namatele	= $misi0[1];
		$bottele	= $misi0[2];
		$tokentele	= $misi0[3];
		$murlb		= $misi0[4];
	}
   	
	if ($murlb<>$urltele){
   		if (!empty($tokentele)){
			$text="Hai,..@".$namatele.".\n\nFungsi Web Hook Telah di Non Aktifkan.\n\nUrl tidak sama.\n\nSelamat ".sapaan()." dan Terimakasih.\n";
			$mtbot=sendMessage($idtele, $text, $tokentele);
			$uset=	unssetwebhook($tokentele); 
		}
   	}

	if (isset($_POST["batal"])){
   		if (!empty($tokentele)){
			$text="Hai,..@".$namatele.".\n\nFungsi Web Hook Telah di Non Aktifkan.\n\nSelamat ".sapaan()." dan Terimakasih.\n";
			$mtbot=sendMessage($idtele, $text, $tokentele);
			$uset=	unssetwebhook($tokentele); 
		}
   	}
   	if (isset($_POST["tbot"])) {
   		if (!empty($tokentele)) {
			$text="Hai,..\n\nSaya @".$bottele." siap melayani Anda @".$namatele.".\n\nSelamat ".sapaan()." dan Terimakasih.\n";
			$mtbot=sendMessage($idtele, $text, $tokentele);
		}
	}
	if (isset($_POST["update1"])) {
	}
	if (isset($_POST["update"])) {
   		if (!empty($tokentele)) {
			$misi	= file_get_contents("./include/config.php");
			$misi0	= explode("[",$misi);
			$jr		= count($misi0);
			$kirim	="";
			$cek="";
			$API = new RouterosAPI();
			$API->debug = false;
			$mtulis="";
			$updateok="1";
			for ($i = 3; $i < $jr; $i++) {
				$misi1	= explode("'",$misi0[$i]);
				$router	= $misi1[1];
				$mtulis .= $router;
				$ipr1	= explode($router,$misi0[$i]);
				$ipr	= substr($ipr1[2],1,-3);
				$unr	= substr($ipr1[3],3,-3);
				$pwr	= decrypt(substr($ipr1[4],3,-3));
				if ($API->connect($ipr, $unr, $pwr)){
					$getprofile = $API->comm("/ip/hotspot/user/profile/print");
					$TotalReg = count($getprofile);
					for ($ii = 0; $ii < $TotalReg; $ii++) {
						$profile 	= $getprofile[$ii];
						$mcet 		=$profile['name'];
						$speed 		=$profile['rate-limit'];
						$spead		=explode(" ",$speed);
						$spaed		=$spead[0];
						$mhrg0		=$profile['on-login'];
						$mhrg1		=explode(',',$mhrg0);
						$modal		=$mhrg1[2];
						$mpak 		=$mhrg1[3];
						$mhrg 		=$mhrg1[4];
						$limituptime=$mpak;
						switch ($limituptime) {
							case null:
								$limituptimereal = '00:00:00';
							case '00:00:00':
								$limituptimereal = '00:00:00';
							default:
								$limituptimereal = $limituptime;
	
							if (strpos(strtolower($limituptimereal), 'h') !== false) {
								$uptime = str_replace('h', ' Jam', $limituptime);
							} elseif (strpos(strtolower($limituptime), 'd') !== false) {
								$uptime = str_replace('d', ' Hari', $limituptime);
							} elseif (strpos(strtolower($limituptime), 'w') !== false) {
								$uptime = str_replace('w', ' Minggu', $limituptime);
							} elseif (strpos(strtolower($limituptime), 'm') !== false) {
								$uptime = str_replace('m', ' Bulan', $limituptime);
							} elseif (strpos(strtolower($limituptime), 'y') !== false) {
								$uptime = str_replace('y', ' Tahun', $limituptime);
							}
							if ($modal>1) {
//							$mtulis .="*\n".$mcet."|".$uptime."|".$modal."|".$mhrg."|".$mpak."|".$dnsname."|".$speed;}
							$mtulis .="*\n".$mcet."|".$uptime."|".$modal."|".$mhrg."|".$mpak."|".$dnsname."|".$spaed;}
						}
					}
				}else{
					$updateok="0";
				}
				$mtulis .="#\n\n";
			}
			if ($updateok=="0")	{
				if (!empty($tokentele)) {
					$text= "GAGAL MELAKUKAN PEMUTAKHIRAN DATA VOUCHER.\n\nCEK KONEKSI DAN ROUTER ANDA.\n\nTUNGGU 5 MENIT DAN LAKUKAN UPDATE KEMBALI.";
					$cek =sendMessage($idtele, $text, $tokentele);
				}
			}else{
//tuiis			
				$filec = './webhook/dvoucher.php';
				$handle = fopen($filec, 'w') or die('Cannot open file:  ' . $filec);
				fwrite($handle, $mtulis);
				fclose($handle);
				if (!empty($tokentele)) {
					$text= "PEMUTAKHIRAN DATA VOUCHER. BERHASIL DILAKUKAN\n\nSELAMAT BERAKTIFITAS DAN TERIMAKASIH.";
					$cek =sendMessage($idtele, $text, $tokentele);
				}
			}
		}
	}

//cekwebhook
	$getwebhhok=getWebhookInfo($tokentele);
	$jsonget=json_decode($getwebhhok,true);
	$result=$jsonget['result'];
	$mpp=$result[pending_update_count];
	if ($mpp<>0) {
		$mppk="[ Pesan Pending ".$result[pending_update_count]." ]";
	}else{
		$mppk="";
	}
	if(!empty($result['url'])){
		$urlaktif="Web Hook Sudah Aktif. ".$mppk;
	}else{
		$urlaktif="Web Hook Tidak Aktif. ".$mppk;
	}

}

?>

<form autocomplete="off" method="post" action="">
	<div class="col-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fa fa-user-circle " ></i> Setting Web Hook</h3>
			</div>
			<div class="card-body">
				<table class="table table-sm">
					<?php if(!empty($result['url'])){
						echo '<tr><td class="align-middle">Id Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="idtele" placeholder="Isi Dengan Id Telegram Anda" value="'.$idtele.'" readonly/></td></tr>';
						echo '<tr><td class="align-middle">Nama Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="namatele" placeholder="Isi Dengan Nama Telegram Anda" value="'.$namatele.'" readonly/></td></tr>';
						echo '<tr><td class="align-middle">Bot Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="bottele" placeholder="Isi Dengan Bot Telegram Anda" value="'.$bottele.'" readonly/></td></tr>';
						echo '<tr><td class="align-middle">Token Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="tokentele" placeholder="Isi Dengan Token Bot Telegram Anda" value="'.$tokentele.'" readonly/></td></tr>';
						echo '<tr><td class="align-middle">Status</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="urlaktif" placeholder="Url Core" value="'.$urlaktif.'" readonly></td></tr>';
						echo '<tr><td class="align-middle">File Core</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="murla" placeholder="Url Hosting" value="'.$murlb.'" readonly></td></tr>';

						echo '<tr><td class="align-left"><input  class="btn bg-blue" type="submit" style="cursor: pointer;font-size:14px;font-family:timesnewroman;font-weight:bold;border-radius:5px green;" name="update" value="Update Data"></td><td></td>';
						echo '<td class="align-middle"><input  class="btn bg-red" type="submit" style="cursor: pointer;font-size:14px;font-family:timesnewroman;font-weight:bold;border-radius:5px green;" name="batal" value="UnSet WebHook"></td></tr>';
					}else{
						echo '<tr><td class="align-middle">Id Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="idtele" placeholder="Isi Dengan Id Telegram Anda" value="'.$idtele.'" required="1"/></td></tr>';
						echo '<tr><td class="align-middle">Nama Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="namatele" placeholder="Isi Dengan Nama Telegram Anda" value="'.$namatele.'" required="1"/></td></tr>';
						echo '<tr><td class="align-middle">Bot Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="bottele" placeholder="Isi Dengan Bot Telegram Anda" value="'.$bottele.'" required="1"/></td></tr>';
						echo '<tr><td class="align-middle">Token Telegram</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="tokentele" placeholder="Isi Dengan Token Bot Telegram Anda" value="'.$tokentele.'" required="1"/></td></tr>';
						echo '<tr><td class="align-middle">Status</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="urlaktif" placeholder="Url Core" value="'.$urlaktif.'" readonly></td></tr>';
						echo '<tr><td class="align-middle">File Core</td><td>:</td><td><input class="form-control" id="useradm" type="text" size="40" name="murla" placeholder="Url Hosting" value="'.$murlb.'" readonly></td></tr>';

						echo '<tr><td class="align-left"><input  class="btn bg-blue" type="submit" style="cursor: pointer;font-size:14px;font-family:timesnewroman;font-weight:bold;border-radius:5px green;" name="update" value="Update Data"></td><td></td>';
						echo '<td class="align-middle"><input  class="btn bg-green" type="submit" style="cursor: pointer;font-size:14px;font-family:times new roman;font-weight:bold;border-radius:5px green;" name="save" value="Set WebHook"></td></tr>';
					}?>
				</table>
			</div>
		</div>
	</div>
</form>
<h7>
	<div class="col-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fa fa-user-circle " ></i> Keterangan</h3>
			</div>
			<div class="card-body">
				<p style="text-indent: 30px;">Semua data yang digunakan untuk Bot Telegram, semuanya mengambil dari data yang dipergunakan Aplikasi Mikhmon, sehingga tidak ada data profil 
				ataupun data lainnya yang harus diinput untuk keperluan Bot Telegram.<?=$idtele;?>
				<p style="text-indent: 30px;">Perubahan yang dilakukan pada data yang digunakan Aplikasi Mikhmon <b style="color:red;">tidak</b> secara langsung akan merubah informasi data yang disajikan oleh Bot Telegram. 
				<p style="text-indent: 30px;">Untuk meng <b style="color:red;">Update</b> Informasi data yang di tampilkan oleh Bot, Anda harus meng Update secara manual dengan menekan tombol <input  type="submit" class="btn bg-blue" style="cursor: pointer;font-size:12px;font-family:timesnewroman;font-weight:bold;border-radius:5px green;" name="update1" value="Update Data">
				<p style="text-indent: 30px;">Untuk konsultasi lebih lanjut, silahkan klik <a href="https://wa.me/6287878868866" target="_new"><i style="color:blue;"><b>WA 087878868866</b></i> &#128241</a>.
				<br><i style="text-indent: 30px;">Terimakasih dan Selamat Beraktifitas.</i>
			</div>
		</div>
	</div>
<?php
$mtgl=date('d/m/Y');
$mtime=date('H:i:s');
$fdtvcr	= "./webhook/data/dt".substr(date('d/m/Y'),3,2).substr(date('d/m/Y'),6,4).".txt";
if (file_exists($fdtvcr)) {
	echo '
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<center style="font-size:20px;"><i>Tunggu, Sedang Parshing data,...'.date('H:i:s').' </i> ➤ <i style="color:red;" class="fa fa-circle-o-notch fa-spin"></i></center>
		</div>
	</div>
</div>';

}else{
	echo '
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<b style="font-family:timesnewrman;font-size:18px;"> <i class=" fa fa-sitemap"></i> ['.$mtime.'] - Aktivitas  @<a href="https://t.me/'.$bottele.'" target="_New"><u>'.$bottele.'</u></a>
		</div>
		<center>BELUM ADA DATA PEMBUATAN VOUCHER YANG BISA DI TAMPILKAN...</b> ➤ <i style="color:red;font-size:18px;" class="fa fa-circle-o-notch fa-spin"></i></center>
	</div>
</div>
';
}
?>
</h7>