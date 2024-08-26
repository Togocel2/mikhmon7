<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['message' => 'nothing to do']);
    exit(0);
}
header('HTTP/1.1 200 OK');
$body = file_get_contents('php://input');
$file="corewalog.txt";
file_put_contents($file, $body."#\n", FILE_APPEND | LOCK_EX);
require_once '../config/system.conn.php';

$data1="[".ltrim($body)."]";
$json = json_decode($data1, TRUE);

for ($a=0 ; $a<count($json) ; $a++ ) {
	if ($json[$a]['webhook_type']=="send_message_response") {
		$nomor=$json[$a]['payload']['phone_number'];
	}elseif ($json[$a]['webhook_type']=="incoming_message") {
		$nomor	=$json[$a]['payload']['sender'];
		$pesan	=$json[$a]['payload']['text'];
		$groupid=$json[$a]['payload']['group_id'];
		$balas	=$json[$a]['payload']['from_me'];
		if ($json[$a]['payload']['is_group_message']<>'true') {
			$pesan1="Pesan ini dikirim dari file corewa.php\nPesan : ".$pesan."\nTerimakasih dan Selamat ".sapaan();
			$test=kirimwa($nomor,$pesan1,$device,$logo);
		}
	}	
}
?>