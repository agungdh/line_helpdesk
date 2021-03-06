<?php 
class Lapi{
    var $channelAccessToken; 
    var $channelSecret;

    function __construct() {
        $this->channelAccessToken = 'mchj5ypkUUEAq2WvEMqR6BfROxk8l1JV8DvlAkNqZx6G3ZXUGq4ecN0DfqT8dr+ZiGnBZwGjdfJB0itvCcCLWR05UPoUM2ETakxFaNSmoZ9iCBpckQXL3n8krAUq35QXxuVwhb8b1AK8drhHEYI27QdB04t89/1O/w1cDnyilFU='; 
        $this->channelSecret = '2cf7003f0de82c2c18acc9389571da39';
    }

    function append_chat($item0,$item1,$item2,$item3,$item4,$item5,$item6) {
        $src_line = null;
        if ($item5 == "local") {
            $src = base_url("assets/dist/img/avatar1.png");
            $class = "container darker";
        } elseif ($item5 == "line") {
            if ($src_line == null) {
              $src_line = $this->ambil_picture_url($item4);
            }
            $src = $src_line;
            $class = "container";
        }

        if ($item2 == "text") {
            $isi = $item3;
        } elseif ($item2 == "image") {
            if (!file_exists('gambar/'.$item6.'.jpg')) {
              $konten = $this->ambil_gambar($item6, $item3);        
            }
            $isi = '<img src="'.base_url('gambar/'.$item6).'.jpg"/>';
        }

          ?>
        <div class="<?php echo $class; ?>">
          <input type="hidden" name="<?php echo $item5.$item6; ?>" id="<?php echo $item5.$item6; ?>" value="1">
          <img class="dp" src="<?php echo $src; ?>" alt="Avatar">
          <span class="time-left"><?php echo $item1; ?></span>
          <br>
          <span class="time-left"><?php echo date("d-m-Y H:i:s", strtotime($item0)); ?></span>
          <br>
          <?php echo $isi; ?>
          <br>
        </div>
        <?php


    }

    function cek_pesan_baru($chat_masuk, $chat_keluar) {
        $pesan = array();
        foreach ($chat_masuk as $item) {
            $tipe_user = "line";
            $pesan[] = array(new DateTime($item->waktu), $tipe_user);
         }
         foreach ($chat_keluar as $item) {
            $tipe_user = "local";
            $pesan[] = array(new DateTime($item->waktu), $tipe_user);
         } 
        asort($pesan);
        rsort($pesan);

        $chat_sementara['waktu'] = array();
        $chat_sementara['tipe_user'] = array();
        
        foreach ($pesan as $item) {
            $chat_sementara['waktu'][] = $item[0]->format('Y-m-d H:i:s');
            $chat_sementara['tipe_user'][] = $item[1];
        }

        $chat = array();
        $i = 0;
        foreach ($chat_sementara['waktu'] as $item) {
            $chat[] = array($chat_sementara['waktu'][$i], $chat_sementara['tipe_user'][$i]);
            $i++;
        }

        return $chat;
    }

    function push($id_line, $text) {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        
        $push['to'] = $id_line;
        $push['messages'][0]['type'] = 'text';
        $push['messages'][0]['text'] = $text;
        $client->pushMessage($push);
    }

    function ambil_gambar($id_chat, $gambar) {
        $alamat = 'https://api.line.me/v2/bot/message/'.$gambar.'/content';
        $konten = exec_get($alamat, $this->channelAccessToken);    
        $file = fopen("gambar/".$id_chat.'.jpg',"w");
        fwrite($file,$konten);
        fclose($file);
    }

    function ambil_display_name($userId) {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        return $client->profil($userId)->displayName;
    }
 
    function ambil_picture_url($userId) {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        return $client->profil($userId)->pictureUrl;
    }

    function ambil_chat($chat_masuk, $chat_keluar) {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        $pesan = array();
        $profil = null;
        foreach ($chat_masuk as $item) {
            if ($profil == null) {
                $profil = $client->profil($item->id_line)->displayName;
            }
            $id_user = $item->id_line;
            $tipe_user = "line";
            $pesan[] = array(new DateTime($item->waktu), $profil, $item->tipe, $item->isi, $tipe_user, $id_user, $item->id);
         }
         foreach ($chat_keluar as $item) {
            $id_user = $item->id;
            $tipe_user = "local";
            $pesan[] = array(new DateTime($item->waktu), $item->nama, $item->tipe, $item->isi, $tipe_user, $id_user, $item->id);
         } 
        asort($pesan);
        rsort($pesan);

        $chat['waktu'] = array();
        $chat['nama'] = array();
        $chat['tipe'] = array();
        $chat['isi'] = array();
        $chat['id_user'] = array();
        $chat['tipe_user'] = array();
        $chat['id_chat'] = array();
        
        foreach ($pesan as $item) {
            $waktu = $item[0]->format('Y-m-d H:i:s');
            $nama = $item[1];
            $tipe = $item[2];
            $isi = $item[3];
            $tipe_user = $item[4];
            $id_user = $item[5];
            $id_chat = $item[6];
            // echo $waktu . " || " . $nama . " || " . $chat . "<br>";
            $chat['waktu'][] = $waktu;
            $chat['nama'][] = $nama;
            $chat['tipe'][] = $tipe;
            $chat['isi'][] = $isi;
            $chat['id_user'][] = $id_user;
            $chat['tipe_user'][] = $tipe_user;
            $chat['id_chat'][] = $id_chat;
        }

        return $chat;
    }

    function ambil_chat_log($chat_masuk, $chat_keluar) {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        $pesan = array();
        $profil = null;
        foreach ($chat_masuk as $item) {
            if ($profil == null) {
                $profil = $client->profil($item->id_line)->displayName;
            }
            $id_user = $item->id_line;
            $tipe_user = "line";
            $pesan[] = array(new DateTime($item->waktu), $profil, $item->tipe, $item->isi, $tipe_user, $id_user, $item->id);
         }
         foreach ($chat_keluar as $item) {
            $id_user = $item->id;
            $tipe_user = "local";
            $pesan[] = array(new DateTime($item->waktu), $item->nama, $item->tipe, $item->isi, $tipe_user, $id_user, $item->id);
         } 
        asort($pesan);
        // rsort($pesan);

        $chat['waktu'] = array();
        $chat['nama'] = array();
        $chat['tipe'] = array();
        $chat['isi'] = array();
        $chat['id_user'] = array();
        $chat['tipe_user'] = array();
        $chat['id_chat'] = array();
        
        foreach ($pesan as $item) {
            $waktu = $item[0]->format('Y-m-d H:i:s');
            $nama = $item[1];
            $tipe = $item[2];
            $isi = $item[3];
            $tipe_user = $item[4];
            $id_user = $item[5];
            $id_chat = $item[6];
            // echo $waktu . " || " . $nama . " || " . $chat . "<br>";
            $chat['waktu'][] = $waktu;
            $chat['nama'][] = $nama;
            $chat['tipe'][] = $tipe;
            $chat['isi'][] = $isi;
            $chat['id_user'][] = $id_user;
            $chat['tipe_user'][] = $tipe_user;
            $chat['id_chat'][] = $id_chat;
        }

        return $chat;
    }

 
}

if (!function_exists('hash_equals')) 
{
    defined('USE_MB_STRING') or define('USE_MB_STRING', function_exists('mb_strlen'));

    function hash_equals($knownString, $userString)
    {
        $strlen = function ($string) {
            if (USE_MB_STRING) {
                return mb_strlen($string, '8bit');
            }

            return strlen($string);
        };

        if (($length = $strlen($knownString)) !== $strlen($userString)) {
            return false;
        }

        $diff = 0;

        for ($i = 0; $i < $length; $i++) {
            $diff |= ord($knownString[$i]) ^ ord($userString[$i]);
        }
        return $diff === 0;
    }
}

class LINEBotTiny
{
    public function __construct($channelAccessToken, $channelSecret)
    {
        $this->channelAccessToken = $channelAccessToken;
        $this->channelSecret = $channelSecret;
    }
    
    


    public function parseEvents()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            error_log("Method not allowed");
            exit();
        }

        $entityBody = file_get_contents('php://input');

        if (strlen($entityBody) === 0) {
            http_response_code(400);
            error_log("Missing request body");
            exit();
        }

        if (!hash_equals($this->sign($entityBody), $_SERVER['HTTP_X_LINE_SIGNATURE'])) {
            http_response_code(400);
            error_log("Invalid signature value");
            exit();
        }

        $data = json_decode($entityBody, true);
        if (!isset($data['events'])) {
            http_response_code(400);
            error_log("Invalid request body: missing events property");
            exit();
        }
        return $data['events'];
    }

    public function replyMessage($message)
    {
        $header = array(
            "Content-Type: application/json",
            'Authorization: Bearer ' . $this->channelAccessToken,
        );

        $context = stream_context_create(array(
            "http" => array(
                "method" => "POST",
                "header" => implode("\r\n", $header),
                "content" => json_encode($message),
            ),
        ));
        $response = exec_url('https://api.line.me/v2/bot/message/reply',$this->channelAccessToken,json_encode($message));
    }
    
    public function pushMessage($message) 
    {
        
        $response = exec_url('https://api.line.me/v2/bot/message/push',$this->channelAccessToken,json_encode($message));
       
    }
    
    public function profil($userId)
    {
      
        return json_decode(exec_get('https://api.line.me/v2/bot/profile/'.$userId,$this->channelAccessToken));
       
    }

    public function ambilKonten($messageId)
    {
      
        return json_decode(exec_get('https://api.line.me/v2/bot/message/'.$messageId.'/content',$this->channelAccessToken));
       
    }

    private function sign($body)
    {
        $hash = hash_hmac('sha256', $body, $this->channelSecret, true);
        $signature = base64_encode($hash);
        return $signature;
    }
}







function exec_get($fullurl,$channelAccessToken)
{
        
        $header = array(
            "Content-Type: application/json",
            'Authorization: Bearer '.$channelAccessToken,
        );

        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);        
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $fullurl);
        
        $returned =  curl_exec($ch);
    
        return($returned);
}



function exec_url($fullurl,$channelAccessToken,$message)
{
        
        $header = array(
            "Content-Type: application/json",
            'Authorization: Bearer '.$channelAccessToken,
        );

        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $message); 
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $fullurl);
        
        $returned =  curl_exec($ch);
    
        return($returned);
}



function exec_url_aja($fullurl)
    {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_FAILONERROR, 0);
            curl_setopt($ch, CURLOPT_URL, $fullurl);
            
            $returned =  curl_exec($ch);
        
            return($returned);
    }
    

