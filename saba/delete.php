<?php

$txt_box_file = '../txt_box.txt';

$fp = fopen($txt_box_file, 'w');
//なにもデータがない場合なにもいれない
fwrite($fp, "");
fclose($fp);

header( "Location: ./../index.php" ) ;
exit ;