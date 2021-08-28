<?php

//Masukkan secret_key yang anda dapatkan di bagian callback, aplikasi bukaOlshop.
$my_secret_key="2ea8538fc6e2aea84d4c9f47aaf3b025";

//Masukkan api key bukaOlshop
$api_key_bukaolshop="T0Z6bnlHMDQ5c25YeWNiZTNFbEFvMXYwVngrS2JidnprMGhkeU1tdkNnOTZUZkhCMy9SRXVIWnlwMGN1TlVuVA==";

// Masukkan url redirect ipaymu
$berhasil_url="https://bukaolshop.my.id/topup/berhasil_url.php?bukaolshop_finish_page=true";
$batal_url="https://bukaolshop.my.id/topup/batal_url.php?bukaolshop_finish_page=true";
$notif_url="https://bukaolshop.my.id/topup/notif_url.php";

// Setting api key ipaymu
$nomor_va="0000001973472101";
$api_key_ipaymu="871AFB5C-9019-42C7-9063-537FA87A45B2";

// Setting endpoint ipaymu
$url_ipaymu_create="https://sandbox.ipaymu.com/api/v2/payment";
$url_ipaymu_check="https://sandbox.ipaymu.com/api/v2/transaction";


// Setting database mySQL
$server="localhost";
$username="bukaolsh_topup";
$password_sql="bukaolshop123";
$nama_database="bukaolsh_topup";


?>