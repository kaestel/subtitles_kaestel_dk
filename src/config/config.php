<?php
/**
* This file contains definitions
*
* @package Config
*/
header("Content-type: text/html; charset=UTF-8");
error_reporting(E_ALL);

/**
* Required site information
*/
define("SITE_UID", "SUB");
define("SITE_NAME", "subtitles");
define("SITE_URL", "subtitles");
define("SITE_EMAIL", "martin@think.dk");

/**
* Optional constants
*/
define("DEFAULT_PAGE_DESCRIPTION", "");
define("DEFAULT_LANGUAGE_ISO", "DA");
define("DEFAULT_COUNTRY_ISO", "DK");
define("DEFAULT_CURRENCY_ISO", "DKK");


// Enable items model
define("SITE_ITEMS", false);

// Enable shop model
define("SITE_SHOP", false);


// Enable notifications (send collection email after N notifications)
define("SITE_COLLECT_NOTIFICATIONS", 50);
//define("SHOP_ORDER_NOTIFIES", "martin@think.dk");
define("SHOP_ORDER_NOTIFIES", "martin@think.dk,ole@nielsen.dk");


?>
