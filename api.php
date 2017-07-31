<?php
error_reporting(0);
require 'parserVideo.class.php';
header("content-type:text/html;charset=utf-8");
//sleep(1);
$_REQUEST['hash'] = md5("ParserVideo.C0m".ceil(time()/1000)); //测试时使用，上线时注释掉
$callback = trim(htmlspecialchars(strip_tags($_REQUEST['callback'])));
if($_REQUEST['url'] && $_REQUEST['hash']){	
	//检查api参数，以防止盗链
	$url = trim($_REQUEST['url']);
	$hash = trim(htmlspecialchars(strip_tags($_REQUEST['hash'])));
	$hash2 = md5("ParserVideo.C0m".ceil(time()/1000));
	if($hash2 !== $hash || !preg_match("~^http~i", $url)){
		$result = array(
			'status' => "error",
			'message' => "参数校检失败，请刷新网页或从<a href='http://www.parsevideo.com'>http://www.parsevideo.com</a>网站正确解析！",
		);
		if(!empty($callback)) {
			echo $callback . "(".@json_encode($result).");";
		} else {
			echo @json_encode($result);
		}	
		exit;		
	}
	
	//哪些网址使用代理
	if(preg_match("~(youtube\.com|youtu\.be|tumblr\.com|instagram\.com|facebook\.com)~i",$url)){
		define("PROXY", "socks5h://127.0.0.1:10801");
	}
	
	//解析视频网址
	$result = ParserVideo::parse($url);
	if(!empty($result)){
		$result['status'] = "ok";
		if(!empty($callback)) {
			echo $callback . "(".@json_encode($result).");";
		} else {
			echo @json_encode($result);
		}	
		exit;
	} else {
		$result = array(
			'status' => "error",
			'message' => "数据获取失败，请重新尝试或检查网址是否符合系统要求！",
		);
		if(!empty($callback)) {
			echo $callback . "(".@json_encode($result).");";
		} else {
			echo @json_encode($result);
		}	
		exit;
	}
} else {
	$result = array(
		'status' => "error",
		'message' => "参数缺失，请从<a href='http://www.parsevideo.com'>http://www.parsevideo.com</a>网站正确解析！",
	);
	if(!empty($callback)) {
		echo $callback . "(".@json_encode($result).");";
	} else {
		echo @json_encode($result);
	}	
}
