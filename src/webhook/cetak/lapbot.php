<?php
$fdata		=$_GET['fdata'];
$idtele1	=$_GET['fisi'];
$natele1	=$_GET['natele'];

date_default_timezone_set('Asia/Jakarta');
include "../system.database.php";

if ($idtele1=="") {
	$mket="Lembar total tagihan.";
	$lfile="LapBot".date('d-m-Y');
}else{
	$mket="Lembar tagih untuk ID : ".$idtele1." ".$natele1;
	$lfile="LapBot".$idtele1.date('d-m-Y');
}
$mdata	= explode("#",cdatabot0($fdata,$idtele1));
$no=count($mdata)-1;
?>
<html>
	<head>
		<title>LapBot<?=$lfile;?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="pragma" content="no-cache" />
		<style>
body {
  color: #000000;
  background-color: #FFFFFF;
  font-family:  'TimesNewRoman',Helvetica, arial, sans-serif;
  margin: 5px;
  -webkit-print-color-adjust: exact;
}

posisi {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 12px;
}
table {
  display: inline-block;
  border: 0px solid black;
  margin-top: 5px;
  margin-right: 5px;
	border-collapse: collapse;
	width:700px;
}


td {vertical-align: middle;font-family:timesnewroman;font-size:16px;padding:5px;border: 0px solid black;
}

img {width:150px;height:80px;}
hr {border-top: 3px dashed black;} 

@page
{
  size: 210mmx297mm;
  margin-left: 15mm;
  margin-right: 5mm;
  margin-top: 15mm;
  margin-bottom: 15mm;
}
@media print
{
  table { page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
}
</style>
	</head>
  	 <body onload="window.print()">
		<?php		
			$no		=0;
			$item	=0;
			$bts	=16;
			$hal	=1;
			$titem	=count($mdata);
			if ($titem<17) {
				$lembar=1;
			}else{
				$lembar	=round(count($mdata)/$bts,0);
			}
			$tharga=0;
			$tmodal=0;
			for ( $i=0 ;$i < $lembar ; $i++) {
				echo "<table width='700px'><tr><td>";
				echo "<table width='auto'>";
				echo "<tr><td rowspan='2'><img src='lwifi.JPG'></td><td style='text-align:right;vertical-align:middle;font-size:48px;padding-left:20px;font-family:timesnewroman;font-style:bold;'>".$_GET['dns']." </td></tr>";
				echo "<tr><td align='right'><b>".$mket."</b></td><tr>";
				echo "</table>";
				echo "<br>";
				echo "<br>";
				echo "<table width='700px'>";
				echo "<tr><th style='text-align:right;'>No.</th>
					<th>TELEGRAM</th>
					<th> Jam/Tgl</th>
					<th align='center'>ROUTER</th>
					<th align='center'>PAKET</th>
					<th>VOUCHER</th>
					<th style='text-align:right;'> MODAL</th>
					<th style='text-align:right;'> HARGA</th>
					</tr>";
					for ($ii = 0 ; $ii<$bts ; $ii++) {
						
						$misi	= explode("|",$mdata[$item]);
						$item++;
						$no++;
						if ($idtele1==""){
							echo "<tr style='border-bottom: 1pt solid black;'><td align='right'>".$no.".</td><td>".$misi[0]."<br>".$misi[1]."</td><td>".$misi[2]."<br>".$misi[3]."</td><td align='center'>".$misi[4]."</td><td align='center'>".$misi[5]."<br>".$misi[10]."</td><td>".$misi[6]."</td><td style='text-align:right;'>".rupiah($misi[7])."</td><td style='text-align:right;'>".rupiah($misi[8])."</td></tr>";
						}
						if ($misi[0]==$idtele1) {
							echo "<tr style='border-bottom: 1pt solid black;'><td align='right'>".$no.".</td><td>".$misi[0]."<br>".$misi[1]."</td><td>".$misi[2]."<br>".$misi[3]."</td><td align='center'>".$misi[4]."</td><td align='center'>".$misi[5]."<br>".$misi[10]."</td><td>".$misi[6]."</td><td style='text-align:right;'>".rupiah($misi[7])."</td><td style='text-align:right;'>".rupiah($misi[8])."</td></tr>";
						}
						$tmodal	= $tmodal+$misi[7];
						$tharga = $tharga+$misi[8];
						if ($item>$titem-2){
							break;
						}
					}
					echo "<tr><td colspan='3'><i>".$lfile."</i></td><td align='center' colspan='3'>hal. ".$hal."/".$lembar."</td><td style='text-align:right;font-weight: bold;'>".rupiah($tmodal)."</td><td style='text-align:right;font-weight: bold;'>".rupiah($tharga)."</td></tr>";
					$hal++;
				echo "</table>";
				echo "</td><tr></table>";
			}
			
		?>
	</body>
</html>