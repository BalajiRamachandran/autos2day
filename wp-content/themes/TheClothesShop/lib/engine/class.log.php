<?php
Class log { 
  // 
  function get_error_log($type, $file=''){
    if ( $_SERVER['DOCUMENT_ROOT'] != '') {
      $tmp_dir = $_SERVER['DOCUMENT_ROOT'] . "/logs";
      if ( !file_exists($tmp_dir)) {
          if ( ! mkdir($tmp_dir, 0655) ) {
            $tmp_dir = $_SERVER['DOCUMENT_ROOT'];
          }
      }
    } else {
      $tmp_dir = sys_get_temp_dir();
    }
    if ( $file ) {
      $filename = $file;      
    } else {
      $filename = 'no_file_';
    }
    switch($type) {
      case 'user' :
        $filename .= $_SERVER["HTTP_HOST"] . "_" . 'Site_User_errors_' . date('Ymd');

        return $tmp_dir . '/' . $filename . '.log'; 
      break;
      case 'general' :
        $filename .= $_SERVER["HTTP_HOST"] . "_" . 'Site_General_errors_'  . date('Ymd');
        return $tmp_dir . '/' . $filename . '.log'; 
      break;
    } 
  }
  /* 
   User Errors... 
  */ 
    public function user($msg,$username) 
    { 
    date_default_timezone_set(get_option('timezone_string'));
    $date = date('d.m.Y h:i:s'); 
    $log = "Date:  ". $date . " | " . $msg . " | User: ".$username."\r\n"; 
    error_log($log, 3, self::get_error_log('user')); 
    } 
    /* 
   General Errors... 
  */ 
    public function general($msg, $file='') 
    { 
    $date = date('d.m.Y h:i:s'); 
    $log = "Date: " . $date . " | " . $msg ."\r\n"; 
    error_log($log, 3, self::get_error_log('general', $file)); 
    } 
} 
?>