<?php
include_once "config.php";
$url = URL_BOT . TELEGRAM_BOT_DIR .'index.php';
$url_webhook = "https://api.telegram.org/bot".TOKEN_PROD."/setWebHook?url=".$url;
header("Location: $url_webhook");
