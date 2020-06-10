$txt_box_file = 'txt_box.txt';
    //ファイルが存在しない場合作成する
    if(! file_exists($txt_box_file) )
    {
        $fp = fopen($txt_box_file, 'w');
        fwrite($fp, 0 );
        fclose($fp);
    }
    //読み込みと書き込みができる状態でファイルを開く
    $fp = fopen( $txt_box_file, 'r+' );

   // fweit( $fp, $name );

    echo fread($fp, filesize($txt_box_file));

    fclose($fp);