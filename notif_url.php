<?php


if(isset($_POST['trx_id']) and isset($_POST['sid'])){

  $transaksi_id=$_POST['trx_id'];

  $body=json_encode(array('transactionId' => $transaksi_id));
  $hased_body=strtolower(hash('sha256', $body));
  $stringToSign=hash_hmac("sha256","POST:0000001973472101:$hased_body:871AFB5C-9019-42C7-9063-537FA87A45B2","871AFB5C-9019-42C7-9063-537FA87A45B2");

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sandbox.ipaymu.com/api/v2/transaction',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'signature: '.$stringToSign,
      'va: 0000001973472101',
      'timestamp: '.gmdate('YmdHis')
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  $json_response=json_decode($response);
  if($json_response->Status=="200" and isset($json_response->Data)){
    if($json_response->Data->Status=="1" and $json_response->Data->StatusDesc=="Berhasil"){

      $token_topup=$json_response->Data->ReferenceId;
      $token="T0Z6bnlHMDQ5c25YeWNiZTNFbEFvMXYwVngrS2JidnprMGhkeU1tdkNnOTZUZkhCMy9SRXVIWnlwMGN1TlVuVA==";


      $header=  array("Authorization: Bearer ".$token );
      
      $post_body=array(
        "token_topup"=>$token_topup,
      );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"https://bukaolshop.net/api/v1/member/topup");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $hasil = curl_exec($ch);
      curl_close ($ch);
 

    }
  }
}


?>
