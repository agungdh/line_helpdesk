<?php
Class Welcome extends CI_Controller{
    
    var $channelAccessToken; 
    var $channelSecret;

    function __construct() {
        parent::__construct();
        $this->load->model('m_welcome');

        $this->channelAccessToken = 'mchj5ypkUUEAq2WvEMqR6BfROxk8l1JV8DvlAkNqZx6G3ZXUGq4ecN0DfqT8dr+ZiGnBZwGjdfJB0itvCcCLWR05UPoUM2ETakxFaNSmoZ9iCBpckQXL3n8krAUq35QXxuVwhb8b1AK8drhHEYI27QdB04t89/1O/w1cDnyilFU='; 
        $this->channelSecret = '2cf7003f0de82c2c18acc9389571da39';
        date_default_timezone_set("Asia/Jakarta");
    }

    function test_chat() {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        $pesan = array();
        foreach ($this->m_welcome->ambil_chat_masuk(12) as $item) {
            $profil = $client->profil($item->id_line)->displayName;
            $pesan[] = array(new DateTime($item->waktu), $profil, $item->chat);
         }
         foreach ($this->m_welcome->ambil_chat_keluar(12) as $item) {
            $pesan[] = array(new DateTime($item->waktu), $item->nama, $item->chat);
         } 
        asort($pesan);
        foreach ($pesan as $item) {
            $waktu = $item[0]->format('Y-m-d H:i:s');
            $nama = $item[1];
            $chat = $item[2];
            echo $waktu . " || " . $nama . " || " . $chat . "<br>";
        }
    }

    function index() {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        $userId     = $client->parseEvents()[0]['source']['userId'];
        $replyToken = $client->parseEvents()[0]['replyToken'];
        $timestamp  = $client->parseEvents()[0]['timestamp'];
        $message    = $client->parseEvents()[0]['message'];
        $messageid  = $client->parseEvents()[0]['message']['id'];
        $profil = $client->profil($userId);
        $pesan_datang = strtolower($message['text']);
        $pesan_datang_raw = $message['text'];
        $reply['replyToken'] = $replyToken;
        $reply['messages'][0]['type'] = 'text';

        if($message['type']=='text') {
            if (strpos($pesan_datang, 'pengaduan') !== false) { 
                $pesan_pengaduan = explode(' ', $pesan_datang_raw);
                unset($pesan_pengaduan[0]);
                array_values($pesan_pengaduan);
                $reply_pengaduan =  implode(" ", $pesan_pengaduan);

                $pengaduan = $this->m_welcome->tambah_pengaduan($userId, $reply_pengaduan, date('Y-m-d H:i:s'));
                if ($pengaduan != null) {
                    $reply['messages'][0]['text'] = "Pengaduan anda telah kami terima dan sedang menunggu antrian untuk di proses. ID pengaduan anda = " . $pengaduan;
                }
            } elseif ($pesan_datang == 'status') {
                $i = 1;
                foreach ($this->m_welcome->ambil_pengaduan($userId) as $item) {
                    if ($item->status == 0) {
                        $status = "Belum dibaca";
                    } elseif ($item->status == 1) {
                        $status = "Sedang diproses";
                    } elseif ($item->status == 2) {
                        $status = "Masalah Terselesaikan";
                    } else {
                        $status = "Error !!!";
                    }
                    $pesan_balasan = "Data Pengaduan\n";    
                    $pesan_balasan .= $i . ") " . $item->waktu . "\n";    
                    $pesan_balasan .= $item->chat."\n";    
                    $pesan_balasan .= "Status = " . $status;    
                    $i++;
                }
            } else {
                $jumlah_pengaduan = $this->m_welcome->cek_jumlah_pengaduan($userId);
                if ($jumlah_pengaduan == 0) {
                    $reply['messages'][0]['text'] = "Anda belum mengajukan aduan";
                } else {
                    $pengaduan_terakhir = $this->m_welcome->ambil_pengaduan_terakhir($userId);
                    $this->m_welcome->tambah_chat_masuk($pengaduan_terakhir, $pesan_datang_raw, date('Y-m-d H:i:s'));
                }
            }
        } else{
            $reply['messages'][0]['text'] = "Maaf, hanya teks yang dapat kami proses !!!";
        }   

        $client->replyMessage($reply);    
    }
    
}
?>


<?php 
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
    

