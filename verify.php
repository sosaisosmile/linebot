<?php
$access_token = 'j5Txw/zGl6lJo2/nFBnTdT1wGudlv/Vp4HiX0n/mj4pVICHO1HMCZUaxs9d6T11sCaDT80+X/+xCq154oWZBR3CTYZw9zAazJXiNZ8icFxW3os3AR8YFJsl1k3pK/OrNxVpiKQdNBP0p4hNGxDhVpwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
