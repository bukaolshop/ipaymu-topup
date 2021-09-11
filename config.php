<?php

//Masukkan api key bukaOlshop
$api_key_bukaolshop="T0Z6bnlHMDQ5c25YeWNiZTNFbEFvMXYwVngrS2JidnprMGhkeU1tdkNnOTZUZkhCMy9SRXVIWnlwMGN1TlVuVA==";

//Masukkan secret_key yang anda dapatkan di bagian callback, aplikasi bukaOlshop.
$my_secret_key="2ea8538fc6e2aea84d4c9f47aaf3b025";


// Masukkan url redirect ipaymu
// Pastikan ketiga URL dibawah dapat diakses. Jika anda mendapati halaman 404 maka artinya url anda salah.
// Pada URL $berhasil_url dan $batal_url, selalu sertakan parameter bukaolshop_finish_page=true untuk mencegah user ke halaman sebelumnya.
$berhasil_url="https://bukaolshop.my.id/topup/berhasil_url.php?bukaolshop_finish_page=true";
$batal_url="https://bukaolshop.my.id/topup/batal_url.php?bukaolshop_finish_page=true";
$notif_url="https://bukaolshop.my.id/topup/notif_url.php";

// Setting api key ipaymu
$nomor_va="0000001973472101";
$api_key_ipaymu="871AFB5C-9019-42C7-9063-537FA87A45B2";

// Setting endpoint ipaymu, kode dibawah merupakan URL sandbox.
// Untuk beralih ke mode produksi, ganti tulisan "sandbox" dengan "my"
// Contoh : https://my.ipaymu.com/api/v2/payment
$url_ipaymu_create="https://sandbox.ipaymu.com/api/v2/payment";
$url_ipaymu_check="https://sandbox.ipaymu.com/api/v2/transaction";


// Setting database mySQL
$server="localhost";
$username="bukaolsh_topup";
$password_sql="bukaolshop123";
$nama_database="bukaolsh_topup";


?>