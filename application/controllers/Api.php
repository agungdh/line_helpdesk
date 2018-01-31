<?php
Class Api extends CI_Controller{
    
    var $channelAccessToken; 
    var $channelSecret;

    function __construct() {
        parent::__construct();
        $this->load->model('m_pelayanan');
        $this->load->model('m_api');
        // $this->load->library('lapi');
        $this->load->library('pustaka');
        $this->load->library('email');

        $this->channelAccessToken = 'mchj5ypkUUEAq2WvEMqR6BfROxk8l1JV8DvlAkNqZx6G3ZXUGq4ecN0DfqT8dr+ZiGnBZwGjdfJB0itvCcCLWR05UPoUM2ETakxFaNSmoZ9iCBpckQXL3n8krAUq35QXxuVwhb8b1AK8drhHEYI27QdB04t89/1O/w1cDnyilFU='; 
        $this->channelSecret = '2cf7003f0de82c2c18acc9389571da39';
        date_default_timezone_set("Asia/Jakarta");
    }

    function gambar($param_messageid) {
        $alamat = 'https://api.line.me/v2/bot/message/'.$param_messageid.'/content';
        $konten = exec_get($alamat, $this->channelAccessToken);    
        
        echo '<img src="data:image;base64,'.base64_encode( $konten ).'"/>';
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

        if($message['type']=='text' || $message['type']=='image') {
            if (strpos($pesan_datang, 'pelayanan') !== false) { 
                $jumlah_pelayanan = $this->m_api->cek_jumlah_pelayanan_aktif($userId);
                if ($jumlah_pelayanan != 0) {
                    $reply['messages'][0]['text'] = "Anda masih mempunyai pelayanan yang belum terselesaikan, anda dapat mengirim pelayanan baru jika pengeduan sebelumnya telah terselesaikan";
                } else {
                    $pesan_pelayanan = explode('#', $pesan_datang_raw);

                    $pelayanan = $this->m_api->tambah_pelayanan($userId, $pesan_pelayanan[1], $pesan_pelayanan[2], date('Y-m-d H:i:s'));
                    if ($pelayanan != null) {
                        $reply['messages'][0]['text'] = "pelayanan anda telah kami terima dan sedang menunggu antrian untuk di proses. ID pelayanan anda = " . $pelayanan;
                    }                    
                }  
            } if (strpos($pesan_datang, 'status') !== false) { 
                $pesan_status = explode('#', $pesan_datang_raw);
                if (count($pesan_status) == 1) {
                    $pesan_balasan = "Data pelayanan\n";    
                    foreach ($this->m_api->ambil_semua_pelayanan($userId) as $item) {
                        if ($item->status == 0) {
                            $status = "Belum Diproses";
                        } elseif ($item->status == 1) {
                            $status = "Sedang diproses";
                        } elseif ($item->status == 2) {
                            $status = "Selesai";
                        } else {
                            $status = "Error !!!";
                        }
                        $pesan_balasan .= 'Pelayanan dengan nomor ' . $item->id . "\n";    
                        $pesan_balasan .= $item->waktu . "\n";    
                        $pesan_balasan .= $item->pelayanan . "\n";    
                        $pesan_balasan .= "Status = " . $status . "\n";                        
                    }
                } elseif (count($pesan_status) == 2) {
                    $item = $this->m_api->ambil_pelayanan_id($pesan_status[1]);
                    if ($item == null) {
                        $pesan_balasan = "Pelayanan tidak ada";
                    } else {
                        if ($item->status == 0) {
                            $status = "Belum Diproses";
                        } elseif ($item->status == 1) {
                            $status = "Sedang diproses";
                        } elseif ($item->status == 2) {
                            $status = "Selesai";
                        } else {
                            $status = "Error !!!";
                        }
                        
                        $pesan_balasan .= 'Pelayanan dengan nomor ' . $item->id . "\n";    
                        $pesan_balasan .= $item->waktu . "\n";    
                        $pesan_balasan .= $item->pelayanan . "\n";    
                        $pesan_balasan .= "Status = " . $status . "\n";                        
                    }
                } elseif (count($pesan_status) == 3) {
                    $id_pelayanan = $pesan_status[1];
                    $data_pelayanan = $this->m_pelayanan->ambil_pelayanan($id_pelayanan);
                    $to = $pesan_status[2];
                    $from_nama = 'AgungDH';
                    $from_email = 'agungdh@agungdh.com';
                    $subject = $data_pelayanan->pelayanan;

                    $params_curl = '?'.
                                    'id_pelayanan='.$id_pelayanan.'&'.
                                    'to='.$to.'&'.
                                    'from_nama='.$from_nama.'&'.
                                    'from_email='.$from_email.'&'.
                                    'subject='.$subject;
                    $params_curl = str_replace(" ", '%20', $params_curl);
                    $ch = curl_init(base_url('pelayanan/kirim_email/' . $params_curl));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);

                    $pesan_balasan = 'Email terkirim';
                } else {
                    $pesan_balasan = "Error !!!";
                }
                $reply['messages'][0]['text'] = $pesan_balasan;    
            } elseif ($pesan_datang == 'cekuser') {
                $pesan_balasan = "ID User = " . $userId;    

                $reply['messages'][0]['text'] = $pesan_balasan;    
            } else {
                $jumlah_pelayanan = $this->m_api->cek_jumlah_pelayanan_aktif($userId);
                if ($jumlah_pelayanan == 0) {
                    $reply['messages'][0]['text'] = "Anda belum mengajukan aduan";
                    $reply['messages'][0]['text'] .= "\n";
                    foreach ($this->m_api->ambil_data_layanan() as $item) {
                        $reply['messages'][0]['text'] .= $item->id . ") " . $item->layanan . "\n";
                    }
                } else {
                    $pelayanan_terakhir = $this->m_api->ambil_pelayanan_terakhir($userId);
                    if($message['type']=='text') {
                        $this->m_api->tambah_chat_masuk($pelayanan_terakhir, $message['type'], $pesan_datang_raw, date('Y-m-d H:i:s'));
                    } else {
                        $this->m_api->tambah_chat_masuk($pelayanan_terakhir, $message['type'], $messageid, date('Y-m-d H:i:s'));
                    }
                }
            }
        } else{
            $reply['messages'][0]['text'] = "Jenis Pesan Yang Diizinkan Hanyalah Teks dan Gambar !!!";
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
    

