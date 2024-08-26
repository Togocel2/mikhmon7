<?php
date_default_timezone_set('Asia/Makassar');
include 'src/FrameBot.php';
require_once 'system.database.php';
$filex = '../webhook/webhookk.php';
if (file_exists($filex)) {
  $misi = file_get_contents("$filex");
  $misi0 = explode("|", $misi);
  $id_own = $misi0[0];
  $namatele = $misi0[1];
  $bottele = $misi0[2];
  $tokentele = $misi0[3];
}
$mkbot = new FrameBot($tokentele, $bottele);
require_once '../lib/formatbytesbites.php';
require_once '../lib/routeros_api.class.php';

$scheme = $_SERVER['REQUEST_SCHEME'];
if (strpos(strtolower($scheme), 'http') !== false) {
  $cekhttps = "https://";
} else {
  $cekhttps = $scheme."://";
}


$mkbot->cmd('/start1|/Start1', function () {
  Bot::sendChatAction('typing');
  $info = bot::message();
  $msgid = $info['message_id'];
  $ntele = $info['from']['username'];
  $idtele = $info['from']['id'];
  $nama = $info['from']['first_name']." ".$info['from']['last_name'];
  $option = ['chat_id' => $idtele, 'parse_mode' => 'html', 'reply' => false];

  $text = "Selamat ".sapaan()."\n\nCommand Button Diaktifkan,.\n\nSilahkan Klik Tombol paling bawah yang bertuliskan <b>!Mulai</b> untuk transaksi selanjutnya.";
  $keyboard = [['!Mulai'],];
  $replyMarkup = ['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true];
  $options = ['parse_mode' => 'html', 'reply' => false, 'reply_markup' => json_encode($replyMarkup),];
  Bot::sendMessage($text, $options);
});

$mkbot->cmd('/help|*', function () {
  Bot::sendChatAction('typing');
  $info = bot::message();
  $msgid = $info['message_id'];
  $ntele = $info['from']['username'];
  $idtele = $info['from']['id'];
  $nama = $info['from']['first_name']." ".$info['from']['last_name'];
  $option = ['chat_id' => $idtele, 'parse_mode' => 'html', 'reply' => false];

  $text = "<i>Selamat ".sapaan()." ".$nama."</i>\n\n";
  $text .= "<b>Daftar perintah manual.</b>\n\n";
  $text .= "Layanan bot ini di Integrasikan dengan Aplikasi Mikhmon V3.20\n\n";
  $text .= "/Cek Cek Vuocher.\n";
  $text .= "/Hosting Cek Hosting.\n";
  $text .= "\n";
  $text .= "Untuk menggunakan Bot ini silahkan klik tombol  ☰ Menu yang berada di pojok kiri bawah.\n\nTerimakasih dan Selamat ".sapaan();
  $pesan = "Selamat ".sapaan()." ".$nama;
  $logo = "https://interhome.wifikonekter.us/webhook/img/logobot1.png";
  $opti = [
    'caption' => $pesan,
    'chat_id' => $idtele,
    'photo' => $logo,
    'parse_mode' => 'html',
  ];
  Bot::sendPhoto($pesan, $opti);
  Bot::sendMessage($text, $option);
});

$mkbot->cmd('/Hosting|/hosting|', function ($mkode) {
  Bot::sendChatAction('typing');
  $info = bot::message();
  $msgid = $info['message_id'];
  $ntele = $info['from']['username'];
  $idtele = $info['from']['id'];
  $nama = $info['from']['first_name']." ".$info['from']['last_name'];
  $option = ['chat_id' => $idtele, 'parse_mode' => 'html', 'reply' => false];

  $scheme = $_SERVER['REQUEST_SCHEME'];
  $urltele = $cekhttps.$_SERVER['HTTP_HOST']."/ \n";

  $text = "<i>Selamat ".sapaan()." ".$nama."</i>\n\n";
  $text .= "<u><b>Hosting</b></u>\n";
  $text .= "Protocol : ".$scheme."\n";
  $text .= "Url : ".$urltele."\n";
  $text .= "Terimakasih dan Selamat ".sapaan();
  $pesan = "Selamat ".sapaan()." ".$nama;
  $logo = "https://interhome.wifikonekter.us/webhook/img/logobot1.png";
  $opti = [
    'caption' => $pesan,
    'chat_id' => $idtele,
    'photo' => $logo,
    'parse_mode' => 'html',
  ];
  Bot::sendPhoto($pesan, $opti);
  Bot::sendMessage($text, $option);

});

$mkbot->cmd('/cek|/Cek|', function ($mkode) {
  Bot::sendChatAction('typing');
  $info = bot::message();
  $msgid = $info['message_id'];
  $ntele = $info['from']['username'];
  $idtele = $info['from']['id'];
  $nama = $info['from']['first_name']." ".$info['from']['last_name'];

  $pesan = "Selamat ".sapaan()." ".$nama;
  $logo = "https://interhome.wifikonekter.us/webhook/img/logobot1.png";
  $opti = [
    'caption' => $pesan,
    'chat_id' => $idtele,
    'photo' => $logo,
    'parse_mode' => 'html',
  ];
  Bot::sendPhoto($pesan, $opti);
  if (empty($mkode) == "T") {
    $option = ['chat_id' => $idtele,
      'parse_mode' => 'html',
      'reply' => false];

    $text = "<i>Selamat ".sapaan()." ".$nama."</i>\n\n";
    $text .= "Gunakan Perintah \n";
    $text .= "<b>/cek diikiti kode voucher yang akan di cek.</b>\nContoh :\n";
    $text .= "/cek (spaci) 6H12345\n";

    Bot::sendMessage($text, $option);
  } else {
    $drouter = crouter();
    $idrouter = explode("!", $drouter);
    $send = [];
    $no = 1;
    for ($i = 0; $i < count($idrouter)-1; $i++) {
      $mrouter = $idrouter[$i];
      $router = explode("|", $mrouter);
      $ {
        'tombol' . $i
      } = ['text' => '📚  '.$no.'. '.strtoupper($router[0]).'  📚',
        'callback_data' => 'CekVoucher|'.$mkode.'|'.$router[1].'|'];
      $no++;
    }
    $menu_idawal = [['text' => 'Cek '.$mkode,
      'callback_data' => 'Krouter'],
    ];
    $trouter1 = array_filter([$tombol0]);
    $trouter2 = array_filter([$tombol1]);
    $trouter3 = array_filter([$tombol2]);
    $trouter4 = array_filter([$tombol3]);
    $menu_idakhir = [['text' => ' Pilih Router',
      'callback_data' => '12'],
    ];

    array_push($send, $trouter1);
    array_push($send, $trouter2);
    array_push($send, $trouter3);
    array_push($send, $trouter4);
    array_push($send, $menu_idakhir);
    $text = "Silahkan Pilih Router Di Bawah Ini, untuk cek status kode :\n\nVoucher ".$mkode;
    $options = [
      'reply_markup' => json_encode(['inline_keyboard' => $send]),
      'parse_mode' => 'html',
      'reply' => false,
    ];
    Bot::sendMessage($text, $options);
  }
});

$mkbot->cmd('/Start|/start|!Mulai|', function () {
  Bot::sendChatAction('typing');
  $info = bot::message();
  $msgid = $info['message_id'];
  $ntele = $info['from']['username'];
  $idtele = $info['from']['id'];
  $nama = $info['from']['first_name']." ".$info['from']['last_name'];
  $daftar = catat($idtele, $ntele, $nama);
  $drouter = crouter();
  $idrouter = explode("!", $drouter);
  $cari = explode("|", webhookk());
  $send = [];
  $no = 1;
  for ($i = 0; $i < count($idrouter)-1; $i++) {
    $mrouter = $idrouter[$i];
    $router = explode("|", $mrouter);
    $ {
      'tombol' . $i
    } = ['text' => '📚  '.$no.'. '.strtoupper($router[0]).'  📚',
      'callback_data' => 'Pilih|'.$router[0].'|'.$router[1].'|'.$router[2].'|'.$router[3].'|'];
    $no++;
  }
  $menu_idawal = [['text' => ' Pilihan Router ',
    'callback_data' => 'Brouter'],
  ];
  $trouter1 = array_filter([$tombol0]);
  $trouter2 = array_filter([$tombol1]);
  $trouter3 = array_filter([$tombol2]);
  $trouter4 = array_filter([$tombol3]);
  $menu_idakhir = [['text' => $i.' Router Tersedia',
    'callback_data' => 'Krouter'],
  ];
  $menu_update = [['text' => '👌  Update Data Bot  👌',
    'callback_data' => 'Update||'],
  ];
  array_push($send, $menu_idawal);
  array_push($send, $trouter1);
  array_push($send, $trouter2);
  array_push($send, $trouter3);
  array_push($send, $trouter4);
  array_push($send, $menu_idakhir);

  $text = "Silahkan Pilih Router Di Bawah Ini, Sebelum Melakukan Transaksi..";
  $scheme = $_SERVER['REQUEST_SCHEME'];
  $urltele = $cekhttps.$_SERVER['HTTP_HOST']."/ \n";

  if ($idtele == $cari[0]) {
    array_push($send, $menu_update);
    $text .= "\n\n".$urltele."\n";
  }
  $options = [
    'reply_markup' => json_encode(['inline_keyboard' => $send]),
    'parse_mode' => 'html',
    'reply' => false,
  ];
  $pesan = "Selamat ".sapaan()." ".$nama;
  $logo = "https://interhome.wifikonekter.us/webhook/img/logobot1.png";
  $opti = [
    'caption' => $pesan,
    'chat_id' => $idtele,
    'photo' => $logo,
    'parse_mode' => 'html',
  ];
  Bot::sendPhoto($pesan, $opti);
  Bot::sendMessage($text, $options);
  if ($daftar == "1") {
    $option = ['chat_id' => $cari[0],
      'parse_mode' => 'html',
      'reply' => false];
    $text = "<i>Selamat ".sapaan()." ".$cari[1]."</i>\n\n";
    $text .= "<b>Ada pengguna baru.</b>\n";
    $text .= "=============================\n";
    $text .= "Id.   :".$idtele."\n";
    $text .= "User. : @".$ntele."\n";
    $text .= "Nama. : ".$nama."\n";
    $text .= "=============================\nTerimakasih dan Selamat ".sapaan();
    Bot::sendMessage($text, $option);
    $option = ['chat_id' => $idtele,
      'parse_mode' => 'html',
      'reply' => false];
    $text = "<i>Selamat ".sapaan()." ".$nama."</i>\n\n";
    $text .= "Ini adalah Bot telegram untuk pembutan Voucher Wifi, dengan menggunaan Bot ini anda tidak perlu melakukan setting Profile, semua data Profile untuk pembuatan Voucher di ambil dari data Aplikasi Mikhmon yang Anda pakai selama ini.\n";
    $text .= "yang harus disetting hanya memasukan ID Telegram, Nama Telegram Anda, nama bot dan token Bot. Cukup simple dan tidak ribet.\nUntuk informasi silahkan hub saya di https://t.me/titawatiya \nTerimakasih dan Selamat ".sapaan();
    Bot::sendMessage($text, $option);
  }
});

$mkbot->cmd('/Create|/create|/CREATE|', function ($mkode) {
  Bot::sendChatAction('typing');
  $info = bot::message();
  $msgid = $info['message_id'];
  $ntele = $info['from']['username'];
  $idtele = $info['from']['id'];
  $nama = $info['from']['first_name']." ".$info['from']['last_name'];

  $pesan = "Selamat ".sapaan()." ".$nama;
  $logo = "https://interhome.wifikonekter.us/webhook/img/logobot1.png";
  $opti = [
    'caption' => $pesan,
    'chat_id' => $idtele,
    'photo' => $logo,
    'parse_mode' => 'html',
  ];
  Bot::sendPhoto($pesan, $opti);
  if (empty($mkode) == "T") {
    $option = ['chat_id' => $idtele,
      'parse_mode' => 'html',
      'reply' => false];

    $text = "<i>Selamat ".sapaan()." ".$nama."</i>\n\n";
    $text .= "Gunakan Perintah \n";
    $text .= "<b>/cek diikuti kode voucher yang akan di cek.</b>\nContoh :\n";
    $text .= "/cek (spasi) 6H12345\n";

    Bot::sendMessage($text, $option);
  } else {
    $drouter = crouter();
    $idrouter = explode("!", $drouter);
    $send = [];
    $no = 1;
    for ($i = 0; $i < count($idrouter)-1; $i++) {
      $mrouter = $idrouter[$i];
      $router = explode("|", $mrouter);
      $ {
        'tombol' . $i
      } = ['text' => '📚  '.$no.'. '.strtoupper($router[0]).'  📚',
        'callback_data' => 'PPP|PProfile|'.$router[0].'|'.$mkode.'|'];
      $no++;
    }
    $menu_idawal = [['text' => 'Cek '.$mkode,
      'callback_data' => 'Krouter'],
    ];
    $trouter1 = array_filter([$tombol0]);
    $trouter2 = array_filter([$tombol1]);
    $trouter3 = array_filter([$tombol2]);
    $trouter4 = array_filter([$tombol3]);
    $menu_idakhir = [['text' => ' Pilih Router',
      'callback_data' => '12'],
    ];

    array_push($send, $trouter1);
    array_push($send, $trouter2);
    array_push($send, $trouter3);
    array_push($send, $trouter4);
    array_push($send, $menu_idakhir);
    $muser = explode(" ", $mkode)[0];
    $mpass = explode(" ", $mkode)[1];
    $iploc = explode(" ", $mkode)[2];
    $iprem = explode(" ", $mkode)[3];
    $text = "Pembuatan User Baru, dengan rincian : \n\n";
    $text .= "<code>Username : </code>".$muser."\n";
    $text .= "<code>Password : </code>".$mpass."\n\n";
    $text .= "<code>Local Address  : </code>".$iploc."\n";
    $text .= "<code>Remote Address : </code>".$iprem."\n\n";
    $text .= "Silahkan Pilih Router Di Bawah Ini,";
    $options = [
      'reply_markup' => json_encode(['inline_keyboard' => $send]),
      'parse_mode' => 'html',
      'reply' => false,
    ];
    Bot::sendMessage($text, $options);
  }
});

$mkbot->on('callback', function ($command) {
  Bot::sendChatAction('typing');
  $message = Bot::message();
  $enkod = json_encode($message);
  $id = $message['from']['id'];
  $muser = $message['from']['username'];
  $namatele = $message['from']['first_name'];
  $chatidtele = $message["message"]['chat']['id'];
  $chatusertele = $message["message"]['chat']['username'];
  $chatname1tele = $message["message"]['chat']['first_name'];
  $chatname2tele = $message["message"]['chat']['last_name'];
  $chatnametele = $chatname1tele." ".$chatname2tele;
  $message_idtele = $message["message"]["message_id"];
  $canggota = cdataid($id);
  $filex = 'webhookk.php';
  if (file_exists($filex)) {
    $misi = file_get_contents("$filex");
    $misi0 = explode("|", $misi);
    $id_own = $misi0[0];
    $namatele = $misi0[1];
    $bottele = $misi0[2];
    $tokentele = $misi0[3];
  }
  if (strpos($command, 'Pilih|') !== false) {
    $mdata = explode("|", $command);
    $text = "Saat ini Anda menggunakan router : <b>".strtoupper($mdata[1])."</b>\n";
    $text .= "Silahkan pilih transaksi Anda. ✏ ";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => 'Hotspot', 'callback_data' => 'BVoucher|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'],
            ['text' => 'Multi Vcr', 'callback_data' => 'MultiVcr|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'],
            ['text' => 'PPPOE', 'callback_data' => 'Report|Admin|'.$mdata[1].'|'],
          ],
          [
            ['text' => 'Report', 'callback_data' => 'Report|Pilihan|'.$mdata[1].'|'],
            ['text' => 'Monitoring', 'callback_data' => 'Hotspot|'.$mdata[1].'|'],
            //						['text' => 'Manual', 'callback_data' => 'Manual|'.$mdata[1].'|'],
          ],
          [
            ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);

  } elseif (strpos($command, 'Manual|') !== false) {
    $mdata = explode("|", $command);
    $text = "Anda akan membuat Voucher Manual\nMasukan Username yang Anda inginkan..?";
    $text .= "✏";


    $file = "../webhook/data/dt".$idtele.".txt";
    $mtulis = "Manual";
    $handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
    fwrite($handle, $mtulis);
    fclose($handle);

    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);


  } elseif (strpos($command, 'Report|') !== false) {
    $mdata = explode("|", $command);
    $text = " Selamat ".sapaan()." ".$chatnametele."\n\n";
    $text .= "Menampilkan pilihan laporan 9 Hari berjalan termasuk hari ini.\n\nDan  laporan 4 bulan berjalan, termasuk bulan sekarang.\n";
    if ($mdata[1] == "Pilihan") {
      $tgl = date('d-M-Y');
      $idtgl = 0;
      for ($i = 0; $i > -9; $i--) {
        $mtgl = manipulasiTanggal2($tgl, $i, 'days');
        $ {
          'tombol' . $idtgl
        } = ['text' => $mtgl.' 📘',
          'callback_data' => 'Report|Harian|'.$mdata[2].'|'.manipulasiTanggal3($tgl, $i, "days").'|'];
        $idtgl++;
      }
      $ {
        'tombol' . $idtgl
      } = ['text' => manipulasiTanggal1($tgl, 0, "months").' 📒',
        'callback_data' => 'Report|Bulanan|'.$mdata[2].'|dt'.substr(manipulasiTanggal($tgl, 0, "months"), 0, 2).substr(manipulasiTanggal($tgl, 0, "months"), 3, 4).'.txt|'.manipulasiTanggal1($tgl, 0, "months").'|'];
      $idtgl++;
      $ {
        'tombol' . $idtgl
      } = ['text' => manipulasiTanggal1($tgl, -1, "months").' 📒',
        'callback_data' => 'Report|Bulanan|'.$mdata[2].'|dt'.substr(manipulasiTanggal($tgl, -1, "months"), 0, 2).substr(manipulasiTanggal($tgl, -1, "months"), 3, 4).'.txt|'.manipulasiTanggal1($tgl, -1, "months").'|'];
      $idtgl++;
      $ {
        'tombol' . $idtgl
      } = ['text' => manipulasiTanggal1($tgl, -2, "months").' 📒',
        'callback_data' => 'Report|Bulanan|'.$mdata[2].'|dt'.substr(manipulasiTanggal($tgl, -2, "months"), 0, 2).substr(manipulasiTanggal($tgl, -2, "months"), 3, 4).'.txt|'.manipulasiTanggal1($tgl, -2, "months").'|'];
      $idtgl++;
      $ {
        'tombol' . $idtgl
      } = ['text' => manipulasiTanggal1($tgl, -3, "months").' 📒',
        'callback_data' => 'Report|Bulanan|'.$mdata[2].'|dt'.substr(manipulasiTanggal($tgl, -3, "months"), 0, 2).substr(manipulasiTanggal($tgl, -2, "months"), 3, 4).'.txt|'.manipulasiTanggal1($tgl, -3, "months").'|'];

      $ttgl = [['text' => '🥁  '.strtoupper($mdata[2]).'  🥁',
        'callback_data' => 'Brouter|'.$mdata[2].'||||'],
      ];
      $ttgl0 = array_filter([$tombol0, $tombol1, $tombol2]);
      $ttgl1 = array_filter([$tombol3, $tombol4, $tombol5]);
      $ttgl2 = array_filter([$tombol6, $tombol7, $tombol8]);
      $ttgl3 = array_filter([$tombol9, $tombol10]);
      $ttgl4 = array_filter([$tombol11, $tombol12]);
      $ttgl5 = [['text' => '◀  Pilihan',
        'callback_data' => 'Pilih|'.$mdata[2].'||||'],
        ['text' => 'Voucher  ▶',
          'callback_data' => 'BVoucher|'.$mdata[2].'|'],
      ];


      $send = [];
      array_push($send, $ttgl0);
      array_push($send, $ttgl1);
      array_push($send, $ttgl2);
      array_push($send, $ttgl3);
      array_push($send, $ttgl4);
      array_push($send, $ttgl5);
      array_push($send, $ttgl);
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => $send
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);

    } elseif ($mdata[1] == "Harian") {
      $text = " Selamat ".sapaan()." ".$chatnametele."\n\n";
      $mtgl = $mdata[3];
      $mfile = "../webhook/data/dt".substr($mtgl, 3, 2).substr($mtgl, 6, 4).".txt";
      if ($id == $id_own) {
        $id = "";
      }
      $text .= cdatadt($mfile, $id, $mdata[3], $mdata[2]);
      $text .= "============================= ";
      $text .= "\nTerimakasih dan Selamat ".sapaan()."\n";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],],
            [
              ['text' => '◀  Pilihan ', 'callback_data' => 'Pilih|'.$mdata[2].'|'], ['text' => 'Report  ▶', 'callback_data' => 'Report|Pilihan|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);

    } elseif ($mdata[1] == "Bulanan") {
      $text = " Selamat ".sapaan()." ".$chatnametele."\n\n";
      $mfile = "../webhook/data/".$mdata[3];
      if ($id == $id_own) {
        $id = "";
      }
      $text .= cdatadt1($mfile, $id, $mdata[4], $mdata[2]);
      $text .= "============================= ";
      $text .= "\nTerimakasih dan Selamat ".sapaan()."\n";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],],
            [
              ['text' => '◀  Pilihan ', 'callback_data' => 'Pilih|'.$mdata[2].'|'], ['text' => 'Report  ▶', 'callback_data' => 'Report|Pilihan|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);

    } elseif ($mdata[1] == "Admin") {
      $text = "Halaman Utilitas Admin \n\n";
      $text .= "🏠  <b>Renew</b> - Memperpanjang Account Bulanan.\n";
      $text .= "🏠  <b>IP Binding</b> - Reguler, Block, Passed, Removed User.\n";
      $text .= "🏠  <b>PPP</b> - Utilitas PPP User.\n";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🏠  Renew', 'callback_data' => 'Renew|'.$mdata[2].'|'],
              ['text' => 'IP Binding  🏠', 'callback_data' => 'IPBinding|'.$mdata[2].'|']
            ],
            [
              ['text' => '🏠 PPP 🏠', 'callback_data' => 'PPP|'.$mdata[1].'|'.$mdata[2].'|'],
            ],
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[2].'|'],
              ['text' => 'Report  ▶', 'callback_data' => 'Report|Pilihan|'.$mdata[2].'|'],
            ],
            [['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    }
  } elseif (strpos($command, 'PPP|') !== false) {
    $mdata = explode("|", $command);
    if ($mdata[1] == "User") {
      $text = "Halaman User ".$mdata[0]." dalam router ".$mdata[2].".\n\n";
      $text .= "<code>Create - </code><b>Buat User ".$mdata[0].".</b>\n";
      $text .= "<code>List   - </code><b>Daftar User ".$mdata[0].".</b>\n";
      $text .= "<code>Active - </code><b>User Active".$mdata[0].".</b>\n";
      $text .= "-----------------------------------------------------------\n.";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  Create', 'callback_data' => 'PPP|Create|'.$mdata[2].'|'],
              ['text' => 'List', 'callback_data' => 'PPP|List|'.$mdata[2].'|'],
              ['text' => 'Active 🏠', 'callback_data' => 'PPP|Active|'.$mdata[2].'|'],
            ],
            [
              ['text' => 'Voucher', 'callback_data' => 'BVoucher|'.$mdata[2].'|'],
              ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } elseif ($mdata[1] == "Create") {
      $text = "Create User ".$mdata[0].".\n\nSilahkan gunakan perintah\n\n/Create user password LocalIP RemoteIP\n\n<b>Contoh :</b>\n/Create rnet 67rt56rt 192.168.200.1 192.168.100.10\n";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  Create', 'callback_data' => 'PPP|Create|'.$mdata[2].'|'],
              ['text' => 'List', 'callback_data' => 'PPP|List|'.$mdata[2].'|'],
              ['text' => 'Active 🏠', 'callback_data' => 'PPP|Active|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } elseif ($mdata[1] == "List") {
      $drouter = explode("|", crouter1($mdata[2]));
      $text = "Halaman List ".$mdata[0].".\n\n";
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drouter[1], $drouter[2], decrypt($drouter[3]))) {
        $API->write('/ppp/secret/print');
        $ARRAY = $API->read();
        $data = $ARRAY;
        $data1 = $ARRAY;
        if (empty($data)) {
          $text .= "Tidak ada user PPP ditemukan dalam router ".$mdata[2]."\n";
        } else {
          $text .= "Daftar User PPP  router ".$mdata[2];
          $text .= "\n============================\n";
          $no = 0;
          for ($x = 0; $x < count($data1); $x++) {
            $no++;
            $text .= "<code>No / ID  : ".$no." [".$data1[$x]['.id']."]</code>\n";
            $text .= "<code>Name     : ".$data1[$x]['name']."</code>\n";
            $text .= "<code>Password : ".$data1[$x]['password']."</code>\n";
            $text .= "<code>Service  : ".$data1[$x]['service']."</code>\n";
            $text .= "<code>Profile  : ".$data1[$x]['profile']."</code>\n";
            $text .= "<code>Loc addr : ".$data1[$x]['local-address']."</code>\n";
            $text .= "<code>Rem addr : ".$data1[$x]['remote-address']."</code>\n";
            $dat1 = $data1[$x]['disable'];
            if ($dat1 == "true") {
              $text .= "<code>Disable  : iya</code>\n";
            } else {
              $text .= "<code>Disable  : Tidak</code>\n";
            }
            $ids = $data1[$x]['.id'];
            $dataid = str_replace('*', 'id', $ids);
            $text .= "Remove /reMopsEc$dataid\n";
            $text .= "--------------------------------------------------\n";
          }
          $text .= "Terdaftar ".$no." User PPPOE.";
        }
      } else {
        $text .= "Tidak bisa konek router ".$mdata[2]."\n";
      }
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🏠 Create', 'callback_data' => 'PPP|Create|'.$mdata[2].'|'],
              ['text' => 'List', 'callback_data' => 'PPP|List|'.$mdata[2].'|'],
              ['text' => 'Active 🏠', 'callback_data' => 'PPP|Active|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } elseif ($mdata[1] == "Active") {
      $drouter = explode("|", crouter1($mdata[2]));
      $text = "Halaman ".$mdata[0]." Aktif.\n\n";
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drouter[1], $drouter[2], decrypt($drouter[3]))) {
        $API->write('/ppp/active/getall');
        $ARRAY = $API->read();
        $data = $ARRAY;
        if (empty($data)) {
          $text .= "Tidak ada user PPP Active ditemukan dalam router \n".$mdata[2]."\n";
        } else {
          $text .= "Daftar User PPP Actve \nrouter ".$mdata[2]."\n";
          $text .= "-----------------------------------------------------------\n.";
          $no = 0;
          for ($x = 0; $x < count($data); $x++) {
            $userppp = $data[$x]['name'];
            $getinterfacetraffic = $API->comm("/interface/monitor-traffic", array("interface" => "<pppoe-$userppp>", "once" => "",));
            $tx = formatBites($getinterfacetraffic[0]['tx-bits-per-second'], 1);
            $rx = formatBites($getinterfacetraffic[0]['rx-bits-per-second'], 1);
            $no++;
            $text .= "<code>Nama      : </code>".$data[$x]['name']."\n";
            $text .= "<code>Caller ID : </code>".$data[$x]['caller-id']."\n";
            $text .= "<code>Address   : </code>".$data[$x]['address']."\n";
            $text .= "<code>Uptime    : </code>".$data[$x]['uptime']."\n";
            $text .= "<code>Service   : </code>".$data[$x]['service']."\n";
            $text .= "<code>Session   : </code>".$data[$x]['session-id']."\n";
            $text .= "<code>Trafic Tx : </code>".$tx."\n";
            $text .= "<code>Trafox Rx : </code>".$rx."\n";
            $text .= "<code>Radius    : </code>".$data[$x]['radius']."\n";
            $text .= "=============================\n";
          }
          $text .= "Ada ".$no." User PPPOE Active";
        }
      } else {
        $text .= "Tidak bisa konek router ".$mdata[2]."\n";
      }
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🏠 Create', 'callback_data' => 'PPP|Create|'.$mdata[2].'|'],
              ['text' => 'List', 'callback_data' => 'PPP|List|'.$mdata[2].'|'],
              ['text' => 'Active 🏠', 'callback_data' => 'PPP|Active|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } elseif ($mdata[1] == "Profile") {
      $drouter = explode("|", crouter1($mdata[2]));
      $text = "Halaman Profle ".$mdata[0]." dalam router \n".$mdata[2].".\n\n";
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drouter[1], $drouter[2], decrypt($drouter[3]))) {
        $API->write('/ppp/profile/getall');
        $ARRAY = $API->read();
        $data = $ARRAY;
        if (empty($data)) {
          $text .= "Tidak ada Profile PPP ditemukan dalam router ".$mdata[2]."\n";
        } else {
          $text .= "Daftar Profile PPP  router ".$mdata[2]."\n============================\n";
          foreach ($data as $index => $baris) :
          $limit = explode(" ", $baris['rate-limit']);
          $text .= "<code>Nama        : ".$baris['name']."</code>\n";
          for ($x = 0; $x < count($limit); $x++) {
            if ($x == 0) {
              $text .= "<code>Up/Down     : </code>";
            } elseif ($x == 1) {
              $text .= "<code>Burst Limit : </code>";
            } elseif ($x == 2) {
              $text .= "<code>Threshold   : </code>";
            } elseif ($x == 3) {
              $text .= "<code>Burst Time  : </code>";
            } elseif ($x == 4) {
              $text .= "<code>Priority    : </code>";
            } elseif ($x == 5) {
              $text .= "<code>Limit At    : </code>";
            } else {
              $text .= "                  : </code>";
            }
            $text .= $limit[$x]."\n";
          }
          $text .= "--------------------------------------------------\n";
          endforeach;
          $text .= ".";
        }
      } else {
        $text .= "Router sedang sibuk, Tidak bisa konek router ".$mdata[2]."\n";
      }
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🏠 User', 'callback_data' => 'PPP|User|'.$mdata[2].'|'],
              ['text' => 'Profile', 'callback_data' => 'PPP|Profile|'.$mdata[2].'|'],
            ],
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[2].'|'],
              ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } elseif ($mdata[1] == "Simpan") {
      $drouter = explode("|", crouter1($mdata[2]));
      $name = explode(" ", $mdata[3])[0];
      $password = explode(" ", $mdata[3])[1];
      $loc_address = explode(" ", $mdata[3])[2];
      $rem_address = explode(" ", $mdata[3])[3];
      $service = "pppoe";
      $profiles = $mdata[4];
      $comment = 'Rnet | ' . date('d/m/Y H:i');
      $text = "Data pengguna baru :\n\n";
      $text .= "<code>Username : </code>".$name."\n";
      $text .= "<code>Password : </code>".$password."\n";
      $text .= "<code>Loc Address : </code>".$loc_address."\n";
      $text .= "<code>Rem Address : </code>".$rem_address."\n";
      $text .= "<code>Service : </code>".$service."\n";
      $text .= "<code>Profile : </code>".$profiles."\n";
      $text .= "<code>Comment : </code>".$comment."\n\n";
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drouter[1], $drouter[2], decrypt($drouter[3]))) {
        $ok = "Y";
        if ($ok == "Y") {
          $makeuserprofile = $API->comm("/ppp/secret/add", [
            "name" => $name,
            "password" => $password,
            "service" => $service,
            "profile" => $profiles,
            "local-address" => $loc_address,
            "remote-address" => $rem_address,
            "comment" => $comment
          ]);
          $checkdata = json_encode($makeuserprofile);
          $cek = $makeuserprofile['!trap'][0]['message'];

          if (strpos(strtolower($checkdata), '!trap')) {
            $text .= "GAGAL melakukan penyimpanan User Baru PPP ke router ".$mdata[2]."\n";
          } else {
            $text .= "BERHASIL melakukan penyimpanan User Baru PPP ke router ".$mdata[2]."\n";
          }
        } else {
          $text .= "BERHASIL. data tidak disimpan ke router ".$mdata[2]."\n";
        }
      } else {
        $text = "Tidak bisa terhuung dengan router ".$mdata[2]."\n";
      }
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[2].'|'],
              ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } elseif ($mdata[1] == "PProfile") {
      $drouter = explode("|", crouter1($mdata[2]));
      $text = "Data pelanggan baru User ".$mdata[0]."\n\n";
      $text .= "<code>Username : </code>".explode(" ", $mdata[3])[0]."\n";
      $text .= "<code>Password : </code>".explode(" ", $mdata[3])[1]."\n";
      $text .= "<code>Loc Address : </code>".explode(" ", $mdata[3])[2]."\n";
      $text .= "<code>Rem Address : </code>".explode(" ", $mdata[3])[3]."\n\n";
      $text .= "Lanjut pilih Profile Secret, dibawah ini.\n";
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drouter[1], $drouter[2], decrypt($drouter[3]))) {
        $API->write('/ppp/profile/getall');
        $ARRAY = $API->read();
        $data = $ARRAY;
        if (empty($data)) {
          $text = "Tidak ada Profile PPP ditemukan dalam router ".$mdata[2]."\n";
        } else {
          for ($x = 0; $x < count($data); $x++) {
            $nprofile = ltrim($data[$x]['name']);
            if (strpos(strtolower($nprofile), 'default') !== false) {} else {
              $ {
                'profile' . $x
              } = ['text' => '📘 '.$nprofile,
                'callback_data' => 'PPPTanya|'.$mdata[2].'|'.$mdata[3].'|'.$nprofile];
            }
          }
          $proppp1 = array_filter([$profile0]);
          $proppp2 = array_filter([$profile1]);
          $proppp3 = array_filter([$profile2]);
          $proppp4 = array_filter([$profile3]);
          $proppp5 = array_filter([$profile4]);
          $menu_idakhir = [['text' => ' Pilih Profile',
            'callback_data' => '12'],
          ];
          $send = [];
          array_push($send, $proppp1);
          array_push($send, $proppp2);
          array_push($send, $proppp3);
          array_push($send, $proppp4);
          array_push($send, $proppp5);
          array_push($send, $menu_idakhir);

          $options = [
            'chat_id' => $chatidtele,
            'message_id' => (int) $message['message']['message_id'],
            'text' => $text,
            'reply_markup' => json_encode([
              'inline_keyboard' => $send
            ]),
            'parse_mode' => 'html'
          ];
          return Bot::editMessageText($options);
        }
      } else {
        $text = "Tidak bisa terkoneksi ke router ".$mdata[2]."\n";
      }
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🏠 Simpan', 'callback_data' => 'PPP|proses|'.$mdata[2].'|'.$mdata[3].'|'],
              ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } else {
      $text = "PPPOE SERVER ".$mdata[0].".\n\n";
      $text .= "🏠  <b>User</b> - Kelola User ".$mdata[0].".\n";
      $text .= "🏠  <b>Profile</b> - Kelola Profile ".$mdata[0].".\n";
      $text .= "-----------------------------------------------------------\n.";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🏠 User', 'callback_data' => 'PPP|User|'.$mdata[2].'|'],
              ['text' => 'Profile', 'callback_data' => 'PPP|Profile|'.$mdata[2].'|'],
            ],
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[2].'|'],
              ['text' => 'Voucher', 'callback_data' => 'BVoucher|'.$mdata[2].'|'],
              ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[2].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[2].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    }
    return Bot::editMessageText($options);
  } elseif (strpos($command, 'IPBinding|') !== false) {
    $mdata = explode("|", $command);
    if ($mdata[2] == "List") {
      $drouter = explode("|", crouter1($mdata[1]));
      $text .= "Daftar Item IP Binding.\n";
      $text .= "-----------------------------------------------------------\n";
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drouter[1], $drouter[2], decrypt($drouter[3]))) {
        $dataipb = $API->comm("/ip/hotspot/ip-binding/print");
        if (empty($dataipb) == false) {
          $no = 0;
          for ($x = 0; $x < count($dataipb); $x++) {
            $no++;
            $text .= "<code>No /Id      : </code>".$no." [".$dataipb[$x]['.id']."]\n";
            $text .= "<code>mac-address : </code>".$dataipb[$x]['mac-address']."\n";
            $text .= "<code>address     : </code>".$dataipb[$x]['address']."\n";
            $text .= "<code>to-address  : </code>".$dataipb[$x]['to-address']."\n";
            $text .= "<code>server      : </code>".$dataipb[$x]['server']."\n";
            $text .= "<code>comment     : </code>".$dataipb[$x]['comment']."\n";
            if ($no < count($dataipb)) {
              $text .= "-----------------------------------------------------------\n\n.";
            } else {
              $text .= "===============================\n\n.";
            }
          }
        } else {
          $text = "Tidak ditemukan Item ".$mdata[0]." dalam  router ".$mdata[1].".\n";
        }
      } else {
        $text = "Tidak bisa terhubung ke router ".$mdata[1]." Silahkan coba beberapa saat lagi.\n";
      }
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  List', 'callback_data' => 'IPBinding|'.$mdata[1].'|List|'],
              ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[1].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    } else {
      $text = " Selamat ".sapaan()." ".$chatnametele."\n\n";
      $text .= "mdata 0 : ".$mdata[0]."\n";
      $text .= "mdata 1 : ".$mdata[1]."\n";
      $text .= "mdata 2 : ".$mdata[2]."\n";
      $text .= "mdata 3 : ".$mdata[3]."\n\n";
      $text .= "-----------------------------------------------------------\n.";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  List', 'callback_data' => 'IPBinding|'.$mdata[1].'|List|'],
              ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[1].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
    }
    return Bot::editMessageText($options);
  } elseif (strpos($command, 'Renew|') !== false) {
    $mdata = explode("|", $command);
    $text = " Selamat ".sapaan()." ".$chatnametele."\n\n";
    if ($mdata[2] == "YA") {
      $drtr = explode("|", crouter1($mdata[1]));
      $dvcr = explode("|", cvdetail($mdata[1], $mdata[5]));
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
        $cekuser = $API->comm("/ip/hotspot/user/print", ["?name" => $mdata[3],]);
        if (empty($cekuser)) {
          //buat voucher baru
          if ($id == $id_own) {
            if ($mdata[5] == "Unlimited") {
              $add_user_api = $API->comm("/ip/hotspot/user/add", [
                "server" => "all", // bisa ganti ke server lain
                "profile" => $mdata[5],
                "name" => $mdata[3],
                //							"limit-uptime" => $limituptimereal,
                //							"limit-bytes-out" => $limit_download,
                //							"limit-bytes-in" => $limit_upload,
                //							"limit-bytes-total" => $limit_total,
                "password" => $mdata[4],
                "comment" => "Owner_Hotspot",
              ]);
            } else {
              $add_user_api = $API->comm("/ip/hotspot/user/add", [
                "server" => "all",
                "profile" => $mdata[5],
                "name" => $mdata[3],
                "limit-uptime" => $dvcr[4],
                //							"limit-bytes-out" => $limit_download,
                //							"limit-bytes-in" => $limit_upload,
                //							"limit-bytes-total" => $limit_total,
                "password" => $mdata[4],
                "comment" => "vc-Pelanggan",
              ]);
            }
          }
          $text = "Proses perpanjangan Account ".$mdata[3].".\nDengan masa aktif ".$mdata[5]." Hari, berhasil di lakukan.\n\nBerikut Rincian Account \n\n";
          $text .= "Voucher ".$mdata[3]."\n";
          $text .= "Passwrd ".$mdata[4]."\n";
          $text .= "Profile ".$mdata[5]."\n\n";
          $text .= "Terimakasih dan selamat ".sapaan();
          //detail
        } else {
          //rubah commen
          $ARRAY = $API->comm("/ip/hotspot/user/print", ["?name" => $mdata[3],]);
          foreach ($ARRAY as $index => $baris) {
            $text = "\n";
            $text .= "Data Client ".$mdata[3]."\n<code>----------------------------</code>\n";
            $text .= "<code>ID       : </code>" . $baris['.id'] . "\n";
            $text .= "<code>Nama     : </code>" . $baris['name'] . "\n";
            $text .= "<code>Profile  : </code>" . $baris['profile'] . "\n";
            $text .= "<code>Uptime   : </code>" . $baris['uptime'] . "\n";
            $text .= "<code>Comment  : </code>" . $baris['comment'] . "\n";
            $text .= "<code>----------------------------</code>\n";
            $mid = $baris['.id'];
          }
          $mtgl = strtolower(manipulasiTanggal4(cbulan($baris['comment'], $dvcr[4]), $mdata[6], 'days'))." ".date('H:m:i');
          $text .= "Telah berhasil diperpanjang sampai dengan tanggal ".$mtgl."\n";
          if ($id == $id_own) {
            if ($mdata[5] == "Unlimited") {
              $API->comm("/ip/hotspot/user/set", array(
                ".id" => "$mid",
                "comment" => "Owner_Hotspot",
              ));
            } else {
              $API->comm("/ip/hotspot/user/set", array(
                ".id" => "$mid",
                "comment" => $mtgl,
              ));
            }
          } sleep(1);
          $ARRAY = $API->comm("/ip/hotspot/user/print", ["?name" => $mdata[3],]);
          foreach ($ARRAY as $index => $baris) {
            $text .= "\n";
            $text .= "Data Client ".$mdata[3]."\n<code>----------------------------</code>\n";
            $text .= "<code>ID       : </code>" . $baris['.id'] . "\n";
            $text .= "<code>Nama     : </code>" . $baris['name'] . "\n";
            $text .= "<code>Profile  : </code>" . $baris['profile'] . "\n";
            $text .= "<code>Uptime   : </code>" . $baris['uptime'] . "\n";
            $text .= "<code>Comment  : </code>" . $baris['comment'] . "\n";
            $text .= "<code>----------------------------</code>\n";
          }
          $text .= "Terimakasih dan selamat ".sapaan();
        }
      } else {
        $text .= "Gagal terhubung dengan router ".$mdata[1].".\nCek koneksi internet anda.";
      }
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
              ['text' => 'Admin', 'callback_data' => 'Report|Admin|'.$mdata[1].'|'],
              ['text' => 'Report  ▶', 'callback_data' => 'Report|Pilihan|'.$mdata[1].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);

    } elseif ($mdata[2] == "BATAL") {
      $text .= "Proses perpanjang pelanggan dengan Account <b>".$mdata[3]."</b> dengan paket berjalan <b>".$mdata[5]."</b>\n\n<b>BATAL di proses.</b>";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
              ['text' => 'Admin', 'callback_data' => 'Report|Admin|'.$mdata[1].'|'],
              ['text' => 'Report  ▶', 'callback_data' => 'Report|Pilihan|'.$mdata[1].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);

    } elseif ($mdata[2] == "Proses") {
      $drtr = explode("|", crouter1($mdata[1]));
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
        $ARRAY = $API->comm("/ip/hotspot/user/print", ["?name" => $mdata[3],]);
        foreach ($ARRAY as $index => $baris) {
          $text = "\n";
          $text .= "Data Client ".$mdata[3]."\n<code>----------------------------</code>\n";
          $text .= "<code>ID       : </code>" . $baris['.id'] . "\n";
          $text .= "<code>Nama     : </code>" . $baris['name'] . "\n";
          $text .= "<code>Profile  : </code>" . $baris['profile'] . "\n";
          $text .= "<code>Uptime   : </code>" . $baris['uptime'] . "\n";
          $text .= "<code>Comment  : </code>" . $baris['comment'] . "\n";
          $text .= "<code>----------------------------</code>\n";
        }
      } else {
        $text = "Gagal terhubung dengan router ".$mdata[1].".\nCek koneksi internet anda.";
      }
      $text .= "Anda akan memperpanjang pelanggan dengan Account <b>".$mdata[3]."</b> dengan Paket berjalan <b>".$mdata[5]."</b>..??\n\nProses / Batal";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🚘 Proses', 'callback_data' => 'Renew|'.$mdata[1].'|YA|'.$mdata[3].'|'.$mdata[4].'|'.$mdata[5].'|'.$mdata[6].'|'],
              ['text' => '🚘 BATAL', 'callback_data' => 'Renew|'.$mdata[1].'|BATAL|'.$mdata[3].'|'],
            ],
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
              ['text' => 'Admin', 'callback_data' => 'Report|Admin|'.$mdata[1].'|'],
              ['text' => 'Report  ▶', 'callback_data' => 'Report|Pilihan|'.$mdata[1].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    } else {
      $text .= "Silahkan pilih pelanggan yang akan melakukan perpanjangan.\n";

      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => 'Customer1', 'callback_data' => 'Renew|'.$mdata[1].'|Proses|Customer1|Password1|User1|Aktif1|'],
              ['text' => 'Customer2', 'callback_data' => 'Renew|'.$mdata[1].'|Proses|Customer2|Password2|User2|Aktif2|'],
              ['text' => 'Customer3', 'callback_data' => 'Renew|'.$mdata[1].'|Proses|Customer3|Password3|User3|Aktif3|'],
            ],
            [
              ['text' => 'Customer4', 'callback_data' => 'Renew|'.$mdata[1].'|Proses|Customer4|Password4|User4|Aktif4|'],
              ['text' => 'Customer5', 'callback_data' => 'Renew|'.$mdata[1].'|Proses|Customer5|Password5|User5|Aktif5|']
            ],
            [
              ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
              ['text' => 'Report  ▶', 'callback_data' => 'Report|Pilihan|'.$mdata[1].'|'],
            ],
            [
              ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    }
  } elseif (strpos($command, 'Hotspot|') !== false) {
    $mdata = explode("|", $command);
    $cari = explode("|", webhookk());
    $text = "Selamat ".sapaan()." ".$chatnametele."\n\n";
    if ($chatidtele <> $cari[0]) {
      $text .= "Anda tidak mempunyai Otoritas atas Informasi ini.\nTerimakasih.";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  Back to Pilihan  ▶', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    }
    if (empty($mdata[2])) {
      //			$text 	= "Selamat ".sapaan()." ".$chatnametele."\nAnda berada pada router ".$mdata[1]."\n\n";
      $text .= "🙊 <b>Aktif</b> - Untuk melihat Voucher yang sedang Login.\n\n";
      $text .= "<b>Stock</b> - Untuk melihat Voucher yang ada dalam router ".$mdata[1]."\n\n";
      $text .= "<b>Traffic</b> 🤡 - Untuk melihat Traffic pada Interface router ".$mdata[1]."\n\n";
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter'],
            ],
            [
              ['text' => '🙊 Aktif', 'callback_data' => 'Hotspot|'.$mdata[1].'|Aktif|'],
              ['text' => 'Stock', 'callback_data' => 'Hotspot|'.$mdata[1].'|Stock|'],
              ['text' => 'Traffic 🤡', 'callback_data' => 'Hotspot|'.$mdata[1].'|Traffic|'],
            ],
            [
              ['text' => '◀  Back to Pilihan  ▶', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    } elseif ($mdata[2] == "Aktif") {
      //pencarian ip denga nama router
      $drtr = explode("|", crouter1($mdata[1]));
      $API = new RouterosAPI();
      $API->debug = false;
      if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
        $uaktiv = $API->comm("/ip/hotspot/active/print");
        $jaktiv = count($uaktiv);
        if (empty($uaktiv)) {
          $text .= "Tidak dapat User yang sedang Aktiv di router ".$mdata[1].".\n";
        } else {
          $hal = 1;
          $bts = 1;
          $no = 0;
          $text1 = "";
          $opt = ['chat_id' => $id,
            'parse_mode' => 'html',
          ];
          $text1 = "<b>Daftar user yang sedang Aktif ada router ".$mdata[1].".</b>\n\n";
          for ($i = 0; $i < $jaktiv; $i++) {
            $misi = $uaktiv[$i];
            $user = $misi['user'];
            $address = $misi['address'];
            $mac = $misi['mac-address'];
            $time = $misi['comment'];
            $msess = $misi['session-time-left'];
            $mused = formatBytes($misi['bytes-out'], 0);

            if (strpos($time, 'vc-') !== false) {
              $time = $misi['session-time-left'];
            }
            if (strpos($mused, 'GiB') !== false) {
              $mused = formatBytes($misi['bytes-out'], 2);
            }
            $no++;
            $text1 .= $no.". <b>".$user." / ".$mused."</b>\n".$mac." ".$address."\nAktive : ".$time."\n----------------------------------------------------\n";
            $bts++;
            if ($bts > 20) {
              Bot::sendMessage($text1, $opt);
              $hal = hal+1;
              $bts = 1;
              $text1 = "";
            }
          }
          $text1 .= "Total ".$no." User Aktif.\n----------------------------------------------------\n";
          if ($bts < 20) {
            $opt = ['chat_id' => $id,
              'reply_markup' => json_encode([
                'inline_keyboard' => [
                  [
                    ['text' => '◀ Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
                    ['text' => 'Refresh', 'callback_data' => 'Hotspot|'.$mdata[1].'|Aktif|'],
                    ['text' => 'Hotspot ▶', 'callback_data' => 'Hotspot|'.$mdata[1].'|'],
                  ],
                  [
                    ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter1'],
                  ],
                ]
              ]),
              'parse_mode' => 'html',
            ];
            Bot::sendMessage($text1, $opt);
          }
        }
      } else {
        $text .= "Tidak dapat terhubung ke router ".$mdata[1].".\n";
        $options = [
          'chat_id' => $chatidtele,
          'message_id' => (int) $message['message']['message_id'],
          'text' => $text,
          'reply_markup' => json_encode([
            'inline_keyboard' => [
              [
                ['text' => '◀  Refresh', 'callback_data' => 'Hotspot|'.$mdata[1].'|Aktif|'],
                ['text' => 'Hotspot  ▶', 'callback_data' => 'Hotspot|'.$mdata[1].'||'],
              ],
              [
                ['text' => '🥁  '.strtoupper($mdata[1]).' 🥁', 'callback_data' => 'Brouter'],
              ],
            ]
          ]),
          'parse_mode' => 'html'
        ];
        Bot::editMessageText($options);
      }

    } elseif ($mdata[2] == "Stock") {
      $drtr = explode("|", crouter1($mdata[1]));
      $API = new RouterosAPI();
      $API->debug = false;
      //			$drtr[1]="sa";
      if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
        $mstock = $API->comm("/ip/hotspot/user/print");
        $jstock = count($mstock);
        if (empty($mstock)) {
          $text .= "Tidak ada stock Voucher pada router ".$mdata[1].".\n";
        } else {
          $text .= "<b>Stock Voucer user yang ada pada router ".$mdata[1].".</b>\n\n";
          $hal = 1;
          $bts = 1;
          $no = 0;
          $text1 = "";
          $opt = ['chat_id' => $id,
            'parse_mode' => 'html',
          ];
          for ($i = 0; $i < $jstock; $i++) {
            $user = $mstock[$i]['name'];
            $paket = $mstock[$i]['profile'];
            $limit = $mstock[$i]['limit-uptime'];
            $uptime = $mstock[$i]['uptime'];
            $test = strlen($uptime);
            if (strlen($uptime) < 3) {
              $no++;
              $text1 .= $no.". <b>".$user." ".$limit."</b>\n".$paket."\n----------------------------------------------------\n";
              $bts++;
            }
            if ($bts > 20) {
              Bot::sendMessage($text1, $opt);
              $hal = hal+1;
              $bts = 1;
              $text1 = "";
            }
          }
          $text1 .= $no.". Vcr yang belum terpakai\n----------------------------------------------------\n";
          Bot::sendMessage($text1, $opt);
          //
          $bts = 1;
          $text1 = "Daftar Voucher Aktif.:\n\n";
          $no = 0;
          for ($i = 0; $i < $jstock; $i++) {
            $user = $mstock[$i]['name'];
            $paket = $mstock[$i]['profile'];
            $limit = $mstock[$i]['limit-uptime'];
            $uptime = $mstock[$i]['uptime'];
            $test = strlen($uptime);
            if (strlen($uptime) > 2) {
              $no++;
              $text1 .= $no.". <b>".$user." ".$limit."</b>\n".$paket."\n----------------------------------------------------\n";
              $bts++;
            }
            if ($bts > 20) {
              Bot::sendMessage($text1, $opt);
              $hal = hal+1;
              $bts = 1;
              $text1 = "";
            }
          }
          $text1 .= $no.". Vcr Aktif yg sedang Aktiv\n----------------------------------------------------\nSelamat ".sapaan()." dan Terimakasih.";

          $text .= "Total ".$jstock." Stock Voucer.\n";
          $opt = ['chat_id' => $id,
            'reply_markup' => json_encode([
              'inline_keyboard' => [
                [
                  ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
                  ['text' => 'Hotspot  ▶', 'callback_data' => 'Hotspot|'.$mdata[1].'|'],
                ],
                [
                  ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter1'],
                ],
              ]
            ]),
            'parse_mode' => 'html',
          ];
          Bot::sendMessage($text1, $opt);
        }
      } else {
        $text .= "Tidak dapat terhubung ke router ".$mdata[1].".\n";
        $options = [
          'chat_id' => $chatidtele,
          'message_id' => (int) $message['message']['message_id'],
          'text' => $text,
          'reply_markup' => json_encode([
            'inline_keyboard' => [
              [
                ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
                ['text' => 'Hotspot  ▶', 'callback_data' => 'Hotspot|'.$mdata[1].'|'],
              ],
              [
                ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter'],
              ],
            ]
          ]),
          'parse_mode' => 'html'
        ];
        Bot::editMessageText($options);
      }

    } elseif ($mdata[2] == "Traffic") {
      $drtr = explode("|", crouter1($mdata[1]));
      $API = new RouterosAPI();
      $API->debug = false;
      //			$drtr[1]="sa";
      if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
        $getinterface = $API->comm("/interface/print");
        $num = count($getinterface);
        $Traffic = "";
        $bts = 1;
        $hal = 1;
        $no = 1;
        $option = ['chat_id' => $id,
          'parse_mode' => 'html',
        ];
        for ($i = 0; $i < $num; $i++) {
          $interface = $getinterface[$i]['name'];
          $getinterfacetraffic = $API->comm("/interface/monitor-traffic", array("interface" => "$interface", "once" => "",));
          $tx = formatBites($getinterfacetraffic[0]['tx-bits-per-second'], 1);
          $rx = formatBites($getinterfacetraffic[0]['rx-bits-per-second'], 1);
          $Traffic .= $no.". <b>Traffic $interface</b>\n";
          $Traffic .= "$mgaris0\n";
          $Traffic .= "TX: $tx / 100 Mbps \n";
          $Traffic .= "RX: $rx / 100 Mbps \n";
          $Traffic .= $mgaris0."-----------------------------------------\n";
          Bot::sendMessage($Traffic, $option);
          $Traffic = "";
          $no = $no+1;
        }
        $Traffic .= "Total Traffic : ".$num."\n-----------------------------------------\n";
        $option = ['chat_id' => $id,
          'reply_markup' => json_encode([
            'inline_keyboard' => [
              [
                ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
                ['text' => 'Hotspot  ▶', 'callback_data' => 'Hotspot|'.$mdata[1].'|'],
              ],
              [
                ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter'],
              ],
            ]
          ]),
          'parse_mode' => 'html',
        ];
        Bot::sendMessage($Traffic, $option);
      } else {
        $text = "Tidak Dapat Terhubung ke router ".$mdata[1];
        $options = [
          'chat_id' => $chatidtele,
          'message_id' => (int) $message['message']['message_id'],
          'text' => $text,
          'reply_markup' => json_encode([
            'inline_keyboard' => [
              [
                ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter'],
              ],
              [
                ['text' => '◀  Pilihan', 'callback_data' => 'Pilih|'.$mdata[1].'|'],
                ['text' => 'Hotspot  ▶', 'callback_data' => 'Hotspot|'.$mdata[1].'|'],
              ],
            ]
          ]),
          'parse_mode' => 'html'
        ];
        return Bot::editMessageText($options);
      }
    }
  } elseif (strpos($command, 'MultiVcr|') !== false) {
    $mdata = explode("|", $command);
    $dvcr = cvoucher($mdata[1]);
    $text = "Silahkan pilih Paket Voucher\nYang akan di cetak massal.\n";
    $text .= "--------------------------------------------------\n";
    $vcr = explode("*", $dvcr);
    for ($i = 1; $i < count($vcr); $i++) {
      $pvcr = explode("*", $vcr[$i]);
      $pvcr0 = explode("|", $pvcr[0]);
      $Vcr = "R-net ".substr("    ".$pvcr0[4], -3);
      $Vrp = rupiah(trim($pvcr0[3]));
      $sped = substr("   ".$pvcr0[6], strlen($pvcr0[4])-9);
      $text .= "<b>".$Vcr."  ".$sped."  ".$Vrp."</b>\n";
      $ {
        'tombol' . $i
      } = ['text' => $Vcr,
        'callback_data' => 'MultiQty|'.$mdata[1].'|'.$mdata[2].'|'.$Vcr.'|'.trim($pvcr0[0]).'|'];
    }
    $send = [];
    $menu_idatas = [['text' => '🥁  '.strtoupper($mdata[1]).'  🥁',
      'callback_data' => 'Brouter|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'],
    ];
    $trouter1 = array_filter([$tombol1, $tombol2, $tombol3]);
    $trouter2 = array_filter([$tombol4, $tombol5, $tombol6]);
    $trouter3 = array_filter([$tombol7, $tombol8, $tombol9]);
    $trouter4 = array_filter([$tombol10, $tombol11, $tombol12]);
    $menu_idakhir = [['text' => '◀  Back to Pilihan  ▶',
      'callback_data' => 'Pilih|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'],
    ];
    array_push($send, $menu_idatas);
    array_push($send, $trouter1);
    array_push($send, $trouter2);
    array_push($send, $trouter3);
    array_push($send, $trouter4);
    array_push($send, $menu_idakhir);
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => $send
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);
  } elseif (strpos($command, 'MultiQty|') !== false) {
    $mdata = explode("|", $command);
    $text = "Detail Voucher yang akan di proses.\nPaket : ".$mdata[3]."\nProfile : ".$mdata[4]." ✏\n-------------------------------------------------------\n";
    $text .= "Silahkan pilih jumlah Voucher yang akan di Cetak ?.";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'],
          ],
          [
            ['text' => '2 Vcr', 'callback_data' => 'TanyaMQ|2|'.$mdata[1].'|'.$mdata[4].'|'],
            ['text' => '3 Vcr', 'callback_data' => 'TanyaMQ|3|'.$mdata[1].'|'.$mdata[4].'|'],
            ['text' => '5 Vcr', 'callback_data' => 'TanyaMQ|5|'.$mdata[1].'|'.$mdata[4].'|'],
          ],
          [
            ['text' => '10 Vcr', 'callback_data' => 'TanyaMQ|10|'.$mdata[1].'|'.$mdata[4].'|'],
            ['text' => '15 Vcr', 'callback_data' => 'TanyaMQ|15|'.$mdata[1].'|'.$mdata[4].'|'],
            ['text' => '1 Lbr', 'callback_data' => 'TanyaMQ|24|'.$mdata[1].'|'.$mdata[4].'|'],
          ],
          [
            ['text' => '2 Lbr', 'callback_data' => 'TanyaMQ|48|'.$mdata[1].'|'.$mdata[4].'|'],
            ['text' => '5 Lbr', 'callback_data' => 'TanyaMQ|120|'.$mdata[1].'|'.$mdata[4].'|'],
            ['text' => '10 Lbr', 'callback_data' => 'TanyaMQ|240|'.$mdata[1].'|'.$mdata[4].'|'],
          ],
          [
            ['text' => '◀  Back to Router List  ▶', 'callback_data' => 'Brouter'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);
    //
  } elseif (strpos($command, 'PPPTanya|') !== false) {
    $mdata = explode("|", $command);
    $text = "Data pelanggan baru User PPP.\n\n";
    $text .= "<code>Username : </code>".explode(" ", $mdata[2])[0]."\n";
    $text .= "<code>Password : </code>".explode(" ", $mdata[2])[1]."\n";
    $text .= "<code>Loc Address : </code>".explode(" ", $mdata[2])[2]."\n";
    $text .= "<code>Rem Address : </code>".explode(" ", $mdata[2])[3]."\n\n";

    $text .= "<code>Profile : </code>".$mdata[3]."\n\n";
    $text .= "Apakah data ini akan disimpan ?.\n";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '🏠 Simpan', 'callback_data' => 'PPP|Simpan|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'],
            ['text' => 'Back  ▶', 'callback_data' => 'Report|Admin|'.$mdata[1].'|'],
          ],
          [
            ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter|'.$mdata[1].'|'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    return Bot::editMessageText($options);

    //
  } elseif (strpos($command, 'TanyaMQ|') !== false) {
    $mdata = explode("|", $command);
    $cdvcr = explode("|", cvdetail($mdata[2], $mdata[3]));
    $pvcr = $cdvcr[0];
    $avcr = $cdvcr[1];
    $hvcr = $cdvcr[3];
    $mvcr = $cdvcr[4];
    $text = "<b>Selamat ".sapaan()." ".$chatnametele."</b>\n";
    $text .= "<i>Detail Vcr Yang akan Anda Cetak secara Massal :</i>\n\n";
    $text .= "Paket VCR ".$cdvcr[4]."\n";
    $text .= "Profile : ".$cdvcr[0]."\n";
    $text .= "Aktif : ".$cdvcr[1]."\n";
    $text .= "Rate Limit : ".trim($cdvcr[6])."\n";
    $text .= "Harga : ".rupiah($cdvcr[3])."\n";
    $text .= "Sejumlah : ".$mdata[1]." Voucher\n\n";
    $text .= "<b>Seharga : ".rupiah($mdata[1]*$cdvcr[3])."</b>\n\n";
    $text .= "Voucher Akan di <b>PROSES ?</b>";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '🥁  '.strtoupper($mdata[2]).'  🥁', 'callback_data' => 'Brouter'],
          ],
          [
            ['text' => '✅  YA', 'callback_data' => 'PMulti|'.$mdata[2].'|'.$cdvcr[0].'|'.$mdata[1].'|'], ['text' => 'NO  ❎', 'callback_data' => 'MultiVcr|'.$mdata[2].'|'.$cdvcr[0].'|'.$mdata[2].'|'],
          ],
          [
            ['text' => '⬅  Back To Router List  ➡', 'callback_data' => 'Brouter'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);

  } elseif (strpos($command, 'CekVoucher|') !== false) {
    $mdata = explode("|", $command);
    $kodevcr = trim($mdata[1]);
    $drouter = explode("|", ciprouter($mdata[2]));

    $API = new RouterosAPI();
    $API->debug = false;
    $text = "Selamat ".sapaan()." ".$chatnametele."\n".$mdata[2]."\n";

    if ($API->connect($drouter[1], $drouter[2], decrypt($drouter[3]))) {
      $ARRAY = $API->comm("/ip/hotspot/user/print", ["?name" => $kodevcr,]);
      if (empty($ARRAY)) {
        $text .= "Kode Voucher ".$kodevcr."\nTidak ditemukan dalam router ".$drouter[0]."\n";
      } else {
        $text .= "Kode Voucher <b>".$kodevcr."</b>\nAda dalam router ".$drouter[0]."\n";
        $ARRAY1 = $API->comm("/ip/hotspot/active/print", ["?user" => $kodevcr,]);
        if (empty($ARRAY1)) {
          $text .= "Tetapi <i>tidak</i> sedang Aktif.\n";
        } else {
          $text .= "Sekarang dia <i>sedang</i> Aktif.\n";
        }
      }
    } else {
      $text .= "Proses Cek Kode Voucher ".$mkode." GAGAL diproses.\n";
    }
    $text .= "\nTerimakasih dan Selamat ".sapaan();
    $options = [
      'chat_id' => $id,
      'text' => $text,
      'parse_mode' => 'html'
    ];
    Bot::sendMessage($text, $options);

  } elseif (strpos($command, 'PMulti|') !== false) {
    $mdata = explode("|", $command);
    $drtr = explode("|", crouter1($mdata[1]));
    $dvcr = explode("|", cvdetail($mdata[1], $mdata[2]));
    $mcetak = "";
    $mtgl = date('d/m/Y');
    $mtime = date('H:i:s');
    $vfile = "vc-BT".substr($mtgl, 0, 2).substr($mtgl, 3, 2).substr($mtgl, 6, 4).substr($mtime, 0, 2).substr($mtime, 3, 2);
    $mwaktu = $mtgl." ".$mtime;
    $API = new RouterosAPI();
    $API->debug = false;

    if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
      for ($i = 1; $i < $mdata[3]+1; $i++) {
        $kodevcr = strtoupper(trim($dvcr[4])."-".kuser(7-strlen(trim($dvcr[4]))));
        $ARRAY = $API->comm("/ip/hotspot/user/print", ["?name" => $kodevcr,]);
        $mket = "Sukses.";
        if (empty($ARRAY)) {
          //hanya owner yg bisa simpan
          if ($id == $id_own) {
            $add_user_api = $API->comm("/ip/hotspot/user/add", [
              "server" => 'all',
              "profile" => $dvcr[0],
              "name" => $kodevcr,
              "limit-uptime" => $dvcr[4],
              //						"limit-bytes-out" => $limit_download,
              //						"limit-bytes-in" => $limit_upload,
              //						"limit-bytes-total" => $limit_total,
              "password" => $kodevcr,
              "comment" => $vfile,
            ]);
            $cekvalidasiadd = json_encode($add_user_api);
            if (strpos(strtolower($cekvalidasiadd), '!trap')) {
              $ARRAY2 = $API->comm("/ip/hotspot/user/remove", ["numbers" => $add_user_api,]);
              $mket = "Gagal.";
            }
          }
          $mhrg = rupiah($dvcr[3]);
          $mcetak .= "$mdata[1]|$dvcr[0]|$kodevcr|$mhrg|$dvcr[1]*";
          $mtulis = $id."|".$chatnametele.'|'.$mtgl."|".$mtime."|".$drtr[0]."|".$dvcr[0]."|".$kodevcr."|".$dvcr[2]."|".$dvcr[3]."|".$dvcr[4]."|".$dvcr[1]."|".$vfile."|".$mket."# \n";
          $fdtvcr = "../webhook/data/dt".substr($mtgl, 3, 2).substr($mtgl, 6, 4).".txt";
          file_put_contents($fdtvcr, $mtulis, FILE_APPEND | LOCK_EX);
        } else {
          $i--;
        }
      }
    } else {
      $text = "Proses GAGAL, tidak dapat terhubung ke router ".$mdata[1];
      $options = [
        'chat_id' => $chatidtele,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '📋  To Router List  📋', 'callback_data' => 'Brouter'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    }
    $scheme = $_SERVER['REQUEST_SCHEME'];
    if (strpos(strtolower($scheme), 'http') !== false) {
      $cekhttps = "https://";
    } else {
      $cekhttps = $scheme."://";
    }

    $urlpath = $_SERVER['REQUEST_URI'];
    $linktobot = str_replace('Core.php', 'cetak/', $urlpath);
    $urlcetak0 = $cekhttps.$_SERVER['HTTP_HOST'].$linktobot;
    $urlcetak = $urlcetak0.'cmulti.php?mfile='.$vfile."&dtcetak=$mcetak";
    $urlcetakbt = $urlcetak0.'cmultibt.php?mfile='.$vfile."&bot=$bottele&dtcetak=$mcetak";

    $text = "Keterangan :\n\n";
    $text .= "📤.  <b>BT Print</b>  .📤\n";
    $text .= "Proses cetak akan menggunakan Printer BT\nPerangkat Anda harus sudah terpasang dengan Printer Thermal dengan baik\n\n";
    $text .= "🖨  <b>Print A4/Pdf</b>  🖨\n";
    $text .= "Opsi ini akan mencetak file ke Printer Biasa atau akan di simpan dalam bentuk format Pdf, dan bisa dicetak dilain waktu\n\n";
    $text .= "<b>Data Voucher sudah tersimpan di router ".$mdata[1]."</b> \n\n";
    $text .= "Apakah Proses Akan di Lanjutkan...?\n";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '📤.  BT Print', 'url' => $urlcetakbt],
            ['text' => 'Print A4/Pdf  🖨', 'url' => $urlcetak],
          ],
          [
            ['text' => '📋  To Router List  📋', 'callback_data' => 'Brouter1'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);

  } elseif (strpos($command, 'PVoucher|') !== false) {
    $mdata = explode("|", $command);
    $drtr = explode("|", crouter1($mdata[1]));
    $dvcr = explode("|", cvdetail($mdata[1], $mdata[2]));
    $text = "Data Router :\n";
    $API = new RouterosAPI();
    $API->debug = false;
    if ($API->connect($drtr[1], $drtr[2], decrypt(trim($drtr[3])))) {
      $jalan = "NO";
      for ($i = 0; $i < 3; $i++) {
        $kodevcr = strtoupper(trim($dvcr[4])."-".kuser(7-strlen(trim($dvcr[4]))));
        $ARRAY = $API->comm("/ip/hotspot/user/print", ["?name" => $kodevcr,]);
        if (empty($ARRAY)) {
          $jalan = "YES";
          break;
        }
      }
      if ($jalan == "NO") {
        $text = "Proses pembuatan voucher gagal di lakukan.";
        $options = ['chat_id' => $id,
          'text' => $text,
          'parse_mode' => 'html',
        ];
        return Bot::sendMessage($text, $options);
      }
      $mtgl = date('d/m/Y');
      $mtime = date('H:i:s');
      $fdtvcr = "../webhook/data/dt".substr($mtgl, 3, 2).substr($mtgl, 6, 4).".txt";
      //simpan kemikrotik  0-di lewt 1-simpan
      //			$vfile	= "vc-BT".substr($mtgl,0,2).substr($mtgl,3,2).substr($mtgl,6,4).substr($mtime,0,2).substr($mtime,3,2);
      $vfile = "vc-Hotspot|".$id."|".$dvcr[3]."|".date('d-m-Y')." ".$dvcr[4];

      $blok = "0";
      if ($id == $id_own) {
        $blok = "1";
      }

      if ($blok == "1") {
        $add_user_api = $API->comm("/ip/hotspot/user/add", [
          "server" => 'all',
          "profile" => $dvcr[0],
          "name" => $kodevcr,
          "limit-uptime" => $dvcr[4],
          //					"limit-bytes-out" => $limit_download,
          //					"limit-bytes-in" => $limit_upload,
          //					"limit-bytes-total" => $limit_total,
          "password" => $kodevcr,
          "comment" => $vfile,
        ]);
        $cekvalidasiadd = json_encode($add_user_api);
        if (strpos(strtolower($cekvalidasiadd), '!trap')) {
          if ($API->connect($drtr[1], $drtr[2], decrypt($drtr[3]))) {
            $ARRAY2 = $API->comm("/ip/hotspot/user/remove", ["numbers" => $add_user_api,]);
          } else {
            $response = array("reply" => "Proses pembuatan mengalami gangguan,..\n\nSilahkan hub ADMIN,..\nTerimakasih.");
            echo json_encode($response);
          }
        }
      }
      $text = "Voucher ".trim($drtr[0])."\n";
      $text .= $dvcr[0]."\n";
      $text .= "[".$mtgl." ".$mtime."]\n";
      $text .= "==========================\n";
      $text .= "Voucher : ".$kodevcr."\n";
      $text .= "Paket    : ".$dvcr[0]."\n";
      $text .= "Aktif     : ".$dvcr[1]."\n";
      $text .= "Harga    : ".rupiah($dvcr[3])."\n";
      $text .= "==========================\n";
      $text .= "https://sky.net/\n";

      $urlwa = "
*Voucher* *Digital*
*MIKHMON*
----------------
Dulomo Selatan
Via Bot Telegram
https://t.me/".$bottele."
[".$mtgl." ".$mtime."]
=======================
Voucher : ".trim($drtr[0])."
Paket   : ".$dvcr[0]."
Aktif   : ".$dvcr[1]."
Harga   : ".rupiah($dvcr[3])."
=======================
Voucher : ".$kodevcr."
=======================

Login disini:
https://sky.net/login?username=".$kodevcr."%26password=".$kodevcr."

Terima Kasih dan Selamat ".sapaan();

      $mtulis = $id."|".$chatnametele.'|'.$mtgl."|".$mtime."|".$drtr[0]."|".$dvcr[0]."|".$kodevcr."|".$dvcr[2]."|".$dvcr[3]."|".$dvcr[4]."|".$dvcr[1]."|".$vfile."#\n";
      file_put_contents($fdtvcr, $mtulis, FILE_APPEND | LOCK_EX);
    } else {
      $text = "Tidak Dapat Terhubung";
      $options = ['chat_id' => $id,
        'text' => $text,
        'parse_mode' => 'html',
      ];
      return Bot::sendMessage($text, $options);
    }
    $scheme = $_SERVER['REQUEST_SCHEME'];
    if (strpos(strtolower($scheme), 'http') !== false) {
      $cekhttps = "https://";
    } else {
      $cekhttps = $scheme."://";
    }
    $urlpath = $_SERVER['REQUEST_URI'];
    $linktobot = str_replace('Core.php', 'cetak/', $urlpath);
    $urlcetak0 = $cekhttps.$_SERVER['HTTP_HOST'].$linktobot;
    $urlcetak = $urlcetak0.'voucher.php?kvoucher='.$kodevcr.'&bottele='.$bottele.'&paket='.$dvcr[0].'&mhrg='.rupiah($dvcr[3]).'/'.$dvcr[1].'&mket=Rasendria ['.$mtgl.' '.$mtime.']';
    $ShareWa = 'https://api.whatsapp.com/send?text='.$urlwa;

    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '🖨  Cetak', 'url' => $urlcetak], ['text' => 'Share WA  👀', 'url' => $ShareWa],
          ],
          [
            ['text' => '📋  To Router List  📋', 'callback_data' => 'Brouter1'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);

    //Voucer
  } elseif (strpos($command, 'BuatVcr|') !== false) {
    $mdata = explode("|", $command);
    $cdvcr = explode("|", cvdetail($mdata[1], $mdata[2]));
    $pvcr = $cdvcr[0];
    $avcr = $cdvcr[1];
    $hvcr = $cdvcr[3];
    $mvcr = $cdvcr[4];
    $text = "Selamat ".sapaan()." ".$chatnametele."\n\n";
    $text .= "Detail Voucher :\n";
    $text .= "========================\n";
    $text .= "Paket : ".trim($pvcr)."\n";
    $text .= "Harga : ".rupiah($hvcr)."\n";
    $text .= "Aktif : ".$avcr."\n";
    $text .= "========================\n";
    $text .= "Voucher Akan di PROSES ?";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '✅  YA', 'callback_data' => 'PVoucher|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'], ['text' => 'Batal  ❎', 'callback_data' => 'BVoucher|'.$mdata[1].'|'],
          ],
          [
            ['text' => '🥁  '.strtoupper($mdata[1]).'  🥁', 'callback_data' => 'Brouter'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);

    //pilihan Voucer
  } elseif (strpos($command, 'BVoucher|') !== false) {
    $mdata = explode("|", $command);
    $dvcr = cvoucher($mdata[1]);
    $text = "<b>".$mdata[1]."</b>\nSilahkan pilih Paket Voucher.\n";
    $vcr = explode("*", $dvcr);
    $text .= "--------------------------------------------------\n";
    for ($i = 1; $i < count($vcr); $i++) {
      $pvcr = explode("*", $vcr[$i]);
      $pvcr0 = explode("|", $pvcr[0]);
      $Vcr = "VCR ".substr("    ".$pvcr0[4], -3);
      $Vrp = rupiah(trim($pvcr0[3]));
      $sped = substr("   ".$pvcr0[6], strlen($pvcr0[4])-9);
      $text .= "<b>".$Vcr."  ".$sped."  ".$Vrp."</b>\n";
      $ {
        'tombol' . $i
      } = ['text' => $Vcr,
        'callback_data' => 'BuatVcr|'.$mdata[1].'|'.trim($pvcr0[0]).'|'];
    }
    $text .= ".";
    $send = [];
    $menu_idatas = [['text' => '🥁  '.strtoupper($mdata[1]).'  🥁',
      'callback_data' => 'Brouter|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'],
    ];
    $trouter1 = array_filter([$tombol1, $tombol2, $tombol3]);
    $trouter2 = array_filter([$tombol4, $tombol5, $tombol6]);
    $trouter3 = array_filter([$tombol7, $tombol8, $tombol9]);
    $trouter4 = array_filter([$tombol10, $tombol11, $tombol12]);
    $menu_idakhir = [['text' => '◀  Back to Pilihan  ▶',
      'callback_data' => 'Pilih|'.$mdata[1].'|'.$mdata[2].'|'.$mdata[3].'|'.$mdata[4].'|'],
    ];
    array_push($send, $menu_idatas);
    array_push($send, $trouter1);
    array_push($send, $trouter2);
    array_push($send, $trouter3);
    array_push($send, $trouter4);
    array_push($send, $menu_idakhir);
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => $send
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);
    //update
  } elseif (strpos($command, 'Update|') !== false) {
    $mdata = explode("|", $command);
    if ($mdata[1] == "YA") {
      $upd = cupdate();
      if (strpos($upd, 'OK|') !== false) {
        $text = "Proses Update <b>SUKSES</b> dilakukan.\nTerimakasih dan Selamat ".sapaan().".";
        $options = [
          'chat_id' => $id,
          'message_id' => (int) $message['message']['message_id'],
          'text' => $text,
          'reply_markup' => json_encode([
            'inline_keyboard' => [
              [
                ['text' => '⬅  Back To Router  ➡', 'callback_data' => 'Brouter|'],
              ],
            ]
          ]),
          'parse_mode' => 'html'
        ];
        return Bot::editMessageText($options);
      } else {
        $text = "Proses Update file <b>GAGAL</b> dilakukan , silahkan untuk di ulangi lagi.";
        $options = [
          'chat_id' => $id,
          'message_id' => (int) $message['message']['message_id'],
          'text' => $text,
          'reply_markup' => json_encode([
            'inline_keyboard' => [
              [
                ['text' => '✅  UPDATE', 'callback_data' => 'Update|YA|'],
                ['text' => 'BATAL  ❎', 'callback_data' => 'Brouter|'],
              ],
            ]
          ]),
          'parse_mode' => 'html'
        ];
        return Bot::editMessageText($options);
      }
    } else {
      $text = "Selamat ".sapaan()." ".$chatnametele."\n\nApakah Anda akan melakukan Update File yang digunakan Bot.??";
      $options = [
        'chat_id' => $id,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '✅  UPDATE', 'callback_data' => 'Update|YA|'],
              ['text' => 'BATAL  ❎', 'callback_data' => 'Brouter|'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    }
  } elseif (strpos($command, 'Krouter') !== false) {
    $mdata = explode("|", $command);
    $drouter = crouter();
    $idrouter = explode("!", $drouter);
    $cari = explode("|", webhookk());
    if ($chatidtele<>$cari[0]) {
      $text = "Selamat ".sapaan()." ".$nama."\n\n";
      $text .= "Anda tidak mempunyai Otoritas atas Informasi ini.\nTerimakasih.";
      $options = [
        'chat_id' => $id,
        'message_id' => (int) $message['message']['message_id'],
        'text' => $text,
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [
              ['text' => '◀  Back to Router List  ▶', 'callback_data' => 'Brouter'],
            ],
          ]
        ]),
        'parse_mode' => 'html'
      ];
      return Bot::editMessageText($options);
    }
    $text = "Rincian Router.\n";
    $text .= "=============================\n";
    $no = 1;
    for ($i = 0; $i < count($idrouter)-1; $i++) {
      $mrouter = $idrouter[$i];
      $router = explode("|", $mrouter);
      if ($mdata[1] == $router[0]) {
        $text .= $no.". 🖥 ".$router[0]."\nIP ".$router[1]."\n";
        $no = $no+1;
      }
      if ($mdata[1] == "") {
        $text .= $no.". 🖥 ".$router[0]."\nIP ".$router[1]."\n";
        $no = $no+1;
      }
    }
    $text .= "=============================\n";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [
            ['text' => '◀  Back to Router List  ▶', 'callback_data' => 'Brouter'],
          ],
        ]
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);
    //pilih router
  } elseif (strpos($command, 'Brouter1') !== false) {
    $drouter = crouter();
    $idrouter = explode("!", $drouter);
    $send = [];
    $no = 1;
    for ($i = 0; $i < count($idrouter)-1; $i++) {
      $mrouter = $idrouter[$i];
      $router = explode("|", $mrouter);
      $ {
        'tombol' . $i
      } = ['text' => '📚  '.$no.'. '.strtoupper($router[0]).'  📚',
        'callback_data' => 'Pilih|'.$router[0].'|'.$router[1].'|'.$router[2].'|'.$router[3].'|'];
      $no++;
    }
    $menu_idawal = [['text' => 'Pilih Router',
      'callback_data' => 'Brouter'],
    ];
    $trouter1 = array_filter([$tombol0]);
    $trouter2 = array_filter([$tombol1]);
    $trouter3 = array_filter([$tombol2]);
    $trouter4 = array_filter([$tombol3]);
    $menu_idakhir = [['text' => $i.' Router Tersedia',
      'callback_data' => 'Krouter|||'],
    ];
    array_push($send, $menu_idawal);
    array_push($send, $trouter1);
    array_push($send, $trouter2);
    array_push($send, $trouter3);
    array_push($send, $trouter4);
    array_push($send, $menu_idakhir);
    $text = "Silahkan Pilih Router Di Bawah Ini, Sebelum Melakukan Transaksi..";

    $options = [
      'chat_id' => $chatidtele,
      'reply_markup' => json_encode([
        'inline_keyboard' => $send
      ]),
      'parse_mode' => 'html'
    ];
    Bot::sendMessage($text, $options);

    //editnMESSAGE
  } elseif (strpos($command, 'Brouter') !== false) {
    $drouter = crouter();
    $idrouter = explode("!", $drouter);
    $send = [];
    $no = 1;
    for ($i = 0; $i < count($idrouter)-1; $i++) {
      $mrouter = $idrouter[$i];
      $router = explode("|", $mrouter);
      $ {
        'tombol' . $i
      } = ['text' => '📚  '.$no.'. '.strtoupper($router[0]).'  📚',
        'callback_data' => 'Pilih|'.$router[0].'|'.$router[1].'|'.$router[2].'|'.$router[3].'|'];
      $no++;
    }
    $menu_idawal = [['text' => 'Pilih Router',
      'callback_data' => 'Brouter'],
    ];
    $trouter1 = array_filter([$tombol0]);
    $trouter2 = array_filter([$tombol1]);
    $trouter3 = array_filter([$tombol2]);
    $trouter4 = array_filter([$tombol3]);
    $menu_idakhir = [['text' => '↗ Info Router ↖',
      'callback_data' => 'Krouter|||'],
    ];
    array_push($send, $menu_idawal);
    array_push($send, $trouter1);
    array_push($send, $trouter2);
    array_push($send, $trouter3);
    array_push($send, $trouter4);
    array_push($send, $menu_idakhir);
    $text = "Silahkan Pilih Router Di Bawah Ini, Sebelum Melakukan Transaksi..";
    $options = [
      'chat_id' => $chatidtele,
      'message_id' => (int) $message['message']['message_id'],
      'text' => $text,
      'reply_markup' => json_encode([
        'inline_keyboard' => $send
      ]),
      'parse_mode' => 'html'
    ];
    Bot::editMessageText($options);
  }
});

$mkbot->cmd('dbg', function ($pesan) {
  Bot::sendChatAction('typing');
  $info = bot::message();
  $idtelegram = $info['chat']['id'];
  include ('../config/system.conn.php');
  $options = ['parse_mode' => 'html',
  ];
  $text = "<code>" . json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</code>";
  return Bot::sendMessage($text, $options);
});

$mkbot->cmd('!Hide', function () {
  $text = "Command Button Di Non Aktifkan\n\nKetik Sembarang Untuk Mengaktifkan\n\nTerimakasih dan Selamat ".sapaan();
  $replyMarkup = ['keyboard' => [],
    'remove_keyboard' => true,
    'selective' => false,
  ];
  $anu['reply_markup'] = json_encode($replyMarkup);
  return Bot::sendMessage($text, $anu);
});

$mkbot->regex('/^\/reMopsEcid/', function () {
  global $datasa;
  $mikrotik_ip = $datasa['ipaddress'];
  $mikrotik_username = $datasa['user'];
  $mikrotik_password = $datasa['password'];
  $API = new routeros_api();
  $mess = Bot::Message();
  $isi = $mess['text'];
  if ($isi == '/reMopsEcid') {
    $text .= "⛔ Gagal dihapus \n\n<b>KETERANGAN   :</b>\nTidak Ditemukan Id User";
  } else {
    $id = str_replace('/reMopsEcid', '*', $isi);
    $ids = str_replace('@titawatiya', '', $id); //ubah menjadi username bot anda
    if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password)) {
      $ARRAY2 = $API->comm("/ppp/secret/remove", array("numbers" => $ids,));
      $texta = json_encode($ARRAY2);
      if (strpos(strtolower($texta), 'no such item') !== false) {
        $gagal = $ARRAY2['!trap'][0]['message'];
        $text .= "⛔ Gagal dihapus \nUser tidak ditemukan \nMohon periksa kembali  \n\n<b>KETERANGAN   :</b>\n$gagal";
      } elseif (strpos(strtolower($texta), 'invalid internal item number') !== false) {
        $gagal = $ARRAY2['!trap'][0]['message'];
        $text .= "⛔ Gagal dihapus \nId user tidak ditemuakn \Mohon periksa kembali\n\n<b>KETERANGAN   :</b>\n$gagal";
      } elseif (strpos(strtolower($texta), 'default trial user can not be removed') !== false) {
        $gagal = $ARRAY2['!trap'][0]['message'];
        $text .= "⛔ Gagal dihapus\nDefault trial tidak dapat dihapus\n\n<b>KETERANGAN   :</b>\n$gagal";
      } else {
        $text .= "Komandan, User ini Berhasil Dihapus\n\n";
        sleep(2);
        $ARRAY3 = $API->comm("/ppp/secret/print");
        $jumlah = count($ARRAY3);
        $text .= "Jumlah user saat ini : $jumlah user";
      }
    } else {
      $text = "Gagal Periksa sambungan Kerouter";
    }
  }
  $options = ['reply' => true,
    'parse_mode' => 'html',
  ];
  $texta = json_encode($isi);
  return Bot::sendMessage($text, $options);
});

$mkbot->run();
?>