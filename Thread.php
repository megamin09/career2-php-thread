<?php

class Thread 
{

    private $name;
    private const THREAD_FILE = 'thread.txt';

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getList()
    {
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
    }

    public function post( string $name_box, string $txt_box ) 
    {
        $txt_box_file = 'txt_box.txt';
        // $name_box = $_POST["name"];
        // $txt_box = $_POST["box"];

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
        fclose($fp);
    }

    public function delete() 
    {
        $txt_box_file = 'txt_box.txt';

        $fp = fopen($txt_box_file, 'w');
        //なにもデータがない場合なにもいれない
        fwrite($fp, "");
        fclose($fp);

        exit ;
    }
}