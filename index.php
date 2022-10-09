<?php
ob_start();
define('API_KEY','5622584231:AAHNzGnAL0smQvf8Yps9kBmUG8A96c-b4V8');
$update = json_decode(file_get_contents("php://input"));
$admin = "1005223082";
$message = $update->message;
$cid = $message->chat->id;
$mid = $message->message_id;
$cmid = $update->callback_query->message->message_id;
$ccid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$text = $message->text;
date_default_timezone_set("asia/Tashkent");
$soat = date("H:i");
$from = file_get_contents("data/$cid.from");
$to = file_get_contents("data/$cid.to");
$step = file_get_contents("step/$cid.txt");
$adminstep = file_get_contents("step/admin.txt");
$API = json_decode(file_get_contents("https://shahriyor.clouduz.ru/translate.php?in=$from&out=$to&text=$text"));
$translate=$API->translate;
$ttext=$API->text;
$botname = bot('getme',['bot'])->result->username;
$name = $message->from->first_name;

echo "Kod bexato ishlamoqda";

function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/$method";
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
mkdir("data");
mkdir("step");
mkdir("stat");
if(isset($message)){
    $get = file_get_contents("stat/usid.txt");
    if(mb_stripos($get,$cid)==false){
        file_put_contents("stat/usid.txt","$get\n$cid");
        bot('sendMessage',[
          'chat_id'=>$cid,
          'text'=>"*👋 Salom $name @$botname'ga xush kelibsiz

Bu bot orqali tushunmagan tilingizni tarjima qilishingiz mumkin*",
          'parse_mode'=>"Markdown"
          ]);
        bot('sendMessage',[
          'chat_id'=>$admin,
          'text'=>"🆕 Yangi foydalanuvchi\n👤 Ismi: <a href='tg://user?id=$cid'>$name</a>",
          'parse_mode'=>"Markdown"
          ]);
    }
}
if($text == "/start"){
    bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"🌍 *Tarjimon botga xush kelibsiz*",
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
$us = file_get_contents("stat/usid.txt");
$trans = file_get_contents("data/trans.txt");
$count = substr_count($us, "\n");
if($data == "stat"){
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"📊 *Bot foydalanuvchilari $count ta\n🇺🇿 Bot $trans ta foydalanuvchiga tarjima qilishda yordam berdi*",
	'parse_mode'=>"Markdown",
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"♻️ Yangilash","callback_data"=>"stat"]],
	[['text'=>"⬅️ Orqaga","callback_data"=>"back"]]
	]
	])
	]);
exit();
	}
if($text == "/panel" and $cid == $admin){
	bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"✅ *Panelga xush kelibsiz*",
	'parse_mode'=>"Markdown",
	'reply_to_message_id'=>$mid,
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"📊 Statistika","callback_data"=>"stat"]],
	[['text'=>"🛎 Xabar yuborish","callback_data"=>"sendsms"]],
    [['text'=>"❌ Panelni yopish","callback_data"=>"exit"]]
	]
	])
	]);
exit();
	}
if($data == "sendsms"){
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"❓ *Bot foydalanuvchilariga qanday xabar yubormoqchisiz*",
	'parse_mode'=>"Markdown",
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"🔴 Oddiy","callback_data"=>"oddiy"]],
	[['text'=>"🟢","callback_data"=>"forward"]],
	[['text'=>"⬅️ Orqaga","callback_data"=>"back"]]
	]
	])
	]);
exit();
	}
if($data == "back"){
	bot('editmessagetext',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	'text'=>"✅ *Orqaga qaytdingiz*",
	'parse_mode'=>"Markdown",
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"📊 Statistika","callback_data"=>"stat"]],
	[['text'=>"🛎 Xabar yuborish","callback_data"=>"sendsms"]],
    [['text'=>"❌ Panelni yopish","callback_data"=>"exit"]]
	]
	])
	]);
exit();
	}
if($data == "exit"){
	bot('deleteMessage',[
	'chat_id'=>$ccid,
	'message_id'=>$cmid,
	]);
	bot('sendMessage',[	
	'chat_id'=>$ccid,
	'text'=>"🖥️ *Asosiy menyudasiz*",
	'parse_mode'=>"Markdown",
	]);
exit();
	}
if($data== "oddiy"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"*Matnni yuboring*",
"parse_mode"=>"Markdown",
]);
file_put_contents("step/admin.txt","sendpost");
}
if($adminstep == "sendpost" and $cid == $admin){
unlink("step/admin.txt");
bot('sendMessage',[
  'chat_id'=>$cid,
  'text'=>"✅ *Foydalanuvchilarga xabar yuborish boshlandi*",
"parse_mode"=>"Markdown",
  ]);
$x=0;
$y=0;
$userlar = file_get_contents("stat/usid.txt");
$ids=explode("\n",$userlar);
foreach($ids as $idlar){
$ok=bot('SendMessage',[
 'chat_id'=>$idlar,
 'text'=>"*$text*",
'parse_mode'=>'Markdown',
    ])->ok;
if($ok==true){
$y=$y+1;
bot('editmessagetext',[
'chat_id'=>$cid,
'text'=>"*✅ Yuborildi $y

⛔ Yuborilmadi $x*",
'message_id'=>$mid+1,
'parse_mode'=>'Markdown',
]);
}else{

$x=$x+1;
bot('editmessagetext',[
'chat_id'=>$cid,
'text'=>"*✅ Yuborildi $y

⛔ Yuborilmadi $x*",
'message_id'=>$mid+1,
'parse_mode'=>'Markdown',
]);
}
}
bot('deletemessage',[
'chat_id'=>$cid,
'message_id'=>$mid+1,
]);
bot('sendMessage',[
  'chat_id'=>$cid,
  'text'=>"*✅ Yuborildi $y

⛔ Yuborilmadi $x*",
'parse_mode'=>'Markdown',
  ]);
}
