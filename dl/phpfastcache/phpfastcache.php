<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
// phpFastCache Library
require_once(dirname(__FILE__) . "/3.0.0/phpfastcache.php");
//$base_path = str_replace('\\', '/', dirname(__FILE__));
// OK, setup your cache
phpFastCache::$config = array(
    "storage"   =>  "auto", // auto, files, sqlite, apc, cookie, memcache, memcached, predis, redis, wincache, xcache
    "default_chmod" => 0777, // For security, please use 0666 for module and 0644 for cgi.

    /*
     * OTHERS
     */

    // create .htaccess to protect cache folder
    // By default the cache folder will try to create itself outside your public_html.
    // However an htaccess also created in case.
	"htaccess"      => true,

    // path to cache folder, leave it blank for auto detect
	//"path"      =>  "D:/xampp/htdocs/phimle/data/cache_phimle",
	"path"      =>  dirname(__FILE__)."/../cache",
    "securityKey"   =>  "auto", // auto will use domain name, set it to 1 string if you use alias domain name

    // MEMCACHE

	"memcache"        =>  array(
		array("127.0.0.1",11211,1),
		//  array("new.host.ip",11211,1),
	),

    // REDIS
	"redis"         =>  array(
		"host"  => "127.0.0.1",
		"port"  =>  "",
		"password"  =>  "",
		"database"  =>  "",
		"timeout"   =>  ""
	),
	"extensions"    =>  array(),
    /*
     * Fall back when old driver is not support
     */
    "fallback"  => "files",

);


// temporary disabled phpFastCache
phpFastCache::$disabled = false;

//$phpFastCache = phpFastCache();

