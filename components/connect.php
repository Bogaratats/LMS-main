<?php
$db_host = 'localhost';
$user_name = 'root';
$user_password = '';
$db_name = 'course_db';

   $conn = new mysqli($db_host, $user_name, $user_password, $db_name);

   function unique_id() {
      $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $rand = array();
      $length = strlen($str) - 1;
      for ($i = 0; $i < 20; $i++) {
          $n = mt_rand(0, $length);
          $rand[] = $str[$n];
      }
      return implode($rand);
   }

?>