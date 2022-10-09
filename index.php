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
$mid = $message->message_id;
$cmid = $update->callback_query->message->message_id;
$ccid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$fid = $message->from->id;
$cid = $message->chat->id;
$text = $message->text;
$from = file_get_contents("data/$cid.from");
$to = file_get_contents("data/$cid.to");
$step = file_get_contents("step/$cid.txt");
$adminstep = file_get_contents("step/admin.txt");
$API = json_decode(file_get_contents("https://m1807.myxvest.ru/Xosting/users/1005223082/host/API/translate.php?in=$from&out=$to&text=$text"));
$tarjima=$API->translate;
$matn=$API->text;

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
if($data == "translate"){
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"🌍 *Qaysi tildan tarjima qilamiz*",
	'parse_mode'=>"Markdown",
	'reply_to_message_id'=>$mid,
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"🇷🇺 Rus tili","callback_data"=>"ru"]],
	[['text'=>"🇺🇸 Ingliz tili","callback_data"=>"en"]],
	[['text'=>"🇺🇿 Oʻzbek tili","callback_data"=>"uz"]]
	]
	])
	]);
exit();
	}
if($data == "ru"){
file_put_contents("data/$ccid.from","ru");
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"🇷🇺 *Rus tilidan qaysi tilga tarjima qilamiz*",
	'parse_mode'=>"Markdown",
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"🇺🇸 Ingliz tiliga","callback_data"=>"eng"]],
	[['text'=>"🇺🇿 Oʻzbek tiliga","callback_data"=>"uzb"]]
	]
	])
	]);
exit();
	}
if($data == "en"){
file_put_contents("data/$ccid.from","en");
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"🇺🇸 *Ingliz tilidan qaysi tilga tarjima qilamiz*",
	'parse_mode'=>"Markdown",
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"🇷🇺 Rus tiliga","callback_data"=>"rus"]],
	[['text'=>"🇺🇿 Oʻzbek tiliga","callback_data"=>"uzb"]]
	]
	])
	]);
exit();
	}
if($data == "uz"){
file_put_contents("data/$ccid.from","uz");
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"🇺🇿 *Oʻzbek tilidan qaysi tilga tarjima qilamiz*",
	'parse_mode'=>"Markdown",
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"🇷🇺 Rus tiliga","callback_data"=>"rus"]],
	[['text'=>"🇺🇸 Ingliz tiliga","callback_data"=>"eng"]]
	]
	])
	]);
exit();
	}
if($data == "rus"){
file_put_contents("data/$ccid.to","ru");
file_put_contents("step/$ccid.txt","ru");
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"🇷🇺 *Matnni yuboring*",
	'parse_mode'=>"Markdown",
	]);
exit();
	}
if($data == "eng"){
file_put_contents("data/$ccid.to","en");
file_put_contents("step/$ccid.txt","en");
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"🇺🇸 *Matnni yuboring*",
	'parse_mode'=>"Markdown",
	]);
exit();
	}
if($data == "uzb"){
file_put_contents("data/$ccid.to","uz");
file_put_contents("step/$ccid.txt","uz");
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"🇺🇿 *Matnni yuboring*",
	'parse_mode'=>"Markdown",
	]);
exit();
    }
if($step == "ru" and $text !== "/start"){
file_put_contents("data/trans.txt",$trans+1);
	bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"✏️ *Siz yuborgan soʻz - $ttext\n🇷🇺 Tarjimasi - $translate*",
	'parse_mode'=>"Markdown",
	'reply_to_message_id'=>$mid,
	]);
unlink("step/$cid.txt");
unlink("data/$cid.from");
unlink("data/$cid.to");
exit();
	}
if($step == "en" and $text !== "/start"){
unlink("step/$cid.txt");
unlink("data/$cid.from");
unlink("data/$cid.to");
file_put_contents("data/trans.txt",$trans+1);
	bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"✏️ *Siz yuborgan soʻz - $ttext\n🇺🇸 Tarjimasi - $translate*",
	'parse_mode'=>"Markdown",
	'reply_to_message_id'=>$mid,
	]);
exit();
	}
if($step == "uz" and $text !== "/start"){
unlink("step/$cid.txt");
unlink("data/$cid.from");
unlink("data/$cid.to");
file_put_contents("data/trans.txt",$trans+1);
	bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"✏️ *Siz yuborgan soʻz - $ttext\n🇺🇿 Tarjimasi - $translate*",
	'parse_mode'=>"Markdown",
	'reply_to_message_id'=>$mid,
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
