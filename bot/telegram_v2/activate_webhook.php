<?php
include_once "config.php";
$url = URL_BOT . TELEGRAM_BOT_DIR;
$url_webhook = "https://api.telegram.org/bot".TOKEN_DEV."/setWebHook?url=".$url;
header("Location: $url_webhook");
