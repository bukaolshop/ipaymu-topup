<?php

//Masukkan secret_key yang anda dapatkan di aplikasi bukaolshop ke variabel dibawah.
$my_secret_key="xxxxxxxxxxxxxxxxxxxxxxx";
$berhasil_url="";
$batal_url="";
$notif_url="";
$nomor_va="";
$api_key_ipaymu="871AFB5C-9019-42C7-9063-537FA87A45B2";
$url_ipaymu="https://sandbox.ipaymu.com/api/v2/payment";

//Periksa bahwa data yang masuk cocok dengan secret key diatas.
if(isset($_POST['secret_callback']) && !hash_equals($_POST['secret_callback'],$my_secret_key)){
    // secret_callback tidak cocok, hentikan eksekusi program
    exit("secret key salah");
}else{
  // secret_callback tidak ada, hentikan eksekusi program
  exit("secret key salah");
}


  //check apakah data valid
  if(empty($_POST['id_user']) or
    empty($_POST['token_topup']) or
    empty($_POST['jumlah_topup']) or
    empty($_POST['kode_unik']) or
    empty($_POST['total_topup']) or
    !ctype_digit($_POST['jumlah_topup']) or
    !ctype_digit($_POST['kode_unik']) or
    !ctype_digit($_POST['total_topup'] or
    $_POST['status']!="ok")
  ){
    // data ada yang kosong atau tidak valid
    exit("data invalid");
  }

  // buat list dalam bentuk array, sesuai dokumentasi di website iPaymu.
  $produk=array();
  $qty=array();
  $harga=array();

  // Inputkan data jumlah topup
  $produk[]="TopUp Saldo Rp.".$_POST['jumlah_topup'];
  $qty[]="1";
  $harga[]=$_POST['jumlah_topup'];


  // Inputkan data biaya topup
  $produk[]="Biaya topup Rp.3500";
  $qty[]="1";
  $harga[]="3500";
  
  // Buat data body
  $body['product']    = $produk;
  $body['qty']        = $qty;
  $body['price']      = $harga;
  $body['returnUrl']  = $berhasil_url;
  $body['cancelUrl']  = $batal_url;
  $body['notifyUrl']  =  $notif_url;

  //Masukkan token_topup sebagai referenceId, token ini akan diterima kembali saat iPaymu mengirim notif ke URL callback anda, gunakan token_topup untuk mengkonfirmasi saldo member.
  $body['referenceId'] = $_POST['token_topup'];

  // Buat kode stringToSign sesuai petunjuk pada dokumentasi API iPaymu.
  $hased_body=strtolower(hash('sha256', json_encode($body)));
  $stringToSign=hash_hmac("sha256","POST:$nomor_va:$hased_body:$api_key_ipaymu",$api_key_ipaymu);

  // Buat request dengan curl
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url_ipaymu,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($body),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'signature: '.$stringToSign,
        'va: '.$nomor_va,
        'timestamp: '.gmdate('YmdHis')
      ),
    ));

    //Kirim request dengan curl
    $response = curl_exec($curl);


    if(!empty($response)){

      // convert data respon dari string ke json.
      $json_response=json_decode($response);

      // periksa apakah sukses
      if(isset($json_response->Status) and $json_response->Status=="200"){

        // periksa apakah terdapat link redirect dari iPaymu
        if(isset($json_response->Data->Url)){
          //Url redirect tersedia, karena halaman ini tidak menampilkan apapun, jadi langsung saja menampilkan halaman payment dari iPaymu.
          //Gunakan fitur redirect dengan membuat string json seperti kode dibawah:
          
          // buat array berisi parameter url
          $redirect_url=array("url"=>$json_response->Data->Url);

          //convert $redirect_url keformat json dan lakukan echo
          echo json_encode($redirect_url);


          // kode diatas akan menghasilkan {"url":"https:\/\/ipaymu.com\/payment\/xxxxxxxxxxxxxxxxxxx"}
          // Apk akan membuka link dari parameter url diatas
        }
      }
    }
    curl_close($curl);


  
  ?>
