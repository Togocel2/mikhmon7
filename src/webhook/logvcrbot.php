<?php
date_default_timezone_set('Asia/Jakarta');
include "system.database.php";
$bottele=cbot();
$fdata="../webhook/data/dtuser.txt";
if (!file_exists($fdata)) {
	$hasil = '
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
				<p style="text-indent: 30px;">Untuk konsultasi lebih lanjut, silahkan klik <a href="https://wa.me/6289633033332" target="_new"><i style="color:blue;"><b>https://wa.me/6289633033332</b></i> &#128241</a>.
				<br><i style="text-indent: 30px;">Terimakasih dan Selamat Beraktifitas.</i>
			</div>
		</div>
	</div>';
}else{
	$xx="";
	$mdata	= explode("#",cdatabot0($fdata,$xx));
	$juser	= count($mdata)-1;
	$hasil  = '
	<div class="col-6">
		<div class="card">
			<div class="card-header">
				<b style="font-family:timesnewrman;font-size:18px;"> <i class=" fa fa-sitemap"></i> User List. [ '.$juser.' ]</b>
			</div>
			<div class="card-body">
				<div class="overflow box-bordered mr-t-10" style="max-height: 37vh">
					<table id="dataTable" class="table table-bordered table-hover text-nowrap">
						<thead>
							<tr>
								<th style="text-align:right;">No.</th>
								<th>ID TELEGRAM</th>
								<th>USER</th>
								<th>NAMA</th>
								<th>TGL GABUNG</th>
							</tr>
						</thead>
						<tbody> ';
for ($i = count($mdata)-2 ; $i > -1 ; $i--) {
	$misi	= explode("|",$mdata[$i]);
	$no = $i+1;
						$hasil .= '<tr><td align="right">'.$no.'.</td><td>'.$misi[0].'</td><td><a href="https://t.me/'.$misi[1].'" target="_new1">'.$misi[1].'</a></td><td>'.$misi[2].'</td><td>'.$misi[3].'</td></tr>';
}
$hasil .= "
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
";
}

$mtgl=date('d/m/Y');
$mtime=date('H:i:s');
$fdtvcr	= "../webhook/data/dt".substr(date('d/m/Y'),3,2).substr(date('d/m/Y'),6,4).".txt";
if (file_exists($fdtvcr)) {
	$mdata	= explode("#",file_get_contents($fdtvcr));
	$no=count($mdata)-1;
	$tmodal=0;
	$thjual=0;
	for ($i = 0 ; $i < $no ; $i++) {
		$misi	= explode("|",$mdata[$i]);
		$tmodal	= $tmodal+$misi[7];
		$thjual	= $thjual+$misi[8];
	}
	$hasil .= '
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<b style="font-family:timesnewrman;font-size:18px;"> <i class=" fa fa-sitemap"></i> ['.$mtime.'] - Aktivitas  @<a href="https://t.me/'.$bottele.'" target="_New"><u>'.$bottele.'</u></a>, ['.$no.']-Vcr  di bulan  '.date('M-Y').' Total : '.rupiah($thjual-$tmodal).' | '.rupiah($tmodal).' | '.rupiah($thjual).'</b>
		</div>
		<div class="card-body">
			<div class="overflow box-bordered mr-t-10" style="max-height: 30vh">
				<table id="dataTable" class="table table-bordered table-hover text-nowrap">
					<thead>
						<tr>
						<th style="text-align:right;">No.</th>
						<th>ID TELEGRAM</th>
						<th> Jam/Tgl</th>
						<th align="center">ROUTER</th>
						<th align="center"> PAKET</th>
						<th>VOUCHER</th>
						<th style="text-align:right;"> MODAL</th>
						<th style="text-align:right;"> HARGA</th>
						<th style="text-align:right;"> AKTIF</th>
						</tr>
					</thead>
				';
for ($i = count($mdata)-2 ; $i > -1 ; $i--) {
	$misi	= explode("|",$mdata[$i]);

	$hasil .= '<tr><td align="right">'.$no.'.</td><td>'.$misi[0].'/'.$misi[1].'</td><td>'.$misi[2].' '.$misi[3].'</td><td align="center">'.$misi[4].'</td><td align="center">'.$misi[5].'</td><td>'.$misi[6].'</td><td align="right">'.rupiah($misi[7]).'</td><td align="right">'.rupiah($misi[8]).'</td><td align="right">'.$misi[10].'</td></tr>';
	$no--;
}
	$hasil .= '
					</tbody>
				</table>
			</div>
		</div>';
}else{
	$hasil .= '
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<b style="font-family:timesnewrman;font-size:18px;"> <i class=" fa fa-sitemap"></i> ['.$mtime.'] - Aktivitas  @<a href="https://t.me/'.$bottele.'" target="_New"><u>'.$bottele.'</u></a>
				</div>
				<center>BELUM ADA DATA PEMBUATAN VOUCHER YANG BISA DI TAMPILKAN...</b>➤ <i style="color:red;font-size:18px;" class="fa fa-circle-o-notch fa-spin"></i>	
			</div>
		</div>
	</div>
</div>
	';
}


print $hasil;
?>
