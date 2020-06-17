<html>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">      

<head>
<style type="text/css">
body,td,th {font-family:"ほのかアンティーク角","ＭＳ Ｐゴシック", "Osaka", "ヒラギノ角ゴ Pro W3";font-size:14px;}
</style>
</head>

<head><title>掲示板</title></head>

<h1>掲示板App<h1>

<h2>投稿フォーム</h2>

<form action="index.php" method="POST">
    <input type="text" name="name" placeholder = "名前" required >
    <br><br>
    <textarea name="box" rows="8" cols="40" placeholder = "内容" required ></textarea>
    <br><br>
    <input type="submit"　name="btn1" value="投稿する" >
</form>

<h2>スレッド</h2>

<form method="POST" action="saba/delete.php">
    <button type="submit">投稿を全削除する</button>
</form>

<?php

function WRITE_data()
{
    $txt_box_file = 'txt_box.txt';
    $name_box = $_POST["name"];
    $txt_box = $_POST["box"];

    //echo '投稿者:'.$name_box.'<br>';
    //echo 'コメント<br>'.$txt_box;

    //ファイルが存在しない場合作成する
    if(! file_exists($txt_box_file) )
    {
        $fp = fopen($txt_box_file, 'w');
        fclose($fp);
    }
    //読み込みと書き込みができる状態でファイルを開く
    $fp = fopen( $txt_box_file, 'ab' );
    fwrite( $fp, date( "Y/m/d H:i:s" ).", " );
    fwrite( $fp, $name_box.", " );
    //$txt_box = nl2br($txt_box);
    $txt_box = str_replace( "\r\n", "< br >", $txt_box );
    $txt_box = str_replace( "\n", "< br >", $txt_box );
    $txt_box = str_replace( "\r", "< br >", $txt_box );
    fwrite( $fp, $txt_box."\n" );
    // fputcsv( $fp, $txt_box );

    $_POST = array();
    
    // //二重投稿を防ぐため
    // header('Location: ./');

    // ブラウザのリロード対策
    $redirect_url = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect_url");
    exit;

    fclose($fp);
}

//送信があったら実行
if( $_SERVER["REQUEST_METHOD"] === "POST" && array_key_exists('name', $_POST) )
{
    WRITE_data();
}

//ファイルの有無を確認
if( file_exists("txt_box.txt") )
{
    $fp = fopen("txt_box.txt", 'r');

    while($line = fgetcsv($fp))
    {
        // 読み込んだ結果を表示します。
        if( $line[0]=== "　" )
        {
            //データがなかったため表示させない
            break;
        }

        $id = 0;
        $data = "<hr>";
        $data = $data.'<p>投稿日時: '.$line[$id].'<br></p>';
        $id++;
        $data = $data.'<p>投稿者: '.$line[$id].'</p>';
        $data = $data.'<p>内容</p>';
        $id++;
        $line[$id] = str_replace( "< br >", "\n", $line[$id] );
        // $line[$id] = str_replace( "\n", "< br >", $line[$id] );
        // $line[$id] = str_replace( "\r", "< br>", $line[$id] );
        $line[$id] = nl2br($line[$id]);
        $data = $data.'<p>'.$line[$id]."<br></p>";

        echo $data;
    }

    fclose($fp);
}


?>


</html>