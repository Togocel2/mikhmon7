<?php
date_default_timezone_set('Asia/Jakarta');
$data0=$_GET['dtcetak'];
$mpaket=explode('#',$data0);
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
  margin: 0px;
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
  width:165px;
}
  
td {vertical-align: top;font-family:timesnewroman;font-size:16px;padding:1px;text-align:center;
}
 
@page
{
  size: 210mmx297mm;
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
 	<body onload="window.print()">
	<?php
	$mvoucher=explode("#",$data0);
	$no=0;

	for ($i = 0 ; $i < count($mvoucher)-1; $i++) {
		$no=$i+1;
		$mdetail=explode("|",$mvoucher[$i]);
		echo "<table>";
		echo "<tr><td>$no</td><td align='center'>$mdetail[0]</td></tr>";
		echo "<tr><td colspan='2' text-align='center'><b style='font-size:18px;'>$mdetail[1]<b></td></tr>";
		echo "<tr><td colspan='2' text-align='center'> $mdetail[2]/$mdetail[3]</td></tr>";
		echo "</table>";
	}
	?>
  </body>
</html>
