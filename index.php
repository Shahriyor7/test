<?php 
$API_KEY = '1942366772:AAHlBQ-UMb_IbTsAPxBtOArTOPgEMVu2Epk';
##------------------------------##
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
 
 //====================ᵗᶦᵏᵃᵖᵖ======================//
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$mid = $message->message_id;
$fid = $message->from->id;
$cid = $message->chat->id;
$text = $message->text;
//====================ᵗᶦᵏᵃᵖᵖ======================//
if($text == "/start"){
   bot('sendmessage',[
   "chat_id" => $cid,
   "text" => "*Tezlikni bilish uchun* /speed'*ni bosing*",
   "parse_mode"=>"Markdown",
   "reply_to_message_id"=>$mid,
                    ]);
}
if($text == "/speed"){
$start_time = round(microtime(true) * 1000);
      $send=  bot('sendmessage', [
                'chat_id' => $cid,
                'text' =>"Tezlik:",
            ])->result->message_id;
        
                    $end_time = round(microtime(true) * 1000);
                    $time_taken = $end_time - $start_time;
                    bot('editMessagetext',[
                        "chat_id" => $cid,
                        "message_id" => $send,
                        "text" => "Tezlik: " . $time_taken . "ms",
                    ]);
}
?>
