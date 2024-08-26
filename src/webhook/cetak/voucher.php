<html>
	<head>
		<title>kv<?=$_GET['kvoucher'];?></title>
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
table {
  display: inline-block;
  border: 4px solid black;
  border-radius:5px;
  margin: 2px;
  padding:4px;
}
  
td {vertical-align: top;
}
 
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
	<table style='font-family:times;max-width: 300px;'>
		<tr><td style='text-align:center;'><img src='lwifi.JPG' style='width:200px;height:100px;'></td></tr>
		<tr><td style='font-size:12px;text-align:center;'>Voucher WiFi</td></tr>
		<tr><td style='font-size:12px;text-align:center;'>Via <?=$_GET['bottele'];?></td></tr>
		<tr><td style='font-size:12px;text-align:center;'></td></tr>
		<tr><td><hr></td></tr>
		<tr><td style='font-size:14px;text-align:center;'>PAKET <?=$_GET['paket'];?></td></tr>
		<tr><td style='font-size:14px;text-align:center;'><?=$_GET['mhrg'];?></td></tr>
		<tr><td><hr></td></tr>
		<tr><td style='font-size:20px;text-align:center;'><b><?=$_GET['kvoucher'];?></b></td></tr>
		<tr><td><hr></td></tr>
		<tr><td style='font-size:10px;text-align:center;'><?=$_GET['mket'];?></td></tr>
	</table></center>
  </body>
</html>