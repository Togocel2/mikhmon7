<?php
date_default_timezone_set('Asia/Jakarta');
$data0=$_GET['dtcetak'];
$mpaket=explode('*',$data0);
$nfile=$_GET['mfile'];
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
  padding:10px;
  -webkit-print-color-adjust: exact;
}

posisi {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 14px;
  text-decoration: none;
}

table {
  display: inline-block;
  border: 2px solid black;
  border-radius:5p;
  margin-top: 5px;
  margin-right: 5px;
  padding:2px;
  }

th {
  border: 3px solid black;
	
}
td {
  border: 0px solid black;
	vertical-align: middle;
	font-family:timesnewroman;
	padding:1px;  
}

 
@page
{
  size: 210mmx297mm;
  margin-left: 8mm;
  margin-right: 5mm;
  margin-top: 20mm;
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
			$no=1;
			for ($i = 0 ; $i < count($mpaket)-1; $i++) {
				$no=$i+1;
				$mdetail=explode("|",$mpaket[$i]);

				$Color="#e60000";
				$url  		= "https://$mdetail[0]/login?username=$mdetail[2]&password=$mdetail[2]";
//				$qrcode     = 'http://qrickit.com/api/qr.php?d=' . urlencode($url) . '&addtext=' . urlencode($mdetail[0]) . '&txtcolor=000000&fgdcolor=' . $Color . '&bgdcolor=FFFFFF&qrsize=100';
				$qrcode     = 'http://qrickit.com/api/qr.php?d=' . urlencode($url) . '&addtext=' . urlencode($mdetail[0]) . '&txtcolor=#e60000&fgdcolor=' . $Color . '&bgdcolor=#e60000&qrsize=150';

				echo "<table>";
				echo "<tr><td colspan='2' align='left'><img src ='wifi1.jpg' width = '30p'><b style='font-size:18px;text-align:center;'>".$mdetail[0]."</b></td><td rowspan='4' width='90px'><img src=$qrcode width='90px'></td></tr>";
				echo "<tr><td colspan='2' align='center'><i style='font-size:12px;'>kode voucher</i></td></tr>";
				echo "<tr><td width='125px' colspan='2' align='center' ><b style='font-size:14px;color:blue;'>".$mdetail[2]."</b></td></tr>";
				echo "<tr><td colspan='2' align='center'><b style='font-size:12px;'>".$mdetail[3]."</b></td></tr>";
				echo "</table>";
				$no++;
			}
		?>
  </body>
</html>
