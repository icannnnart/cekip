<?php
error_reporting(0);
echo "\n + ==================+\n\n";
echo " Proxy Checker & Ip Address Checker \n";
echo " Create : icannnart \n";
echo " Proxy Chekcer  [1] \n";
echo " Ip Address Checker [2] \n\n";
echo " + ===================+\n";
echo "\nPilih 1 / 2: ";
$pilih = trim(fgets(STDIN));
if ($pilih == 1) {
   echo "\nList Proxy: ";
$argv = trim(fgets(STDIN));
    if(file_exists($argv)) {
        $ambil = explode(PHP_EOL, file_get_contents($argv));
        foreach($ambil as $targets) {
            cekip($targets);
          
        }
    }else die("File doesn't exist!");
} elseif ($pilih == 2) {
$url = "https://ipinfo.io/?token=";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Host: ipinfo.io",
   "Accept: application/json, text/javascript, */*; q=0.01",
   "Origin: https://app.emailable.com",
   "Sec-Fetch-Mode: cors",
   "Sec-Fetch-Dest: empty",
   "Referer: https://app.emailable.com/",
   "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
$mentah = json_decode($resp);
$ip = $mentah->ip;
$region = $mentah->region;
$country = $mentah->country;
$zip = $mentah->postal;
$data = array('ipnya' => $ip,
                  'lokasi' => $region,
                  'kode_negara' => $country,
                  'kode_pos' => $zip, );
  $en = json_encode($data);
  print_r("\n".$en.PHP_EOL);
}
else{
   print_r("\nPILIH YANG BENER BANG\n");
}



function cekip($ipnya)
{
  $url = "https://ipinfo.io/?token=";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Host: ipinfo.io",
   "Accept: application/json, text/javascript, */*; q=0.01",
   "Origin: https://app.emailable.com",
   "Sec-Fetch-Mode: cors",
   "Sec-Fetch-Dest: empty",
   "Referer: https://app.emailable.com/",
   "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_PROXY, $ipnya);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT_MS, 10000);

$resp = curl_exec($curl);
curl_close($curl);
$mentah = json_decode($resp);
$ip = $mentah->ip;
$region = $mentah->region;
$country = $mentah->country;
$zip = $mentah->postal;
$data = array('ipnya' => $ip,
                  'lokasi' => $region,
                  'kode_negara' => $country,
                  'kode_pos' => $zip, );
  $en = json_encode($data);
if ($resp == NULL) {

  echo "[ TIME OUT ]\n";
}elseif (!strpos($resp, 'error')) {
  print_r("[ LIVE ] IP : $ip | Lokasi : $region | Kode Negara : $country | Kode Pos : $zip".PHP_EOL);
  file_put_contents('live_proxy.txt', $ipnya.PHP_EOL, FILE_APPEND);
} else {
   print_r("[ ERROR ]\n");
}
}

?>

