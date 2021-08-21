<?php

header('Access-Control-Allow-Origin: *'); 

if ( isset($_POST['SubmitButton']) && isset( $_POST['email'] ) ) {
    
$email = $_POST['email'];
$name = $_POST['name'];
$make = $_POST['make'];
$model = $_POST['model'];
$year = $_POST['year'];
$PhoneNumber = $_POST['PhoneNumber'];

// First API Call Token Generation

$curl = curl_init();

$client = array();

$client["grant_type"] = "client_credentials";
$client["client_id"] = "pgkn5hodxp2uvph6fwoepaef";
$client["client_secret"] = "6vqNqS7Vj7oXhIJ7Hddlyexq";
$client["account_id"] = "xxxxxx";

$client_json = json_encode($client);

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://mcchd80-7hzv0ybjvy85cmy4zhbm.auth.marketingcloudapis.com",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $client_json,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: aeffc722-f3fc-dd45-1743-343d44885c08"
  ),
));

$response = curl_exec($curl); // Response from API
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//   print_r($response);
//   var_dump($response);
//   echo $response;
}

$resp = json_decode($response);
	// var_dump($resp);
$accessToken = $resp->access_token;

// print_r( $accessToken );

// exit;

// Initialize data to send

    $data_json = "{\n\t\"ContactKey\": \"ID603\",\n\t\"EventDefinitionKey\": \"APIEvent-90ed0bd6-5012-3212-35ec-0d14047247a5\",\n\t\"Data\": {\n\t\t\"name\": \"$name\",\n\t\t\"Email\": \"$email\",\n\t\t\"Make\": \"$make\",\n\t\t\"Model\": \"$model\",\n\t\t\"Year\": \"$year\",\n\t\t\"PhoneNumber\": \"$PhoneNumber\"\n\t}\n}";

// Second API Start Journey
    
    $curl_get = curl_init();
    
    curl_setopt_array($curl_get, array(
      CURLOPT_URL => "https://mcchd80-7hzv0ybjvy85cmy4zhbm.rest.marketingcloudapis.com/interaction/v1/events",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data_json,
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer " . $accessToken,
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 25ea9159-c209-51b2-7b25-dde622d50d03"
      ),
    ));
    
    $get_response = curl_exec($curl_get);
    $get_err = curl_error($curl_get);
    
    curl_close($curl_get);
    
    if ($get_err) {
      echo "cURL Error #:" . $get_err;
    } else {
    // echo "<pre>";
    //   print_r( $get_response );
    // echo "</pre>";
    }
    
    $get_resp = json_decode($get_response);
	// var_dump($resp);
    $eventInstanceId = $get_resp->eventInstanceId;
    // echo $eventInstanceId;
    if ( $eventInstanceId ) {
        
        echo '<script type="text/javascript">';
        echo 'function success_alert(){ Swal.fire( "Email Sent Sucessfully!", "Thanks for Subscription!", "success" ); }';
        echo '</script>';
        
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Journey Builder API</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  
  <style>
      body {
          background-color: #C0EBFC;
      }
  </style>
</head>
<body onload="success_alert();">

<div class="container">

<div class="row text-center">
    <div class="offset-4 col-4">
        <img class="img-fluid" src="images/sfmc_logo.png">
    </div>
</div>

  <h2>Journey API Event</h2>
  <form method="post">
    
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
    </div>
    
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
    </div>
    
    <div class="form-group">
      <label for="make">Make:</label>
      <input type="text" class="form-control" id="make" placeholder="Make" name="make" required>
    </div>
    
    <div class="form-group">
      <label for="model">Model:</label>
      <input type="text" class="form-control" id="model" placeholder="Model" name="model" required>
    </div>
    
    <div class="form-group">
      <label for="year">Year:</label>
      <input type="text" class="form-control" id="year" placeholder="Year" name="year" required>
    </div>
    
    <div class="form-group">
      <label for="PhoneNumber">Phone Number:</label>
      <input type="tel" class="form-control" id="PhoneNumber" placeholder="Phone Number" name="PhoneNumber" required>
    </div>
    
    <input type="submit" id="submit" name="SubmitButton" value="Submit" class="btn btn-primary">
    
  </form>
</div>

</body>
</html>
