<?php
if (isset($_POST['topic']) && isset($_POST['count']) && isset($_POST['name'])) {
    send_notification($_POST['topic'], $_POST['count'], urldecode($_POST['name']));
}

function send_notification($topic, $count,$name)
{
    define('API_ACCESS_KEY', 'AAAAjZ8gX3g:APA91bFiRP5TRaAcxDEfaxEk4thyQ7-2qRZg2BskHZ30g93h3DC6vedrpooJvlLKF3vBsn0BLr7EkPWXBfYaKLZxxM4fJzyGU7s_kisYSNNdISiunPyfcu_gLwBHMyiy2shMlg24qC0L');
    print "\n$name - Book Count Remainder\n";
    $body = "";
    if($count>0){
        $body="There are only $count book(s) available";
    }else{
        $body="The book is not available";
    }
    print "There are only $count book(s) available";
    $msg = array
        (
        'title' => "$name - Book Count Remainder",
        'body' => $body,
        'sound' => 'notification',
    );

    $fields = array
        (
        'to' => "/topics/$topic",
        'priority' => 'high',
        'notification' => $msg,
    );

    $headers = array
        (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json',
    );
#Send Reponse To FireBase Server
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
}
