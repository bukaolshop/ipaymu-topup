<?php
// $_POST['status']="ok";
// $_POST['id_user'] = "9";
// $_POST['token_topup'] = "6e03886c7171ae6c2ea8";
//  $_POST['jumlah_topup'] = "150000";
//  $_POST['kode_unik'] = "135";
//   $_POST['total_topup'] = "150135";

if(isset($_POST['status']) && $_POST['status']=="ok" && isset($_POST['id_user'])){

  //check apakah data valid
  if(empty($_POST['id_user']) or
    empty($_POST['token_topup']) or
    empty($_POST['jumlah_topup']) or
    empty($_POST['kode_unik']) or
    empty($_POST['total_topup']) or
    !ctype_digit($_POST['jumlah_topup']) or
    !ctype_digit($_POST['kode_unik']) or
    !ctype_digit($_POST['total_topup'])
  ){
    exit("data invalid");
  }

  $produk=array();
  $qty=array();
  $harga=array();

  $produk[]="TopUp Saldo Rp.".$_POST['jumlah_topup'];
  $qty[]="1";
  $harga[]=$_POST['jumlah_topup'];
  if($_POST['kode_unik']>0){
    $produk[]="Kode unik Rp.".$_POST['kode_unik'];
    $qty[]="1";
    $harga[]=$_POST['kode_unik'];
  }

  $curl = curl_init();
  $body['product']    = $produk;
  $body['qty']        = $qty;
  $body['price']      = $harga;
  $body['returnUrl']  = 'https://testing.bukaolshop.net/topup_override/berhasil.php?bukaolshop_finish_page=true';
  $body['cancelUrl']  = 'https://testing.bukaolshop.net/topup_override/batal.php?bukaolshop_finish_page=true';
  $body['notifyUrl']  = 'https://testing.bukaolshop.net/notify.php';
  $body['referenceId'] = $_POST['token_topup'];
  $hased_body=strtolower(hash('sha256', json_encode($body,JSON_UNESCAPED_SLASHES)));

  $stringToSign=hash_hmac("sha256","POST:0000001973472101:$hased_body:871AFB5C-9019-42C7-9063-537FA87A45B2","871AFB5C-9019-42C7-9063-537FA87A45B2");


  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sandbox.ipaymu.com/api/v2/payment',
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
        'va: 0000001973472101',
        'timestamp: '.gmdate('YmdHis')
      ),
    ));

    $response = curl_exec($curl);

    if(!empty($response)){
      $json_response=json_decode($response);
      if(isset($json_response->Status) and $json_response->Status=="200"){
        if(isset($json_response->Data->Url)){
          echo json_encode(array("url"=>$json_response->Data->Url,"id"=>$json_response->Data->SessionID));
        }
      }
    }
    curl_close($curl);


  }
  ?>
