<?php

$config_file = "<?php

define('DB_NAME', 'test');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('AUTH_KEY',         'sdfsdfdsf');
define('SECURE_AUTH_KEY',  'sdfsdfsdf');
define('LOGGED_IN_KEY',    '2rwdfdsfdsf');
define('NONCE_KEY',        '25efgdfsdsaf');
define('AUTH_SALT',        '25werdfsfsdf');
define('SECURE_AUTH_SALT', '536regdsfa');
define('LOGGED_IN_SALT',   '35trdsfa2te');
define('NONCE_SALT',       '23rwdfwfwdfwr');

\$table_prefix  = 'wp_';

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');

";

file_put_contents( '/temp/wp/wp-config.php', $config_file );

define( 'WP_INSTALLING', true );

$_SERVER['HTTP_HOST'] = 'test';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/wp-admin/plugins.php';

require_once( '/temp/wp/wp-load.php' );
require_once( '/temp/wp/wp-admin/includes/upgrade.php' );

wp_install( 'Test', 'admin', 'test@test.com', false, '', '12345' );