<?php

namespace YakovHrebtov\bothub;

require(__DIR__.'/logic.php');

class Bothub
{
    private const BOT_TOKEN = '7400225322:AAGhCUdIz1O8YX22ySfsWxSoaB83KyYumXA';

    private function sendMessage($chatID, $msg) 
    {
        $query = array(
            "chat_id" => $chatID,
            "text" => $msg,
            "parse_mode" => "html",
        );
        $curl = curl_init("https://api.telegram.org/bot".self::BOT_TOKEN."/sendMessage?".http_build_query($query));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $resultQuery = curl_exec($curl);
        curl_close($curl);
        
        //echo $resultQuery;
    }

    private function getMessage()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $chatID = $data['message']['chat']['id'];
        $chatName = $data['message']['chat']['first_name'].' '.$data['message']['chat']['last_name'];
        $message = $data['message']['text'];

        return [
            'chat_id' => $chatID,
            'chat_name' => $chatName,
            'message' => $message,
        ];
    }

    public function process()
    {
        $tFields = $this->getMessage();
        
        if (!isset($tFields['chat_id']) || !isset($tFields['message'])) {
            echo('die');
            die();
        }

        $reply = Logic::processMessage($tFields);

        if (isset($reply)) {
            $this->sendMessage($tFields['chat_id'], $reply);
        }    
    }
}



$bothub = new Bothub();
$bothub->process();
