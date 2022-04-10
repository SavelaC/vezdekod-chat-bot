<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
ini_set("log_errors", 1);
ini_set("error_log", "index.txt"); // ну и логируем ошибки конечно же :)

require_once __DIR__ . '/simplevk-testing/autoload.php';

use DigitalStars\SimpleVK\{Bot, Store, SimpleVK as vk};

$vk = vk::create("968ec8e314a3c984362fa626e84ef9335bf63b33146ac82e18236dae3875fd52ee916b5c6a30f98a41e00", '5.131')->setConfirm("ab02c0cd");
$vk->setUserLogError(680748187);
$bot = Bot::create($vk);
$bot->isAllBtnCallback(true);
$vk->initVars($null, $user_id, $type, $message, $payload);
$bot->cmd('Начать', 'Привет', 'привет')->text("Привет вездекодерам!");
$bot->cmd('мем', 'Мем')->func(function ($msg, $params) {
    $kbd = [['like', 'dislike']];
    $files = array_diff(scandir("mems"), ['..', '.']);
    $file = $files[array_rand($files)];
    $file = dirname(__FILE__) . "/mems/{$file}";
    $msg->text('Лови мем')->img($file)->kbd($kbd, true);
});
$bot->btn('like', "&#128077;")->func(function ($msg, $params) use ($vk) {
    $msg->eventAnswerSnackbar('Like success!');
    $vk->initVars($id, $user_id, $payload, $user_id);
    $store = Store::load($user_id);
    $likes = $store->get("likes");
    if ($likes == "") {
        $store->sset("likes", 1);
    } else {
        $store->sset("likes", $likes + 1);
    }
});
$bot->btn('dislike', "&#128078;")->func(function ($msg, $params) use ($vk) {
    $msg->eventAnswerSnackbar('Like success!');
    $vk->initVars($id, $user_id, $payload, $user_id);
    $store = Store::load($user_id);
    $dislikes = $store->get("dislikes");
    if ($dislikes == "") {
        $store->sset("dislikes", 1);
    } else {
        $store->sset("likes", $dislikes + 1);
    }
});
$bot->cmd('стата', 'Статистика')->func(function ($msg, $params) use ($vk) {
    $vk->initVars($id, $user_id, $payload, $user_id);
    $store = Store::load($user_id);
    $likes = $store->get("likes");
    $dislikes = $store->get("dislikes");
    if ($likes == "") $likes = 0;
    if ($dislikes == "") $dislikes = 0;
    $msg->text("Твоя статистика:
    
&#128077; Лайков: {$likes}
&#128078; Дизлайков: {$dislikes}");
});
$bot->run();

$data2 = json_decode(file_get_contents('php://input'));

try {
} catch (Exception $e) {;
}
