<?php
date_default_timezone_set('Asia/Makassar');

//include("whatsva.php");
include("./settings/system.config.php");

function apkbelivoucher($id, $usernamepelanggan, $princevoc, $markup, $username, $password, $uptime, $keterangan, $id_own) {
  global $mikbotamdata;
  $data = $mikbotamdata->get('re_settings', ['saldo', 'id_user'], ['id_user' => $id]);
  $saldoawal = $data["saldo"];
  if ($id == $id_own) {
    if (isset($data)) {
      $last_id = $mikbotamdata->insert('re_operating', [
        'id_user' => $id,
        'nama_seller' => $usernamepelanggan,
        'saldo_awal' => $saldoawal,
        'saldo_akhir' => $saldoawal,
        'beli_voucher' => $princevoc,
        'markup_voucher' => $markup,
        'username_voucher' => $username,
        'password_voucher' => $password,
        'exp_voucher' => $uptime,
        'keterangan' => $keterangan,
        'Waktu' => date('H:i:s'),
        'Tanggal' => date('Y-m-d'),
      ]);
    }
    $update = $mikbotamdata->update('re_settings', [
      'saldo[-]' => 0,
      'Waktu' => date('H:i:s'),
      'Tanggal' => date('Y-m-d'),
      'voucher_terjual[+]' => 1,
      'jumlah_debit_terjual[+]' => $princevoc,
    ], [
      'id_user' => $id,
    ]);
  } else {
    if (isset($data)) {
      $last_id = $mikbotamdata->insert('re_operating', [
        'id_user' => $id,
        'nama_seller' => $usernamepelanggan,
        'saldo_awal' => $saldoawal,
        'saldo_akhir' => $saldoawal - $princevoc + $markup,
        'beli_voucher' => $princevoc - $markup,
        'markup_voucher' => $markup,
        'username_voucher' => $username,
        'password_voucher' => $password,
        'exp_voucher' => $uptime,
        'keterangan' => $keterangan,
        'Waktu' => date('H:i:s'),
        'Tanggal' => date('Y-m-d'),
      ]);
    }
    $update = $mikbotamdata->update('re_settings', [
      'saldo[-]' => $princevoc - $markup,
      'Waktu' => date('H:i:s'),
      'Tanggal' => date('Y-m-d'),
      'voucher_terjual[+]' => 1,
      'jumlah_debit_terjual[+]' => $princevoc - $markup,
    ], [
      'id_user' => $id,
    ]);
  }
  if ($keterangan == 'Success') {
    $report = $mikbotamdata->insert('st_reportdata', [
      'id' => $id,
      'nama_user' => $usernamepelanggan,
      'harga' => $princevoc,
      'status' => $keterangan,
      'transaksi' => 'halo',
      'pendapatan' => $princevoc - $markup,
      'Waktu' => date('H:i:s'),
      'Tanggal' => date('Y-m-d'),
    ]);
  }
  return $update;
}

function apkdaftarr($id, $id1, $nama) {
  global $mikbotamdata;
  $test = $mikbotamdata->get('st_smsgateway', [
    '_id',
    'Token',
    'ipserver',
  ], [
    'Token' => $id1,
  ]);
  $tulis = "Selamat...\n\nID WA : ".$id1."\nNama : ".$nama."\n\n";
  if (empty($test['ipserver'])) {
    $data = $mikbotamdata->insert('st_smsgateway', [
      '_id' => $id,
      'Token' => $id1,
      'ipserver' => $nama,
    ]);
    $tulis .= "Telah masuk dalam data.\n\n";
  } else {
    $data = $mikbotamdata->update('st_smsgateway', [
      'ipserver' => $nama,
    ], [
      'Token' => $id1,
    ]);
    $tulis .= "Berhasil diupdate.\n\n";
  }
  $tulis .= "Terimakasih dan Selamat ".sapaan();
  return $tulis;
}

function lpelanggan($nomor) {
  global $mikbotamdata;
  $data = $mikbotamdata->select('st_smsgateway', [
    '_id',
    'Token',
    'ipserver',
  ], [
    '_id' => $nomor
  ], [
    'ORDER' => ['ipserver' => 'ASC']
  ]);
  return $data;
}
function cnpelanggan($idp) {
  global $mikbotamdata;
  $data = $mikbotamdata->get('st_smsgateway', [
    '_id',
    'Token',
    'ipserver',
  ], [
    'Token' => $idp
  ]);
  return $data;
}

function tdeposit($id, $name, $jumlah, $id_own) {
  global $mikbotamdata;
  $ceksaldoawal = $mikbotamdata->get('re_settings', [
    'nomer_tlp',
    'id_user',
    'saldo',
  ], [
    'nomer_tlp' => $id
  ]);

  $saldoawal = $ceksaldoawal["saldo"];

  $update = $mikbotamdata->update('re_settings', [

    'saldo' => $jumlah + $saldoawal,
    'Waktu' => date('H:i:s'),
    'Tanggal' => date('Y-m-d'),
  ], [
    'nomer_tlp' => $id,
  ]);
  if ($update == true) {
    $datacek = $mikbotamdata->get('re_settings', [
      'nomer_tlp',
      'id_user',
      'nama_seller',
      'saldo',
    ], [
      'nomer_tlp' => $id
    ]);

    $nama = $datacek["nama_seller"];
    $saldo = $datacek["saldo"];

    $hasil = $mikbotamdata->insert('re_operating', [
      'id_user' => $id,
      'nama_seller' => $nama,
      'saldo_awal' => $saldoawal,
      'saldo_akhir' => $saldo,
      'top_up' => $jumlah,
      'keterangan' => 'topup',
      'top_up_fromid' => $id_own,
      'Waktu' => date('H:i:s'),
      'Tanggal' => date('Y-m-d'),
    ]);
    //		$idowner = $mikbotamdata->select('st_mikbotam', [
    //			"Id_owner",
    //		]);

    $text = " Informasi TOP UP saldo\n";
    $text .= "==========================\n";
    $text .= "ID WA       : $id\n";
    $text .= "Username    : $nama\n";
    $text .= "Status      : Berhasil \n";
    $text .= "Nominal     : " . rupiah($jumlah) . " \n";
    $text .= "Saldo Awal  : " . rupiah($saldoawal) . " \n";
    $text .= "Saldo Akhir : " . rupiah($saldo) . " \n";
    $text .= "Outletid    : " . $id_own . "\n";
    $text .= "==========================\n";
  } else {
    $text = "Informasi TOP UP saldo\n";
    $text .= "==========================\n";
    $text .= "ID WA	 : $id\n";
    $text .= "Nama	 : @$nama\n";
    $text .= "Status : dtbase error\n";
    $text .= "==========================\n";
  }
  if ($jumlah < 0) {
    $jum = $jumlah*-1;
    $text .= "Deposit Anda telah dikurangi ".rupiah($jum)."\n";
  } else {
    $text .= "Deposit Anda telah ditambah ".rupiah($jum)."\n";
  }
  $error = $mikbotamdata->error();
  return $text;
}


function creseller($id) {
  global $mikbotamdata;
  $data = $mikbotamdata->get('re_settings', [
    'nomer_tlp',
    'nama_seller',
    'status',
    'voucher_terjual',
    'jumlah_debit_terjual',
    'saldo',
    'keterangan',
  ], [
    'id_user' => $id,
  ]);
  return $data;
}

function lreseller() {
  global $mikbotamdata;
  $data = $mikbotamdata->select('re_settings', [
    'nomer_tlp',
    'nama_seller',
    'status',
    'keterangan',
  ], [
    'ORDER' => ['nama_seller' => 'ASC']
  ]);
  return $data;
}
function cdata($nomor) {
  global $mikbotamdata;
  $data = $mikbotamdata->get('re_settings', [
    'nomer_tlp',
    'nama_seller',
    'status',
    'keterangan',
  ], [
    'id_user' => $nomor,
  ]);
  return $data;
}

function cakses($nomor) {
  global $mikbotamdata;
  $data = $mikbotamdata->get('re_settings', [
    'nomer_tlp',
    'status',
  ], [
    'nomer_tlp' => $nomor,
  ]);
  $data1 = $data['status'];
  return $data1;
}

function apkaktifasi($id, $mkey) {
  global $mikbotamdata;
  $data = $mikbotamdata->update('re_settings', [
    'status' => $mkey,
  ], [
    'id_user' => $id,
  ]);
  $tulis = "Nomor Anda behasil di Aktifasi ke system kami.\n\n";
  $tulis .= "Terimakasih dan Selamat ".sapaan();
  return $tulis;
}

function apkdaftar($id, $nama, $router, $mkey) {
  global $mikbotamdata;
  $test = $mikbotamdata->get('re_settings', [
    'nama_seller',
  ], [
    'id_user' => $id,
  ]);
  $tulis = "Selamat...\n\nID WA : ".$id."\nNama : ".$nama."\n\n";
  if (empty($test['nama_seller'])) {
    $data = $mikbotamdata->insert('re_settings', [
      'id_user' => $id,
      'nama_seller' => $nama,
      'saldo' => 0,
      'settings' => "0/1/2/3//5/6/7/8/9/A",
      'status' => $mkey,
      'voucher_terjual' => 0,
      'jumlah_debit_terjual' => 0,
      'keterangan' => $router,
      'Waktu' => date('H:i:s'),
      'Tanggal' => date('Y-m-d'),
    ]);
    if ($saldo<>0) {
      $tulis .= "Telah masuk dalam data.\nSelamat anda mendapatkan Saldo Awal ".rupiah($saldo)." GRATIS.\n\n";
    } else {
      $tulis .= "Telah masuk dalam data kami.\n\n";
    }
  } else {
    $data = $mikbotamdata->update('re_settings', [
      'nama_seller' => $nama,
      'status' => $mkey,
      'keterangan' => $router,
    ], [
      'id_user' => $id,
    ]);
    $tulis .= "Berhasil diupdate.\n\n";
  }
  $tulis .= "Terimakasih dan Selamat ".sapaan();
  return $tulis;
}

function nomor($xnomor) {
  if (substr($xnomor, 0, 1) == "0") {
    $xnomor = "62".substr($xnomor, 1, strlen($xnomor)-1);
  }
  return $xnomor;
}

function manipulasiTanggal($tgl, $jumlah = 1, $format = 'days') {
  $currentDate = $tgl;
  return date('m-Y', strtotime($jumlah.' '.$format, strtotime($currentDate)));
}
function manipulasiTanggal1($tgl, $jumlah = 1, $format = 'days') {
  $currentDate = $tgl;
  return date('M-Y', strtotime($jumlah.' '.$format, strtotime($currentDate)));
}
function manipulasiTanggal2($tgl, $jumlah = 1, $format = 'days') {
  $currentDate = $tgl;
  return date('d-M', strtotime($jumlah.' '.$format, strtotime($currentDate)));
}
function manipulasiTanggal3($tgl, $jumlah = 1, $format = 'days') {
  $currentDate = $tgl;
  return date('d/m/Y', strtotime($jumlah.' '.$format, strtotime($currentDate)));
}
function manipulasiTanggal4($tgl, $jumlah = 1, $format = 'days') {
  $currentDate = $tgl;
  return date('M/d/Y', strtotime($jumlah.' '.$format, strtotime($currentDate)));
}




function kuser($panjang) {
  $karakter = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $string = '';
  for ($i = 0; $i < $panjang; $i++) {
    $pos = rand(0, strlen($karakter)-1);
    $string .= $karakter {
      $pos
    };
  }
  $string = trim($string);
  return $string;
}

function rupiah($angka) {
  $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
  return $hasil_rupiah;
}

function cdatadt1($xfile, $xtele, $xtgl, $xprof) {
  $hasil = "";
  if (!file_exists($xfile)) {
    $hasil = "Penjualan bulan ".$xtgl.".\n\n<b>TIDAK DITEMUKAN.</b>\n";
  } else {
    $mdata = file_get_contents($xfile);
    $misi = explode("#", $mdata);
    if ($xtele == "") {
      $tvcr = 0;
      $hmodal = 0;
      $hjual = 0;
      $hasil = "Detail sales bulan ".$xtgl."\n";
      $hasil .= "<b>".$xprof."</b>\n";
      $hasil .= "=============================\n";
      $hasil .= "<b>PAKET</b>\n";
      $hasil .= " <b>QTY      HARGA-1   HARGA-2</b>\n";
      $hasil .= "---------------------------------------------------------";
      $paket = explode("*", cvoucher($xprof));
      for ($i = 1; $i < count($paket); $i++) {
        $paket0 = explode("|", $paket[$i]);
        $jvcr = 0;
        $hmodald = 0;
        $hjuald = 0;
        for ($ii = 0; $ii < count($misi); $ii++) {
          $misi1 = explode("|", $misi[$ii]);
          if (trim($paket0[0]) == trim($misi1[5])) {
            $jvcr++;
            $tvcr++;
            $hmodald = $hmodald+$misi1[7];
            $hjuald = $hjuald+$misi1[8];
            $hmodal = $hmodal+$misi1[7];
            $hjual = $hjual+$misi1[8];
          }
        }
        if ($tvcr<>0) {
          $hasil .= $paket0[0]."\n".$jvcr." Vcr.   ".rupiah($hmodald)."   ".rupiah($hjuald)."\n";
          $hasil .= "--------------------------------------------------------\n";
        }
      }
      $hasil .= "<b>Total Sales ".$xtgl."</b>\n";
      $hasil .= "<b>VOUCHER	".$tvcr." Lembar.</b>\n";
      $hasil .= "<b>".rupiah($hmodal)."   ".rupiah($hjual)."</b>\n";
    } else {
      $tvcr = 0;
      $hmodal = 0;
      $hjual = 0;
      $hasil = "Detail sales bulan ".$xtgl."\n";
      $hasil .= "<b>".$xtele."</b>\n";
      $hasil .= "<b>".$xprof."</b>\n";
      $hasil .= "=============================\n";
      $hasil .= "<b>PAKET</b>\n";
      $hasil .= " <b>QTY      HARGA-1   HARGA-2</b>\n";
      $hasil .= "---------------------------------------------------------";
      $paket = explode("*", cvoucher($xprof));
      for ($i = 1; $i < count($paket); $i++) {
        $paket0 = explode("|", $paket[$i]);
        $jvcr = 0;
        $hmodald = 0;
        $hjuald = 0;
        for ($ii = 0; $ii < count($misi); $ii++) {
          $misi1 = explode("|", $misi[$ii]);
          if (trim($paket0[0]) == trim($misi1[5])) {
            if ($xtele == $misi1[0]) {
              $jvcr++;
              $tvcr++;
              $hmodald = $hmodald+$misi1[7];
              $hjuald = $hjuald+$misi1[8];
              $hmodal = $hmodal+$misi1[7];
              $hjual = $hjual+$misi1[8];
            }
          }
        }
        if ($jvcr<>0) {
          $hasil .= $paket0[0]."\n".$jvcr." Vcr.   ".rupiah($hmodald)."   ".rupiah($hjuald)."\n";
          $hasil .= "--------------------------------------------------------\n";
        }
      }
      $hasil .= "<b>Total Sales ".$xtgl."</b>\n";
      $hasil .= "<b>VOUCHER	".$tvcr." Lembar.</b>\n";
      $hasil .= "<b>".rupiah($hmodal)."   ".rupiah($hjual)."</b>\n";
    }
  }
  return $hasil;
}

function cdatadt($xfile, $xtele, $xtgl, $xprof) {
  $hasil = "";
  if (!file_exists($xfile)) {
    $hasil = "File tidak ditemukan.#";
  } else {
    $mdata = file_get_contents($xfile);
    $misi = explode("#", $mdata);
    if ($xtele == "") {
      $no = 0;
      $hmodal = 0;
      $hjual = 0;
      $hasil = "Detail sales tanggal ".$xtgl."\n";
      $hasil .= "<b>".$xprof."</b>\n";
      $hasil .= "=============================\n";
      $hasil .= "  <b>ID TELE   VOUCHER       Aktif</b>\n";
      $hasil .= "---------------------------------------------------------";
      for ($i = 0; $i < count($misi); $i++) {
        $misi1 = explode("|", $misi[$i]);
        if ($misi1[2] == $xtgl) {
          $no++;
          $hmodal = $hmodal+$misi1[7];
          $hjual = $hjual+$misi1[8];
          $hasil .= $misi1[0]." ".trim($misi1[6])." ".$misi1[9]."";
        }
      }
      if ($no<>0) {
        $hasil .= "\n=============================\n";
        $hasil .= " Total ".$no." Vcr.\n";
        $hasil .= " Hrg Awal ".rupiah($hmodal)."\n";
        $hasil .= " Hrg  Jual ".rupiah($hjual)."\n";
        $hasil .= "============================= \n";
      }
      $paket = explode("*", cvoucher($xprof));
      for ($i = 1; $i < count($paket); $i++) {
        $paket0 = explode("|", $paket[$i]);
        $jvcr = 0;
        $hmodald = 0;
        $hjuald = 0;
        for ($ii = 0; $ii < count($misi); $ii++) {
          $misi1 = explode("|", $misi[$ii]);
          if ($misi1[2] == $xtgl) {
            if (trim($paket0[0]) == trim($misi1[5])) {
              $jvcr++;
              $hmodald = $hmodald+$misi1[7];
              $hjuald = $hjuald+$misi1[8];
            }
          }
        }
        if ($jvcr<>0) {
          $hasil .= $paket0[0]."\n".$jvcr." Vcr.   ".rupiah($hmodald)."   ".rupiah($hjuald)."\n";
          $hasil .= "--------------------------------------------------------\n";
        }
      }
      if ($no == 0) {
        $hasil .= "<b>Tidak ada penjualan</b>\n";
      } else {
        $hasil .= $no." Vcr.   ".rupiah($hmodal)."   ".rupiah($hjual)."\n";

      }
    } else {
      $no = 0;
      $hmodal = 0;
      $hjual = 0;
      $hasil = "=============================\n";
      $hasil .= "   <b>JAM    VOUCHER       Aktif</b>\n";
      $hasil .= "----------------------------------------------------------\n";
      for ($i = 0; $i < count($misi); $i++) {
        $misi1 = explode("|", $misi[$i]);
        if ($misi1[2] == $xtgl) {
          if ($misi1[0] == $xtele) {
            $no++;
            $hmodal = $hmodal+$misi1[7];
            $hjual = $hjual+$misi1[8];
            $hasil .= $misi1[3]." ".trim($misi1[6])."  ".$misi1[10]."\n";
          }
        }
      }
      if ($no<>0) {
        $hasil .= "=============================\n";
        $hasil .= " Total ".$no." Vcr.\n";
        $hasil .= " Hrg Awal ".rupiah($hmodal)."\n";
        $hasil .= " Hrg  Jual ".rupiah($hjual)."\n";
        $hasil .= "============================= \n";
      }
      $paket = explode("*", cvoucher($xprof));
      for ($i = 1; $i < count($paket); $i++) {
        $paket0 = explode("|", $paket[$i]);
        $jvcr = 0;
        $hmodald = 0;
        $hjuald = 0;
        for ($ii = 0; $ii < count($misi); $ii++) {
          $misi1 = explode("|", $misi[$ii]);
          if ($misi1[2] == $xtgl) {
            if (trim($paket0[0]) == trim($misi1[5])) {
              if ($misi1[2] == $xtgl) {
                if ($misi1[0] == $xtele) {
                  $jvcr++;
                  $hmodald = $hmodald+$misi1[7];
                  $hjuald = $hjuald+$misi1[8];
                }
              }
            }
          }
        }
        if ($jvcr<>0) {
          $hasil .= $paket0[0]."\n".$jvcr." Vcr.   ".rupiah($hmodald)."   ".rupiah($hjuald)."\n";
          $hasil .= "--------------------------------------------------------\n";
          $hasil .= " TOTAL :\n";
          $hasil .= $no." Vcr.   ".rupiah($hmodal)."   ".rupiah($hjual)."\n";
        }
      }
      if ($jvcr == 0) {
        $hasil .= "<b>Tidak ada penjualan</b>\n";
      }
    }
  }
  return $hasil;
}

function cdatadt0($xfile, $xtele, $xtgl, $xprof) {
  $hasil = "";
  if (!file_exists($xfile)) {
    $hasil = "File tidak ditemukan.#";
  } else {
    $mdata = file_get_contents($xfile);
    $misi = explode("#", $mdata);
    if ($xtele == "") {
      $no = 1;
      for ($i = 0; $i < count($misi); $i++) {
        $misi1 = explode("|", $misi[$i]);
        if ($misi1[2] == $xtgl) {
          //					$hasil .=$misi[$i]."#";
          $hasil .= $misi1[0]." ".trim($misi1[6])." ".$misi1[9]." ";
          $no++;
        }
      }
      $paket = explode("*", cvoucher($xprof));
      for ($i = 1; $i < count($paket); $i++) {
        $paket0 = explode("|", $paket[$i]);

        $hasil .= $paket0[0]." ";
      }
    } else {
      $hasil .= "User Belum#";
    }
  }
  return $hasil;
}
function cdatabot0($xfile, $xtele) {
  if (!file_exists($xfile)) {
    $hasil = "File||Tidak||Ada||||||#";
  } else {
    $mdata = file_get_contents($xfile);
    $misi = explode("#", $mdata);
    if ($xtele == "") {
      $hasil = $mdata;
    } else {
      $hasil = "";
      for ($i = 0; $i < count($misi)-1; $i++) {
        $misi1 = explode("|", $misi[$i]);
        if ($misi1[0] == $xtele) {
          $hasil .= $misi[$i]."#";
        }
      }
    }
  }
  return $hasil;
}



function setwebhook($urlpath, $token) {
  $url = "https://api.telegram.org/bot".$token."/setWebhook";

  $ch = curl_init($url);
  $post_data = [
    "url" => $urlpath,
  ];

  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $result = curl_exec($ch);
  return $result;
}

function unssetwebhook($token) {
  $url = file_get_contents("https://api.telegram.org/bot".$token."/setWebhook");

  return $url;
}

function getWebhookInfo($token) {
  $url = file_get_contents("https://api.telegram.org/bot".$token."/getWebhookInfo");

  return $url;
}

function info() {
  $getdata = file_get_contents('https://download.mikbotam.net/scari.php?Runing');
  echo $getdata;
}

function Version() {
  $getdata = file_get_contents('https://download.mikbotam.net/scari.php?Version');
  echo $getdata;
}

function sendMessage($id, $text, $token) {
  $website = "https://api.telegram.org/bot" . $token;
  $params = [
    'chat_id' => $id,
    'text' => $text,
    'parse_mode' => 'html',
  ];
  $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function cbulan($xbulan, $hari) {
  $xket = substr($xbulan, 0, 3);
  if ($xket == "jan") {
    $mket = "01";
  } elseif ($xket == "feb") {
    $mket = "02";
  } elseif ($xket == "mar") {
    $mket = "03";
  } elseif ($xket == "apr") {
    $mket = "04";
  } elseif ($xket == "mei") {
    $mket = "05";
  } elseif ($xket == "jun") {
    $mket = "06";
  } elseif ($xket == "jul") {
    $mket = "07";
  } elseif ($xket == "agu") {
    $mket = "08";
  } elseif ($xket == "sep") {
    $mket = "09";
  } elseif ($xket == "oct") {
    $mket = "10";
  } elseif ($xket == "nov") {
    $mket = "11";
  } elseif ($xket == "dec") {
    $mket = "12";
  }
  $xtgl1 = date('m/d/Y');
  $xtgl = $xtgl1;
  $xbulan = $mket.substr($xbulan, 3, 8);
  $msel = strtotime($xtgl)-strtotime($xbulan);
  if ($msel < 1) {
    $ket = "Ganti Tanggal commnet,tambah sales di scrip";
    $rub = "1";
  } else {
    $ket = "Buat Vucher Baru";
    $rub = "0";
  }
  return $xbulan;
}

function sapaan() {
  $jam0 = date('H');
  if ($jam0 > 4 and $jam0 < 9) {
    $jam1 = 'Pagi';
  } elseif ($jam0 > 8 and $jam0 < 14) {
    $jam1 = 'Siang';
  } elseif ($jam0 > 13 and $jam0 < 19) {
    $jam1 = 'Sore';
  } else {
    $jam1 = 'Malam';
  }
  return $jam1;
}

function sapaan1() {
  $jam0 = date(H);
  if ($jam0 > 4 and $jam0 < 9) {
    $jam1 = 'Semoga di pagi hari ini kita diberikan kesehatan dan rejeki yang berlimpah.  Amiiin.';
  } elseif ($jam0 > 8 and $jam0 < 14) {
    $jam1 = 'Jangan melupakan makan siang, silahkan untuk mengunjungi tempat makan terdekat. Xixixixixi.';
  } elseif ($jam0 > 13 and $jam0 < 19) {
    $jam1 = 'Ada yang bisa saya bantu.?';
  } else {
    $jam1 = 'Ada yang bisa saya bantu.?';
  }
  return $jam1;
}

function kirimwa($tujuan, $pesan) {
  $whatsva = new Whatsva();
  $instance_key = capiwa();
  $jid = $tujuan;
  $message = $pesan;
  $sendMessage = $whatsva->sendMessageText($instance_key, $jid, $message);
  return $sendMessage;
}

function kirimwa1($tujuan, $pesan) {
  $whatsva = new Whatsva();
  $instance_key = "HPnuBKlBk3Qf";
  $jid = $tujuan;
  $message = $pesan;
  $imageUrl = "https://interhome.wifikonekter.us/webhook/img/logobot1.png";
  $sendMessage = $whatsva->sendImageUrl($instance_key, $jid, $imageUrl, $message);
  return $sendMessage;
}

function apkkirimwa($tujuan, $pesan) {
  $whatsva = new Whatsva();
  $instance_key = apkcapiwa();
  $jid = $tujuan;
  $message = $pesan;
  $sendMessage = $whatsva->sendMessageText($instance_key, $jid, $message);
  return $sendMessage;
}

function apkkirimwa1($tujuan, $pesan) {
  $whatsva = new Whatsva();
  $instance_key = apkcapiwa();
  $jid = $tujuan;
  $message = $pesan;
  $imageUrl = "https://interhome.wifikonekter.us/webhook/img/logobot1.png";
  $sendMessage = $whatsva->sendImageUrl($instance_key, $jid, $imageUrl, $message);
  return $sendMessage;
}

function dtidwa($dt) {
  $mfile = "../webhook/idwa.txt";
  if (file_exists($mfile)) {
    $isi = explode("|", file_get_contents($mfile));
    $data = $isi[$dt];
  } else {
    $data = "";
  }
  return $data;
}



function rappkirimwa($nomor, $pesan) {
  $nomor = nomor($nomor);
  $pesan1 = str_replace(" ", "%20", $pesan);
  $pesan2 = str_replace("\n", "%0A", $pesan1);
  $isipesan = str_replace("\n", "%0A", $pesan2);
  $kirim = "http://47.88.55.194:3000/send/$nomor@c.us/$pesan1";
  $respone = file_get_contents($kirim);
  return $respone;
}

function kirimtele($pesan) {
  $token = '5982153422:AAEmm0WJ_XvSHq-tJaCPqxyPBYU1KpPlmRs';
  $website = "https://api.telegram.org/bot" . $token;
  $params = [

    'chat_id' => '5337580581',
    'text' => $pesan,
    'parse_mode' => 'html',
  ];
  $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function penyebut($nilai) {
  $nilai = abs($nilai);
  $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($nilai < 12) {
    $temp = " ". $huruf[$nilai];
  } else if ($nilai < 20) {
    $temp = penyebut($nilai - 10). " belas";
  } else if ($nilai < 100) {
    $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
  } else if ($nilai < 200) {
    $temp = " seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
    $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
    $temp = " seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
    $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
    $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
    $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
  } else if ($nilai < 1000000000000000) {
    $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
  }
  return $temp;
}

function terbilang($nilai) {
  if ($nilai < 0) {
    $hasil = "minus ". trim(penyebut($nilai));
  } else {
    $hasil = trim(penyebut($nilai));
  }
  return $hasil;
}

function kirimwaid($tujuan, $pesan) {
  $logo = 'https://interhome.wifikonekter.us/webhook/img/logobot1.png';
  try {
    $reqParams = [
      'url' => 'https://api.kirimwa.id/v1/messages',
      'method' => 'POST',
      'payload' => json_encode([
        'message' => $logo,
        'caption' => $pesan,
        'phone_number' => $tujuan,
        'message_type' => 'image',
        'device_id' => 'redme5a'
      ])
    ];
    $response = apiKirimWaRequest($reqParams);
    echo $response['body'];
  } catch (Exception $e) {
    print_r($e);
  }
}

function apiKirimWaRequest(array $params) {
  $httpStreamOptions = [
    'method' => $params['method'] ?? 'GET',
    'header' => [
      'Content-Type: application/json',
      'Authorization: Bearer ' . ('API WA' ?? '')
    ],
    'timeout' => 15,
    'ignore_errors' => true
  ];

  if ($httpStreamOptions['method'] === 'POST') {
    $httpStreamOptions['header'][] = sprintf('Content-Length: %d', strlen($params['payload'] ?? ''));
    $httpStreamOptions['content'] = $params['payload'];
  }

  // Join the headers using CRLF
  $httpStreamOptions['header'] = implode("\r\n", $httpStreamOptions['header']) . "\r\n";

  $stream = stream_context_create(['http' => $httpStreamOptions]);
  $response = file_get_contents($params['url'], false, $stream);

  // Headers response are created magically and injected into
  // variable named $http_response_header
  $httpStatus = $http_response_header[0];

  preg_match('#HTTP/[\d\.]+\s(\d{3})#i', $httpStatus, $matches);

  if (! isset($matches[1])) {
    throw new Exception('Can not fetch HTTP response header.');
  }

  $statusCode = (int)$matches[1];
  if ($statusCode >= 200 && $statusCode < 300) {
    return ['body' => $response,
      'statusCode' => $statusCode,
      'headers' => $http_response_header];
  }

  throw new Exception($response, $statusCode);
}

?>