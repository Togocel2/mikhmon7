<?php
date_default_timezone_set('Asia/Jakarta');
include "system.database.php";
$idtele=$_GET['idtele'];
$natele=$_GET['natele'];
$idbulan=$_GET['idbulan'];
$mtgl=date('d/m/Y');
$mtime=date('H:i:s');

if ($idtele=="") {$idtele="ID TELEGRAM";$idtele1='';}else{$idtele1=$idtele;}
if ($natele=="") {$natele="";$natele1='';}else{$natele1=$natele;}

if ($idbulan=="") {
	$idbulan="Bln-Thn";
	$idbulan1=date('m-Y');
	$fdtvcr	= "dt".substr($mtgl,3,2).substr($mtgl,6,4).".txt";
}else{
	$idbulan1=$idbulan;
	$fdtvcr	= "dt".substr($idbulan1,0,2).substr($idbulan1,3,4).".txt";
}
$mdata	= cdatabot2($fdtvcr);
$no=count($mdata);
$jvcr=0;
$tmodal=0;
$thjual=0;
for ($i = 0 ; $i < count($mdata)-1 ; $i++) {
	$misi	= explode("|",$mdata[$i]);
	if ($misi[0]==$idtele1) { 
		$jvcr++;
		$tmodal	= $tmodal+$misi[7];
		$thjual	= $thjual+$misi[8];
	}
	if ($idtele1=="") { 
		$jvcr++;
		$tmodal	= $tmodal+$misi[7];
		$thjual	= $thjual+$misi[8];
	}
}

$bottele=cbot1();
$mkos="";
?>

<div class="col-12">
	<div class="card">
		<div class="card-header">
			<b style="font-family:timesnewrman;font-size:18px;"> <i class=" fa fa-sitemap"></i> Aktivitas  Bot @<a href="https://t.me/<?= $bottele; ?>" target="_New"><?=$bottele;?></a>
			<u style="text-color:green;">[<?=$jvcr;?>-Vcr]</u>  di bulan  <?=$idbulan1;?> Total : <?=rupiah($thjual-$tmodal);?> | <?=rupiah($tmodal);?> | <?=rupiah($thjual);?></b>
		</div>
		<div class="card-body">
			<div class="col-6 pd-t-5 pd-b-5" > 
				<div class="input-group-3 col-box-6">
					<select style="padding:5px;" class="group-item group-item-m" onchange="location = this.value; loader()" title="Filter by ID TELEGRAM">
						<option align="center"><?=$idtele;?></option>
						<option value="./?hotspot=whreport&idtele=&idbulan1=<?=$idbulan1;?>&session=<?= $session; ?>">ALL-SEMUA</option>
						<?php
							$misi	= file_get_contents("./webhook/data/dtuser.txt");
							$mdat	= explode("#",$misi);
							for ($i = 0; $i < count($mdat)-1; $i++) {
								$profil  = explode("|",$mdat[$i]);
								$idtele = trim($profil[0]);
								$natele =$profil[1];
								echo "<option value='./?hotspot=whreport&idtele=".$idtele."&natele=".$natele."&idbulan=".$idbulan1."&session=".$session . "'>" . $idtele ." ".$natele." </option>";
							}
						?>
					</select> 
				</div>
				<div class="input-group-3 col-box-6">
					<select style="padding:5px;" class="group-item group-item-m" onchange="location = this.value; loader()" title="Filter by MONTH">
						<option align="center"><?=$idbulan;?></option>
						<?php
							$tgl	= date('d-M-Y');
							for ($i = 0; $i > -4; $i--) {
								$idbulan=manipulasiTanggal($tgl,$i,'months');
								$idbulanOK=manipulasiTanggal1($tgl,$i,'months');
								echo "<option value='./?hotspot=whreport&idtele=".$idtele1."&natele=".$natele1."&idbulan=".$idbulan."&session=".$session . "'>" . $idbulanOK." </option>";
							}
						?>
					</select> 
				</div>
			</div>
			<?php if ($jvcr>0 ) { ?><a href="./webhook/cetak/lapbot.php?fdata=../data/<?=$fdtvcr;?>&natele=<?=$natele1;?>&fisi=<?=$idtele1;?>&dns=<?=$session;?>" target="_NewBlank"><input  class="btn bg-blue" style="cursor: pointer;font-size:16px;font-family:timesnewroman;font-weight:bold;border-radius:5px green;" name="update1" value="Cetak Form"></a> <?php } ?>
			<div class="overflow box-bordered mr-t-10" style="max-height: 74vh">
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
					<tbody> 
<?php
$no=count($mdata)-2;
$noo="0";
for ($i = count($mdata)-2 ; $i > -1 ; $i--) {
	$misi	= explode("|",$mdata[$i]);
	if ($idtele1=="") {
		$noo="1";
		$no=$i+1;
		echo "<tr><td align='right'>".$no.".</td><td>".$misi[0]."/".$misi[1]."</td><td>".$misi[2]." ".$misi[3]."</td><td align='center'>".$misi[4]."</td><td align='center'>".$misi[5]."</td><td>".$misi[6]."</td><td align='right'>".rupiah($misi[7])."</td><td align='right'>".rupiah($misi[8])."</td><td align='right'>".$misi[10]."</td></tr>";
	}
	if ($misi[0]==$idtele1) {
		$noo="1";
		$no=$i+1;
		echo "<tr><td align='right'>".$no.".</td><td>".$misi[0]."/".$misi[1]."</td><td>".$misi[2]." ".$misi[3]."</td><td align='center'>".$misi[4]."</td><td align='center'>".$misi[5]."</td><td>".$misi[6]."</td><td align='right'>".rupiah($misi[7])."</td><td align='right'>".rupiah($misi[8])."</td><td align='right'>".$misi[10]."</td></tr>";
	}
}
if ($noo=="0") {
	if ($idtele1==""){
		$mket="<b>TIDAK ADA DATA YANG DITEMUKAN <br>UNTUK BULAN ".$idbulan1."</b>";
	}else{
		$mket="<b>TIDAK ADA DATA YANG DITEMUKAN UNTUK ID ".$idtele1." PADA BULAN ".$idbulan1."</b>";
	}
	echo "<tr><td colspan='9' align='center' style='color:blue;'>".$mket."</td></tr>";
}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>



