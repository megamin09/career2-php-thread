<?php

/**
 * 職業実践2 - 掲示板アプリ
 */

session_start();
new Thread();

function setToken()
{
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}

function checkToken()
{
    if (empty($_SESSION['token'])) {
        echo "Sessionが空です";
        exit;
    }

    if (($_SESSION['token']) !== $_POST['token']) {
        echo "不正な投稿です。";
        exit;
    }

    $_SESSION['token'] = null;
}

if (empty($_SESSION['token'])) {
    setToken();
}
?>

<html>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">      

<link rel = "stylesheet" href = "css/style.css">

<!-- <body style = "background: linear-gradient(-45deg, rgba(246, 255, 0, .8), rgba(255, 0, 161, .8)),
  url(images/bg-cherrybrossam.jpg);
  background-size: cover;">

<head> -->

<body class = "fuchidori">

<style type="text/css">
body,td,th {font-family:"ほのかアンティーク角","ＭＳ Ｐゴシック", "Osaka", "ヒラギノ角ゴ Pro W3";font-size:14px;color: #fff;  text-stroke: 1px #000;
}
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

date_default_timezone_set('Asia/Tokyo');
const THREAD_FILE = 'thread.txt';

require_once './Thread.php';
$thread = new Thread('掲示板App');

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

echo $thread->getList();

?>

</body>
<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>


</html>