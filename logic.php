<?php

namespace YakovHrebtov\bothub;

require(__DIR__.'/DB.php');

class Logic
{
    public static function processMessage($tFields)
    {
        //file_put_contents(__DIR__.'/tmp/test.file', print_r($tFields, true), FILE_APPEND);
        $db = DB::getConnection();
        
        $message = str_replace(',', '.', $tFields['message']);
        if (is_numeric($message)) {
            $result = $db->query("SELECT * FROM chats_i_cond({$tFields['chat_id']}, '{$tFields['chat_name']}')");
            $res['inserted'] = $result->fetch();
            $result->closeCursor();

            $result = $db->query("SELECT * FROM balances_inc({$tFields['chat_id']}, $message)");
            $res['reply'] = $result->fetch()['param_res'];

            return $res['reply'];
        }        
    }
}
