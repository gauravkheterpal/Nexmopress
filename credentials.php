<?php
//Nexmo credentials may be optionally defined elsewhere

//if(file_exists('.local.php')){

   //require_once '.local.php';

//}
define('NEXMO_KEY',    '583ea851');
define('NEXMO_SECRET', '76f7febe');
define('NEXMO_FROM',   '919414530961');


defined('NEXMO_KEY')    || (getenv('NEXMO_KEY')    AND define('NEXMO_KEY', getenv('NEXMO_KEY')));
defined('NEXMO_SECRET') || (getenv('NEXMO_SECRET') AND define('NEXMO_SECRET', getenv('NEXMO_SECRET')));
defined('NEXMO_FROM')   || (getenv('NEXMO_FROM')   AND define('NEXMO_FROM', getenv('NEXMO_FROM')));
