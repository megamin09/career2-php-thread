<?php

$txt_box_file = 'txt_box.txt';

$fp = fopen($txt_box_file, 'w');
//なにもデータがない場合0を代入しておく
fwrite($fp, "　");
fclose($fp);

require '../index.php.php';