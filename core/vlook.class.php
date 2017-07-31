<?php

$info['seo_title'] = '微录客视频下载,Vlook视频下载地址在线解析-parsevideo.com';
$info['seo_keywords'] = '微录客视频下载，Vlook视频下载地址在线解析，手机Vlook视频提取，微录客福利视频，微录客视频批量下载';
$info['seo_description'] = '微录客视频下载地址在线解析，微录客福利视频批量下载工具，可以下载Vlook视频';
$info['url_input_placeholder'] = "请输入vlook网址，如：http://www.vlook.cn/show/qs/YklkPTQ0NDg4OTE=";

class Vlook {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
		preg_match("~<meta property=\"og:image\" content=\"(.*?)\"~i", $html, $thumb);
		preg_match("~<meta property=\"og:title\" content=\"([\s\S]*?)\"~i", $html, $desc);
		preg_match("~[\s\S]+(createPlayer\('|<source src=\")([^<>]*)('|\")~i", $html, $url);
		if(!empty($url[2])){
			$video[] = array(
				'url'=>$url[2],
				'thumb'=>$thumb[1],
				'desc'=>trim(strip_tags($desc[1])),
			);	
			$data['pages'] = 0;
			$data['total'] = count($video);
			$data['video'] = $video;			
			return $data;
		}
		return false;
	}
}