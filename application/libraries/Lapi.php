<?php 
 
class Lapi{
    var $channelAccessToken; 
    var $channelSecret;

    function __construct() {
        $this->channelAccessToken = 'mchj5ypkUUEAq2WvEMqR6BfROxk8l1JV8DvlAkNqZx6G3ZXUGq4ecN0DfqT8dr+ZiGnBZwGjdfJB0itvCcCLWR05UPoUM2ETakxFaNSmoZ9iCBpckQXL3n8krAUq35QXxuVwhb8b1AK8drhHEYI27QdB04t89/1O/w1cDnyilFU='; 
        $this->channelSecret = '2cf7003f0de82c2c18acc9389571da39';
    }

    function ambil_display_name($userId) {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        return $client->profil($userId)->displayName;
    }
 
    function ambil_picture_url($userId) {
        $client     = new LINEBotTiny($this->channelAccessToken, $this->channelSecret);
        return $client->profil($userId)->pictureUrl;
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
    

