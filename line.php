 <?php
  

function send_LINE($msg){
 $access_token = 'aRWr4qGLDI/6/2yk4MxpSGWfddsqej+z6AhPZYCCqzuXt72SiHptINxkZNUgIqozRlR5ujkNTNKX4KCFTBwuiIH+BSe3STs09t00QRFjByhnJ2619Y0JijlEC4WnIprSUerdjq+eO9BYSeHEURihqQdB04t89/1O/w1cDnyilFU='; 

  $messages = [
        'type' => 'text',
        'text' => $msg
        //'text' => $text
      ];

      // Make a POST Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/push';
      $data = [

        'to' => 'Ubaca73f18710efc62f5f5a6e987f65e4',
        'messages' => [$messages],
      ];
      $post = json_encode($data);
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $result . "\r\n"; 
}

?>
