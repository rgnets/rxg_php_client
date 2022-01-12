<?php

class Rxg_Curl_Class {
  var $endpointUrl;
  var $apiKey;
  var $curl_handler;
  
  var $defaults = array(
      CURLOPT_HEADER => 0,
      // CURLOPT_FRESH_CONNECT => 1,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_SSL_VERIFYPEER => false,  // ssl fix
      CURLOPT_SSL_VERIFYHOST => false // ssl fix
    );
  
  //constructor saves the values
  function __construct($hostname, $key) {
    $this->endpointUrl="https://$hostname/admin/scaffolds/";
    $this->apiKey=$key;
  }

  function get($url) {
    $curl_handler = curl_init();
    $params = array("api_key" => $this->apiKey);
    $options = array(CURLOPT_URL => $url."?".http_build_query($params));
    curl_setopt_array($curl_handler, ($this->defaults + $options));
    
    $result = curl_exec($curl_handler);
    if (!$result) {
      die(curl_error($curl_handler));
    }
    
    $responseCode = curl_getinfo($curl_handler, CURLINFO_RESPONSE_CODE);
    if ($responseCode != 200) {
      print "Response Code: $responseCode -- $result";
      return $result;
    } else {
      $jsonResponse = json_decode($result, true);
      return $jsonResponse;
    }
  }

  function post($url, $fields = array()) {
    $curl_handler = curl_init();
    $params = array("api_key" => $this->apiKey);
    $options = array(
      CURLOPT_URL => $url."?".http_build_query($params),
      CURLOPT_POST => count($fields),
      CURLOPT_POSTFIELDS => http_build_query($fields)
    );
    curl_setopt_array($curl_handler, ($this->defaults + $options));
    
    $result = curl_exec($curl_handler);
    if (!$result) {
      die(curl_error($curl_handler));
    }
    $responseCode = curl_getinfo($curl_handler, CURLINFO_RESPONSE_CODE);
    if ($responseCode != 200) {
      print "Response Code: $responseCode -- $result";
      return $result;
    } else {
      $jsonResponse = json_decode($result, true);
      return $jsonResponse;
    }
    
  }

  function create($scaffold, $record) {
    $result = $this->post($this->endpointUrl.$scaffold."/create.json", array("record" => $record));
    return $result;
  }

  function search($scaffold, $search_params = array()) {
    $result = $this->post($this->endpointUrl.$scaffold."/list.json", $search_params);
    return $result;
  }

  function show($scaffold, $id) {
    $result = $this->get($this->endpointUrl.$scaffold."/".$id.".json");
    return $result;
  }

  function update($scaffold, $id, $record) {
    $result = $this->post($this->endpointUrl.$scaffold."/update/".$id.".json", array("record" => $record));
    return $result;
  }

  function delete($scaffold, $id) {
    $result = $this->post($this->endpointUrl.$scaffold."/destroy/".$id.".json");
    return $result;
  }

}

?>
