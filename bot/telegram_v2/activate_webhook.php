<?php
include_once "config.php";
$url = URL_BOT . 'telegram_v2/';
$url_webhook = "https://api.telegram.org/bot".TOKEN_DEV."/setWebHook?url=".$url;
header("Location: $url_webhook");
