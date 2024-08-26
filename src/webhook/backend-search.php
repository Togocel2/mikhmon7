<?php
require_once 'system.database.php';
if(isset($_REQUEST["term"])){
	$cari=$_REQUEST["term"];
	$nowa=dtidwa(0);
	if ($nowa==$_COOKIE['nomor'])  {
		$data=lreseller();
		if (count($data)<>0) {
			$it=0;
			echo "<table width='100%' style='background:#2d8659;padding:10px;border-radius:5px;'>";
			for ($i=0 ; $i<count($data) ; $i++) {
				$isi=$data[$i];
				$pk=strlen($isi['nama_seller']);
				$pk1=strlen($cari);
				for ($a = 0; $a < $pk; $a++) {
					$cari1=substr($isi['nama_seller'],$a,$pk1);
					if (strtoupper($cari)==strtoupper($cari1)) {
						if ($it<10) {
							echo "<tr>
							<td style='font-size:16px;'><a href='?apk=13&mnomor=".$isi['id_user']."'>" . $isi['nama_seller'] ."</a></td>
							<td style='font-size:16px;'><a href='?apk=111&mnomor=".$isi['id_user']."'>".$isi['id_user']." [".$isi['type']."]</td>
							</tr>";
							$a=$pk;
						}
						$it++;
					}
				}
			}
			$ket="[ Nama -> Detail / Nomor -> +Saldo]";
			if ($it==0) {$ket="Data tidak ditemukan.";}
			echo "<tr><td colspan='2' style='background:black;color:white;border-radius:3px;text-align:center;font-size:14px;'>".$ket."</td></tr>";
			echo "</table>";
		}else{
			echo "Tidak ada item ini.";
		}
	}else{
		$data=lpelanggan();
		if (count($data)<>0) {
			$it=0;
			echo "<table width='100%' style='background:#2d8659;padding:10px;border-radius:5px;'>";
			for ($i=0 ; $i<count($data) ; $i++) {
				$isi=$data[$i];
				$pk=strlen($isi['Token']);
				$pk1=strlen($cari);
				for ($a = 0; $a < $pk; $a++) {
					$cari1=substr($isi['Token'],$a,$pk1);
					if (strtoupper($cari)==strtoupper($cari1)) {
						if ($it<10) {
							$nohp=explode("-",$isi['_id']);
							echo "<tr>
							<td style='font-size:16px;'><a href='?apk=3&mnomor=".$nohp[1]."'>".$nohp[1]."</a></td>
							<td style='font-size:16px;'><a href='?apk=3&mnomor=".$nohp[1]."'>".$isi['Token']."</td>
							</tr>";
							$a=$pk;
						}
						$it++;
					}
				}
			}
			$ket="[ Nama -> Detail / Nomor -> +Saldo]";
			if ($it==0) {$ket="Data tidak ditemukan.";}
			echo "<tr><td colspan='2' align='center' style='font-size:12px;'>".$ket."</td></tr>";
			echo "</table>";
		}else{
			echo "Tidak ada item ini.";
		}	
	}
}   
?>