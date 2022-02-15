<?php
class cURL {
    var $ch, $headers, $agent, $error, $info, $cookiefile;
    function cURL() {
		$this -> headers[] = "Accept: text/html,application/xhtml+xml,application/xml,image/gif, image/x-bitmap, image/jpeg, image/pjpeg";
        $this -> headers[] = "Accept-Language: en-us,en;q=0.5";
        $this -> headers[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $this -> headers[] = "Keep-Alive: 115";
        $this -> headers[] = "Connection: Keep-Alive";
		$this -> headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $this->ch = curl_init();
		$this->agent = $this->set_agent(1);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }
	
    function select_type_ip($type=false) {
        if ($type=='v6')
			curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6);
		elseif ($type=='v4')
			curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		elseif ($type=='auto') {
			$ip = get_ip();
			if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
				curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6);
			} else {
				curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			}
		} else curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_WHATEVER);
    }
	function x_requested($request='XMLHttpRequest') {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("X-Requested-With: ".$request));
    }
	function timeout($time) {
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $time);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $time);
    }
	function set_ip($ip) {
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
	}
    function ssl($veryfyPeer, $verifyHost) {
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $veryfyPeer);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, $verifyHost);
    }

    function header($header) {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
    }

    function ipout($outgoing_ip) {
        curl_setopt($this->ch, CURLOPT_INTERFACE, $outgoing_ip);
    }

    function login($user, $pass) {
        curl_setopt($this->ch, CURLOPT_USERPWD, "$user:$pass");
    }
	function compressed($type=null) {
        curl_setopt($this->ch, CURLOPT_ENCODING, "");
    }

    function cookies($cookie_file_path,$type='default') {
        $this->cookiefile = $cookie_file_path;
		if(!file_exists($cookie_file_path)) {
			$fp = fopen($this->cookiefile, 'w');
			fclose($fp);
		}
		if($type=='read') {
			curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookiefile);
		} elseif($type=='write') {
			curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookiefile);
		} else {
			curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookiefile);
			curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookiefile);
		}
    }

    function ref($ref) {
        curl_setopt($this->ch, CURLOPT_REFERER, $ref);
    }

    function get_redirect($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		$html = curl_exec($ch);
		$redirectURL = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
		curl_close($ch);
		return trim($redirectURL);
    }
	
    function proxy($proxy) {
        curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
    }
	
    function socks($sock) {
        curl_setopt($this->ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($this->ch, CURLOPT_PROXY, $sock);
    }

	function put($url, $data){
		 curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "PUT");
		 curl_setopt($this->ch, CURLOPT_POSTFIELDS,http_build_query($data));
		 return $this->getPage($url);
}
    function data($url, $data, $hasHeader = false, $hasBody = true) {
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return $this->getPage($url, $hasHeader, $hasBody);
    }
	function post($url, $data, $hasHeader = false) {
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        return $this->getPage($url, $hasHeader);
    }
    function get($url, $hasHeader = false, $hasBody = true) {
        curl_setopt($this->ch, CURLOPT_POST, 0);
        return $this->getPage($url, $hasHeader, $hasBody);
    }
    function getinfo($url, $hasHeader = true, $hasBody = true) {
        curl_setopt($this->ch, CURLOPT_POST, 0);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, false);
        return $this->getPage($url, $hasHeader, $hasBody);
    }

    function getPage($url, $hasHeader = false, $hasBody = true, $hasInfo = true) {
		$url = preg_replace('/\\0/', "", $url);
		$url = preg_replace('/\s/', '%20', $url);
        curl_setopt($this->ch, CURLOPT_HEADER, $hasHeader ? 1 : 0);
        curl_setopt($this->ch, CURLOPT_NOBODY, $hasBody ? 0 : 1);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $data = curl_exec($this->ch);
		$fixUrl = false;
		if($fixUrl==true) {
			$url = preg_replace('/^([a-z]+):\/\/([^\.]+)\.([^\/]+)\/(.*)/i','$1://$2.$3', $url);
			$data = preg_replace('/src="(?!(https?:)?\/\/)(\.?\/?)([^"]+)"/', "src=\"$url/$3\"", $data);
			$data = preg_replace('/href="(?!(https?:)?\/\/)(\.?\/?)([^"]+)"/', "href=\"$url/$3\"", $data);
			$data = preg_replace('/action="(?!(https?:)?\/\/)(\.?\/?)([^"]+)"/', "action=\"$url/$3\"", $data);
		}
        $this->error = curl_error($this->ch);
        $this->info = curl_getinfo($this->ch); //$curl -> info['http_code']
        return $data;
    }

    function close() {
        @curl_close($this->ch);
    }

	function set_agent($z) {
		$agent = array();
		//$agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)"; // loginYoutube
        $agent[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36";
        $agent[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36";
        $agent[] = "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0";
        $agent[] = "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0";
        $agent[] = "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9a8) Gecko/2007100619 GranParadiso/3.0a8";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1b3) Gecko/20090305 Firefox/3.1b3";
        $agent[] = "Mozilla/5.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4325)";
        $agent[] = "Mozilla/5.0 (X11; Linux i686; rv:21.0) Gecko/20100101 Firefox/21.0";
        $agent[] = "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0";
        $agent[] = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20130401 Firefox/21.0";
        $agent[] = "Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20130401 Firefox/21.0";
        $agent[] = "Mozilla/5.0 (X11; U; Linux; it-IT) AppleWebKit/527+ (KHTML, like Gecko, Safari/419.3) Arora/0.4 (Change: 413 12f13f8)";
        $agent[] = "Mozilla/5.0 (X11; U; Linux; en-GB) AppleWebKit/527+ (KHTML, like Gecko, Safari/419.3) Arora/0.3 (Change: 239 52c6958)";
        $agent[] = "Mozilla/5.0 (X11; U; Linux; en-US) AppleWebKit/523.15 (KHTML, like Gecko, Safari/419.3) Arora/0.2 (Change: 189 35c14e0)";
        $agent[] = "Mozilla/5.0 (Windows; U; WinNT; en; rv:1.0.2) Gecko/20030311 Beonex/0.8.2-stable";
        $agent[] = "Mozilla/5.0 (X11; U; Linux x86_64; en-GB; rv:1.8.1b1) Gecko/20060601 BonEcho/2.0b1 (Ubuntu-edgy)";
        $agent[] = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en; rv:1.8.1.4pre) Gecko/20070521 Camino/1.6a1pre";
        $agent[] = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/419 (KHTML, like Gecko, Safari/419.3) Cheshire/1.0.ALPHA";
        $agent[] = "Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; en-US; rv:1.0.1) Gecko/20021216 Chimera/0.6";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/530.1 (KHTML, like Gecko) Chrome/2.0.164.0 Safari/530.1";
        $agent[] = "Mozilla/5.0 (X11; U; Linux i686; en; rv:1.8.1.12) Gecko/20080208 (Debian-1.8.1.12-2) Epiphany/2.20";
        $agent[] = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b2pre) Gecko/20081015 Fennec/1.0a1";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.6b) Gecko/20031212 Firebird/0.7+";
        $agent[] = "Mozilla/5.0 (X11; U; Linux i686; it-IT; rv:1.9.0.2) Gecko/2008092313 Ubuntu/9.04 (jaunty) Firefox/3.5";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9b3) Gecko/2008020514 Firefox/3.0b3";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 6.0; it; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.8.1.5) Gecko/20070713 Firefox/2.0.0.5";
        $agent[] = "Mozilla/5.0 (X11; U; Linux i686; de-AT; rv:1.8.0.2) Gecko/20060309 SeaMonkey/1.0";
        $agent[] = "Mozilla/5.0 (X11; U; Linux i686; de-AT; rv:1.8.0.2) Gecko/20060309 SeaMonkey/1.0";
        $agent[] = "Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10.5; en-US; rv:1.9.1b3pre) Gecko/20081212 Mozilla/5.0 (Windows; U; Windows NT 5.1; en) AppleWebKit/526.9 (KHTML, like Gecko) Version/4.0dp1 Safari/526.8";
        $agent[] = "Mozilla/5.0 (X11; U; Linux i686; de-AT; rv:1.8.0.2) Gecko/20060309 SeaMonkey/1.0";
        $agent[] = "Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.7.6) Gecko/20050405 Epiphany/1.6.1 (Ubuntu) (Ubuntu package 1.0.2)";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.5) Gecko/20060731 Firefox/1.5.0.5 Flock/0.7.4.1";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.19 (KHTML, like Gecko) Chrome/0.2.153.1 Safari/525.19 ";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9b5) Gecko/2008032620 Firefox/3.0b5 ";
		
		if(is_numeric($z)) {
			$z = $agent[$z];
		}  elseif($z == 'random') {
			$rand_keys = array_rand($agent,1);
			$z = $agent[$rand_keys];
		} elseif(!$z || $z == '' || $z == null) {
			$z = $agent[0];
		} elseif($z!='') {
			$z = $z;
		} elseif(isset($_SERVER['HTTP_USER_AGENT']))
			$z = $_SERVER['HTTP_USER_AGENT'];
		curl_setopt($this->ch, CURLOPT_USERAGENT, $z);
		return $z;
	}
}