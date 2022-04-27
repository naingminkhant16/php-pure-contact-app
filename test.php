<?php
// echo preg_match("/^[a-zA-Z ]*$/","NMk ");

$str=password_hash('fffdfdfdd',PASSWORD_DEFAULT);
// echo $str;
echo password_verify("fffdfdfdd",'$2y$10$0oi1K/vT6oim1YfCpYOzs.nm3MQrRBjcXgQOclvp3JGqCgyzWp.IO');