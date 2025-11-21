<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
            (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') 
            ? "https://" : "http://";

$root = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/';

define('BASEURL', $root.'public/');
define('ASSETSURL', $root.'assets/');
define('DATAURL', $root.'data/');
define('REDIRECT', $root);

// DB
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'joki_riyono_kantin');
define('WEB_NAME','joki_riyono_kantin');
define('WEBTITLE','Kantin');
