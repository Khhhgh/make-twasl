<?php

ob_start();
define('API_KEY','7672816252:AAF7WMsY2F4pBmodviKxyvdFHqg6kSJ-ftg');
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
$chat_id = $message->chat->id;
$text = $message->text;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$from_id = $message->from->id;
$ch1 = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@set_Web&user_id=$from_id");
$ch2 = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@touch_t&user_id=$from_id");
$check_token = file_get_contents("https://api.telegram.org/bot$text/getWebhookInfo");
$check = json_decode($check_token);
$get_file = file_get_contents('twasl.php');
$get_done = file_get_contents('make/ex.txt');
$done = explode("\n", $get_done);
$get_id = file_get_contents('make/make.txt');
$getid = explode("\n", $get_id);
$mid = $message->message_id;

$inlineqt = $update->inline_query->query;
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'results' => json_encode([[
            'type'=>'article',
            'id'=>base64_encode(rand(5,555)),
            'title'=>'مشاركة مع اصدقائك',
            'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"اهلا بك 🍁 في بوت انشاء بوتات تواصل ♻️ يمكنك انشاء بوت خاص بك 🚹 او لفريقك مجانا مع العديد ✳️ من المميزات الرائعة كل هاذا مجانا مالذي تنتضره ؟ انشأ بوتك الان 🔆"],
            'reply_markup'=>['inline_keyboard'=>[
                [
                ['text'=>'اصنع بوتك الان 💎️','url'=>'https://telegram.me/maketwasl_bot']
                ],
             ]]
        ]])
    ]);


if (strpos($ch1 , '"status":"left"') !== false){
bot('sendMessage', [
'chat_id'=>$chat_id,
'parse_mode'=>'Markdown',
'text'=>"المعذرة ❌ يجب عليك الاشتراك 🚹✨ في هاذه القنوات لكي يمكنك استخدام البوت 📢",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
          ['text'=>'📚 REAL 💎 BUSINESS ®', 'url'=>"https://telegram.me/A_S_4A"]
        ],
         [
          ['text'=>'TOUCH 💎' , 'url'=>"https://t.me/A_S_4A"]
        ],
]

])
]);
}



if($text == '/start' and !in_array($from_id, $getid) and !strpos($ch1 , '"status":"left"') !== false){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'اهلا بك 🍁 في بوت انشاء بوتات تواصل ♻️ يمكنك انشاء بوت خاص بك 🚹 او لفريقك مجانا مع العديد ✳️ من المميزات 🔆',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'انشاء بوت 💎','callback_data'=>'maka']],
[
['text'=>'معلوماتك❕','callback_data'=>'info'],
['text'=>'شراء البوت 💸','callback_data'=>'buy']
],
[['text'=>'تابعنا ♦️','callback_data'=>'channel'] ,
['text'=>'شارك البوت 🚹','switch_inline_query'=>'']
],

[['text'=>'حذف البوت 🗑','callback_data'=>'delete']],

]
])
]);
}

if($data == 'maka' and !in_array($chat_id2,$done) and !strpos($ch1 , '"status":"left"') !== false){
file_put_contents('make/make.txt', "\n" . $chat_id2 . "\n",FILE_APPEND);    
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'قم بأرسال 💭 توكن البوت الان ✅',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'الغاء ❌','callback_data'=>'cancle']]
]
])
]);
}

if($data == 'maka' and in_array($chat_id2,$done) and !strpos($ch1 , '"status":"left"') !== false){

bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'message_id'=>$message_id,
'text'=>'لا يمكنك ❌ انشاء اكثر من بوت 💎',
 'show_alert'=>true
 ]);      
}


if($text and in_array($from_id, $getid) and $check->ok == "true"){

for($i = $mid - 3; $i < $mid; $i++){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$i
]);
}

$str = str_replace($from_id, '', $get_id);    

file_put_contents('make/make.txt', $str);    

file_put_contents('make/ex.txt', $from_id . "\n", FILE_APPEND);
    
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'تم ✅ انشاء البوت ✨',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'الصفحة الرئيسية 🏠️' , 'callback_data'=>"home"]
],
]
])

]); 


mkdir("bots/$from_id");

file_put_contents("bots/$from_id/info.txt",$text . "\n" . $from_id);

file_put_contents("bots/$from_id/bot.php", $get_file);

file_put_contents("bots/$from_id/chat.txt", $from_id . "\n");

file_put_contents("bots/$from_id/welcome.txt", 'اهلا بك في بوت التواصل' . "\n");


file_get_contents("https://api.telegram.org/bot$text/setwebhook?url=https://twaslobot.000webhostapp.com/bots/$from_id/bot.php");


}


if($text and in_array($from_id, $getid) and $check->ok != "true" and !strpos($ch1 , '"status":"left"') !== false){

bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'عذرا ❗️هاذا التوكن غير صالح ♻️',
'reply_to_message_id'=>$message->message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'الغاء ❌','callback_data'=>'cancle']]
]
])
]);
}    

if($data == 'cancle' and in_array($from_id, $getid)){

$str = str_replace($chat_id2, "", $get_id) ;
file_put_contents('make/make.txt', $str);
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'اهلا بك 🍁 في بوت انشاء بوتات تواصل ♻️ يمكنك انشاء بوت خاص بك 🚹 او لفريقك مجانا مع العديد ✳️ من المميزات 🔆',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'انشاء بوت 💎','callback_data'=>'maka']],
[
['text'=>'معلوماتك❕','callback_data'=>'info'],
['text'=>'شراء البوت 💸','callback_data'=>'buy']
],
[['text'=>'تابعنا ♦️','callback_data'=>'channel'] ,
['text'=>'شارك البوت 🚹','switch_inline_query'=>'']
],
[['text'=>'حذف البوت 🗑','callback_data'=>'delete']],

]    
])
]);
}

if($data == 'home'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'اهلا بك 🍁 في بوت انشاء بوتات تواصل ♻️ يمكنك انشاء بوت خاص بك 🚹 او لفريقك مجانا مع العديد ✳️ من المميزات 🔆',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'انشاء بوت 💎','callback_data'=>'maka']],
[
['text'=>'معلوماتك❕','callback_data'=>'info'],
['text'=>'شراء البوت 💸','callback_data'=>'buy']
],
[['text'=>'تابعنا ♦️','callback_data'=>'channel'] ,
['text'=>'شارك البوت 🚹','switch_inline_query'=>'']
],

[['text'=>'حذف البوت 🗑','callback_data'=>'delete']],


]    
])
]);
}

if($data == 'delete' and in_array($chat_id2,$done)){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'هل انت متأكد ⁉️ من انك تريد حذف البوت 🗑',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'لا ❌', 'callback_data'=>'home'],
['text'=>'نعم ✅','callback_data'=>'yesdel'],
]    
]])
]);    
}

if($data == 'yesdel' and in_array($chat_id2, $done)){


bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"تم ✅  حذف البوت بنجاح 🗑",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'الصفحة الرئيسية 🏠️' , 'callback_data'=>"home"]
]
]
])
]);



$str1 = str_replace($chat_id2, '', $get_done);

file_put_contents('make/ex.txt', $str1);

$get_token = file_get_contents("bots/$chat_id2/info.txt");

$get_url = file_get_contents("https://api.telegram.org/bot$get_token/getWebhookInfo");

$json = json_decode($get_url);

$url = $json->result->url;

file_get_contents("https://https://api.telegram.org/bot$get_token/deletewebhook?url=$url");

unlink("bots/$chat_id2/bot.php");
unlink("bots/$chat_id2/info.txt");

}


if($data == 'delete' and !in_array($chat_id2,$done)){

bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'message_id'=>$message_id,
'text'=>'قم ♻️ بأنشاء بوت اولا ~💟',
 'show_alert'=>true
 ]);  
 
}




if($data == 'info' and in_array($chat_id2,$done)){
    
$get_info = file_get_contents("bots/$chat_id2/info.txt");

$url_info = file_get_contents("https://api.telegram.org/bot$get_info/getMe");

$json_info = json_decode($url_info);

$id = $json_info->result->id;

$user = $json_info->result->username;

$name = $json_info->result->first_name;

bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
اهلا بك -💟 معلومات بوتك هية 🔻

💭 الايدي : $id

💭 اسم المستخدم : @$user

💭 الاسم : $name

💭 التوكن : $get_info

",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'الصفحة الرئيسية 🏠️' , 'callback_data'=>"home"]
]
]
])
]);    
}

if($data == 'info' and !in_array($chat_id2,$done)){
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'message_id'=>$message_id,
'text'=>'قم ♻️ بأنشاء بوت اولا ~💟',
 'show_alert'=>true
 ]);  
}

if($data == 'buy'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"اهلا بك -💟 لشراء البوت يمكنك مراسلة 📩\nالمطور 🕴سعر البوت 10$ اسياسيل 💸",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'المطور 🕴🏻','url'=>'https://telegram.me/omar_real']],
[['text'=>'بوت التواصل 💎','url'=>'https://telegram.me/math_support_bot']],
[['text'=>'الصفحة الرئيسية 🏠️' , 'callback_data'=>"home"]]
]])
]);
}

if($data=="channel"){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'تابعنا عبر الروابط للتالية 📩',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'REAL BUSINESS 📚', 'url'=>"https://telegram.me/set_web"]
],
[
['text'=>'فريق لمسة 💡', 'url'=>"https://telegram.me/touch_t"]
],
[
['text'=>'عودة 🏠 ', 'callback_data'=>"home"]
],
]
])
]);
}
