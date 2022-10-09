<?php 
$API_KEY = '1929420071:AAG1x1NiqTsUZrtpmNen54KoIh4aeMbf9T4';
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

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$fid = $message->from->id;
$cid = $message->chat->id;
$text = $message->text;

if($text == "/start"){
    bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"🌍 *Botga xush kelibsiz*",
	'parse_mode'=>"Markdown",
	'reply_to_message_id'=>$mid,
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"📚 Tarjima qilish","callback_data"=>"translate"]],
	[['text'=>"👨‍💻 Dasturchi","url"=>"tg://user?id=1005223082"]]
	]
	])
	]);
exit();
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
                        'chat_id' => $cid,
                        'message_id' => $send,
                        'text' => "Tezlik: " . $time_taken . "ms",
                    ]);
}
?>
