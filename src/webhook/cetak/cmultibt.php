<?php
date_default_timezone_set('Asia/Jakarta');
$data0=$_GET['dtcetak'];
$mpaket=explode('*',$data0);
$nfile=$_GET['mfile'];
$bottele=$_GET['bot'];
?>
<html>
	<head>
		<title><?php echo $nfile;?></title>  
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
  border: 1px solid black;
  margin-top: 5px;
  margin-right: 5px;
}
  
td {vertical-align: middle;font-family:timesnewroman;padding:1px;text-align:center;font-weight:bold;
}

img {width :45; }
 
@page
{
  size: 56mmx100mm;
  margin-left: 5mm;
  margin-right: 3mm;
  margin-top: 9mm;
  margin-bottom: 3mm;
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
  	<body onload="window.print()"><center>
		<?php
			$no=1;
			for ($i = 0 ; $i < count($mpaket)-1; $i++) {
				$no=$i+1;
				$mdetail=explode("|",$mpaket[$i]);
//style="font-weight:bold"
				echo "<table style='font-family:times;max-width: 300px;'>";
					echo "<tr><td '><img src='lwifi.JPG' style='width:275px;height:135px;'></td></tr>";
					echo "<tr><td style='font-size:22px;'>".trim($mdetail[0])."</td></tr>";
					echo "<tr><td style='font-size:18px;'>Via ".$bottele."</td></tr>";
					echo "<tr><td><hr></td></tr>";
					echo "<tr><td style='font-size:24px;'>".trim($mdetail[2])."</td></tr>";
					echo "<tr><td><hr></td></tr>";
					echo "<tr><td style='font-size:20px;text-align:center;'>".$mdetail[1]."</td></tr>";
					echo "<tr><td style ='font-size:18px;'>".$mdetail[3]." / ".$mdetail[4]."</td></tr>";
					echo "<tr><td style ='font-size:18px;'>".$no."</td></tr>";
					echo "<tr><td><hr></td></tr>";
					echo "<tr><td style ='font-size:18px;'>http://".trim($mdetail[0])."/login</td></tr>";
					echo "<tr><td style ='font-size:18px; text-align:center;'>Terimakasih.</td></tr>";
				echo "</table>";
				$no++;
			}
		?>
  </center></body>
</html>

