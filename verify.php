<?php
$access_token = 'aRWr4qGLDI/6/2yk4MxpSGWfddsqej+z6AhPZYCCqzuXt72SiHptINxkZNUgIqozRlR5ujkNTNKX4KCFTBwuiIH+BSe3STs09t00QRFjByhnJ2619Y0JijlEC4WnIprSUerdjq+eO9BYSeHEURihqQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
