# RXG PHP Client

This PHP class offers a rudimentary SDK for access to an rXg's RESTful API

**Note:**  Use of this library requires that the PHP cURL extension be enabled in your php.ini file. Edit the file and uncomment the following line (**remove the ; from the beginning of the line**):

`  ;extension=php_curl.dll`

### Examples
```
<?php

  require_once("Rxg_Curl_Class.php");

  #   Initialize a new instance of the Rxg_Curl_Class
  $rxg = new Rxg_Curl_Class("hostname.domain.com", "apikey");
  
  #  Create a record
  $result = $rxg->create("admins", 
    array(
      "login" => "operator", 
      "password" => '$uperP@ssword',
      "password_confirmation" => '$uperP@ssword',
      "admin_role" => 1
    )
  );
  var_dump($result);

  #  Retrieve a record
  $result = $rxg->show("wan_targets", 1);
  var_dump($result);

  #  List all records
  $result = $rxg->search("accounts");
  var_dump($result);

  #  List records filtered by search params
  $result = $rxg->search("accounts", array('first_name' => 'Romeo'));
  var_dump($result);

  #  Update a record
  $result = $rxg->update("accounts", 43, array("first_name" => 'George'));
  var_dump($result);

  #  Delete a record
  $result = $rxg->delete("accounts", 41);
  var_dump($result);

?>
```
