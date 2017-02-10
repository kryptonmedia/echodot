<?php

//header('Content-Type: application/json');

//include('uuid.php');

class UUID
{
	/**
	 * Generate v3 UUID
	 *
	 * Version 3 UUIDs are named based. They require a namespace (another 
	 * valid UUID) and a value (the name). Given the same namespace and 
	 * name, the output is always the same.
	 * 
	 * @param	uuid	$namespace
	 * @param	string	$name
	 */
	public static function v3($namespace, $name)
	{
		if(!self::is_valid($namespace)) return false;

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2) 
		{
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}

		// Calculate hash value
		$hash = md5($nstr . $name);

		return sprintf('%08s-%04s-%04x-%04x-%12s',

		// 32 bits for "time_low"
		substr($hash, 0, 8),

		// 16 bits for "time_mid"
		substr($hash, 8, 4),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 3
		(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

		// 48 bits for "node"
		substr($hash, 20, 12)
		);
	}

	/**
	 * 
	 * Generate v4 UUID
	 * 
	 * Version 4 UUIDs are pseudo-random.
	 */
	public static function v4() 
	{
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

		// 32 bits for "time_low"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff),

		// 16 bits for "time_mid"
		mt_rand(0, 0xffff),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand(0, 0x0fff) | 0x4000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand(0, 0x3fff) | 0x8000,

		// 48 bits for "node"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

	/**
	 * Generate v5 UUID
	 * 
	 * Version 5 UUIDs are named based. They require a namespace (another 
	 * valid UUID) and a value (the name). Given the same namespace and 
	 * name, the output is always the same.
	 * 
	 * @param	uuid	$namespace
	 * @param	string	$name
	 */
	public static function v5($namespace, $name) 
	{
		if(!self::is_valid($namespace)) return false;

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2) 
		{
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}

		// Calculate hash value
		$hash = sha1($nstr . $name);

		return sprintf('%08s-%04s-%04x-%04x-%12s',

		// 32 bits for "time_low"
		substr($hash, 0, 8),

		// 16 bits for "time_mid"
		substr($hash, 8, 4),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 5
		(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

		// 48 bits for "node"
		substr($hash, 20, 12)
		);
	}

	public static function is_valid($uuid) {
		return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                      '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
	}
}

/*

[caption id="attachment_52080" align="alignright" width="480"]<img class="size-large wp-image-52080" src="http://kryptonradio.com/wp-content/uploads/2017/02/toni-w-headshotzoom-6-480x320.jpg" alt="" width="480" height="320">Kate Wilhelm Solstice Award winner Toni Weisskopf[/caption]

\[caption\b.*?].*?\[/caption]
\[(?!(?:' . ')\b)(\w+)\b.*?].*?\[/\1]
\[(\w+)\b.*?].*?\[/\1]

\[caption(.+?)[\s]*\/?[\s]*\[\/caption]

-30-

*/

function getGUID($idSeed){
	//mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	//$charid = strtoupper(uniqid($idSeed, true));
	//$charid = strtoupper(md5(uniqid($idSeed, true)));
	$charid = strtoupper(uniqid('',true));
	$hyphen = chr(45);// "-"
	$uuid = substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12);// "}"
	return $uuid;
}

function w1250_to_utf8($text) {
    // map based on:
    // http://konfiguracja.c0.pl/iso02vscp1250en.html
    // http://konfiguracja.c0.pl/webpl/index_en.html#examp
    // http://www.htmlentities.com/html/entities/
    $map = array(
        chr(0x8A) => chr(0xA9),
        chr(0x8C) => chr(0xA6),
        chr(0x8D) => chr(0xAB),
        chr(0x8E) => chr(0xAE),
        chr(0x8F) => chr(0xAC),
        chr(0x9C) => chr(0xB6),
        chr(0x9D) => chr(0xBB),
        chr(0xA1) => chr(0xB7),
        chr(0xA5) => chr(0xA1),
        chr(0xBC) => chr(0xA5),
        chr(0x9F) => chr(0xBC),
        chr(0xB9) => chr(0xB1),
        chr(0x9A) => chr(0xB9),
        chr(0xBE) => chr(0xB5),
        chr(0x9E) => chr(0xBE),
        chr(0x80) => '&euro;',
        chr(0x82) => '&sbquo;',
        chr(0x84) => '&bdquo;',
        chr(0x85) => '&hellip;',
        chr(0x86) => '&dagger;',
        chr(0x87) => '&Dagger;',
        chr(0x89) => '&permil;',
        chr(0x8B) => '&lsaquo;',
        chr(0x91) => '&lsquo;',
        chr(0x92) => '&rsquo;',
        chr(0x93) => '&ldquo;',
        chr(0x94) => '&rdquo;',
        chr(0x95) => '&bull;',
        chr(0x96) => '&ndash;',
        chr(0x97) => '&mdash;',
        chr(0x99) => '&trade;',
        chr(0x9B) => '&rsquo;',
        chr(0xA6) => '&brvbar;',
        chr(0xA9) => '&copy;',
        chr(0xAB) => '&laquo;',
        chr(0xAE) => '&reg;',
        chr(0xB1) => '&plusmn;',
        chr(0xB5) => '&micro;',
        chr(0xB6) => '&para;',
        chr(0xB7) => '&middot;',
        chr(0xBB) => '&raquo;',
    );
	return html_entity_decode(mb_convert_encoding(strtr($text, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');
	//return html_entity_decode(mb_convert_encoding($text,'ISO-8859-2','Windows-1251'));
	//$tmp = mb_convert_encoding($text,'ISO-8859-2','Windows-1251');
	//return mb_convert_encoding($tmp,'UTF-8','ISO-8859-2');
}



	function getDay(){
		$dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		//$fDate = date('l F jS, Y');
		$dow_numeric = date('w');
		return $dowMap[$dow_numeric];
	}

	function strip_caption_content($text, $tags = '', $invert = FALSE) 
	{ 
		preg_match_all('/\[caption(.+?)[\s]*\/?[\s]*\[\/caption]/', trim($tags), $tags); 
		$tags = array_unique($tags[1]); 
		
		if(is_array($tags) AND count($tags) > 0) 
		{ 
			if($invert == FALSE) 
			{ 
				return preg_replace('@\[(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?].*?\[/\1]@si', '', $text); 
			} 
			else 
			{ 
				return preg_replace('@\[\b.*?>.*?\[/caption]@si', '', $text); 
			} 
		} 
		elseif($invert == FALSE) 
		{ 
			return preg_replace('@\[(\w+)\b.*?].*?\[/\1]@si', '', $text); 
		} 
		return $text; 
	}
    function replace_youtube_link($text) {
		$tmp = $text;
		$tmp = preg_replace('/https:\/\/www.you(.+?)[\s]/i', 'Watch the video on our website. ',$tmp);
        $tmp = preg_replace('/https:\/\/you(.+?)[\s]/i', 'Watch the video on our website. ',$tmp);
		return $tmp;
    }

// Connect to the database using predefined variables
$mysqli = new mysqli('localhost','gamma','gamma','kryptonradio');
// A connect_errno exists, so the connection failed
if($mysqli->connect_errno)
{
	// This error message is for testing purposes only. It will either fail silently or
	// write to a log file in the final application
	echo "<p>Sorry, this page is currently experiencing difficulties.</p><br />";
	echo "Error: Failed to make a MySQL connection, here is why: \n";
	echo "Errno: " . $mysqli->connect_errno . "\n";
	echo "Error: " . $mysqli->connect_error . "\n";
	exit;
}

$sql= "SELECT ID, post_date, post_date_gmt, post_content, post_title, post_status, guid FROM wp_posts WHERE post_status='publish' ORDER BY post_date DESC LIMIT 10;";
if(!$result = $mysqli->query($sql))
{
	// This error message is for testing purposes only. It will either fail silently or
	// write to a log file in the final application
	echo "<p>Sorry, this page is currently experiencing difficulties.</p><br />";
	echo "Error: Our query failed to execute, here is why: \n";
	echo "Errno: " . $mysqli->connect_errno . "\n";
	echo "Error: " . $mysqli->connect_error . "\n";
	exit;
}

	while($row = $result->fetch_assoc())
	{
		
        if(strlen($row['post_content']>=4300)){
            continue;
        } else if( (stristr($row['post_content'],"https://you",true) !== false) ||  (stristr($row['post_content'], "https://www.you",true) !== false) ) {
            $copyOutput = replace_youtube_link($row['post_content']);
        } else {
            $copyOutput = $row['post_content'];
			//continue;
        }
        
        /*
		if( (stristr($row['post_content'],"https://you",true) !== false) ||  (stristr($row['post_content'], "https://www.you",true) !== false) ||
		    strlen($row['post_content'])>=4300 )
		{
			continue;
		}
        */
        
        $strLength = strlen($row['post_content']);
        
		//$UUID = "urn:uuid:" . getGUID($row['ID']);
		$tmpUid = UUID::v4();
		if(UUID::is_valid($tmpUid)) {
			$uid = UUID::v5($tmpUid,$row['ID']);
		} else {
			$uid = UUID::v5("1546058f-5a25-4334-85ae-e68f2a44bbaf",$row['ID']);
		}
		$UUID = "urn:uuid:" . strtoupper($uid);
		
		$gmtDate = explode(" ",$row['post_date_gmt']);
		$gmtDate[1] = $gmtDate[1] . "Z";
		$amazonDate = implode("T", $gmtDate);
		
		$fDate = date('l F jS, Y', strtotime($row['post_date']));
		
		
		echo "<h1>Post Title: " . $row['post_title'] . "</h1><br>";
		echo "ID: " . $row['ID'] . "<br>";
		echo "UUID: " . $UUID . "<br>";
        if($strLength <= 4300) {
            echo "Length is less than 4200 characters: " . $strLength . "<br>";
        } else {
            echo "Length is greater than 4200 characters: " . $strLength . "<br>";
        }
		echo "Post Date Raw: " . $row['post_date'] . "<br>";
		echo "Post Date Formatted: " . $fDate . "<br>";
		echo "Amazon Date: " . $amazonDate . "<br>";
		echo "Post Status: " . $row['post_status'] . "<br><br>";
		
           
        $tmp = strip_caption_content($copyOutput);
		//$tmp = strip_caption_content($row['post_content']);
        //$tmp = replace_youtube_link($tmp);
		$tmp = strip_tags($tmp);
		$tmp = str_replace("-30-",'',$tmp);
		$text = w1250_to_utf8($tmp);
		
		$strStart = "Here's the news from Krypton Radio for " . $fDate . ". ";
		$strTitle = $row['post_title'] . ". ";
		$strBoiler = "Krypton radio dot com is listener supported sci-fi and geek culture radio. It's Sci-fi for your Wifi.";
		//$finalOutput = $strStart . $text . $strBoiler;
		$finalOutput = $strStart . $strTitle . $text;
		
		$jsonOut = Array("uid"=>$UUID,"updateDate"=>$amazonDate,"titleText"=>$row['post_title'],"mainText"=>$finalOutput,"redirectionUrl"=>$row['guid']);
		
		$jsonOut["mainText"] = str_replace("\n"," ",$jsonOut["mainText"]);
		$jsonOut["mainText"] = htmlentities($jsonOut["mainText"]);
        
		
		/*
		/&nbsp;/ig
		/&rsquo;/ig
		/(https:\\\\\/\\\\\/kryptonradio.com\\\\\/)/i
		/(    )/i
		*/
		
		
		echo "Post Content: " . $text . "<br><br><br>";
	
		echo "<h2>Finalized Output:</h2><br><br>";
		echo $finalOutput;
		echo "<br><br><br><br><br><br><br><br><br><br>";
		
		echo "<h2>JSON Output:</h2><br><br>";
		
		$jString=json_encode($jsonOut);
		$jString = preg_replace("/&nbsp;/i"," ",$jString);
		$jString = preg_replace("/&rsquo;/i","'",$jString);
		$jString = preg_replace("/(https:\\\\\/\\\\\/kryptonradio.com\\\\\/)/i","https://kryptonradio.com/",$jString);
		$jString = preg_replace("/(    )/i"," ",$jString);
		
		echo $jString;
		echo "<br><br><br><br><br><br><br><br><br><br>";
		break;
	}
	
$mysqli->close();

/*
	$ch = curl_init("http://www.kryptonradio.com/wp-json/wp/v2/posts");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_HEADER,0);
	$result = curl_exec($ch);
	echo strip_tags($result);
	curl_close($ch);
*/
?>