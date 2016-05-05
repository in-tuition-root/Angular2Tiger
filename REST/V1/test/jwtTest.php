<?php
/**
 * Created by PhpStorm.
 * User: praghav
 * Date: 5/5/2016
 * Time: 3:23 PM
 */



$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://in-tuition.com/REST/V1/public/user",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0NjI0NDE3OTQsImp0aSI6IlVDUWY3ZWdwSnlHT2xVV1R2M1lIWURMa0JBUDZ1TVJKT2EwUjlHSmxrbTg9IiwiaXNzIjoiaW4tdHVpdGlvbi5jb20iLCJuYmYiOjE0NjI0NDE4MDQsImV4cCI6MTQ2MjUyODIwNCwiZGF0YSI6eyJhY2Nlc3NMZXZlbCI6IkZ1bGwifX0.nlYYit2dk7uac94kMN1VqY0hQlg7AweoQOvXbLr7kXM",
        "mobile-number: +919891533910"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}