 <?php
 function pubMqtt($topic,$msg){
       $APPID= "JARVISLED/"; //enter your appid
     $KEY = "3y6lKWs3EHtF72s"; //enter your key
    $SECRET = "Qy4fZypRGpw7G8dSvc5dy3UlP"; //enter your secret
    $Topic = "$topic"; 
      //put("https://api.netpie.io/Topic/JARVISLED/".$APPID.$Topic."?retain&auth=".$KEY.":".$SECRET,$msg);
    put("https://api.netpie.io/microgear/".$APPID.$Topic."?retain&auth=".$KEY.":".$SECRET,$msg);
 
  }
 function getMqttfromlineMsg($Topic,$lineMsg){
 
    $pos = strpos($lineMsg, ":");
    if($pos){
      $splitMsg = explode(":", $lineMsg);
      $topic = $splitMsg[0];
      $msg = $splitMsg[1];
      pubMqtt($topic,$msg);
    }else{
      $topic = $Topic;
      $msg = $lineMsg;
      pubMqtt($topic,$msg);
    }
  }
 
  function put($url,$tmsg)
{
      
    $ch = curl_init($url);
 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $tmsg);
 
    //curl_setopt($ch, CURLOPT_USERPWD, "mJ7K4MfteC7p0dW:pp4gzMhCvJIqlxc66hKEvk46m");
     
    $response = curl_exec($ch);
    
      curl_close($ch);
      echo $response . "\r\n";
    return $response;
}
// $Topic = "NODEMCU";
 //$lineMsg = "CHECK";
 //getMqttfromlineMsg($Topic,$lineMsg);
?>
