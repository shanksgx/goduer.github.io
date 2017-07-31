<?php

$info['seo_title'] = '美拍视频下载地址在线解析工具-parsevideo.com';
$info['seo_keywords'] = '美拍视频下载地址在线解析工具';
$info['seo_description'] = '美拍视频下载地址在线解析工具';
$info['url_input_placeholder'] = "请输入美拍网址，如：http://www.meipai.com/media/688342435";

class Meipai {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		$html = Base::_cget($url);
		preg_match("~content=\"([^<>]*?)\" property=\"og:image\"~i", $html, $thumb);
		preg_match("~<meta content=\"([^<>]*?)\" property=\"og:title\">~i", $html, $desc);
		preg_match("~<meta content=\"([^<>]*?)\" property=\"og:video:secure_url\">~i", $html, $url);
		if(!empty($url[1])){
			$video[] = array(
				'url'=>self::decode($url[1]),
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
	
	private static function decode($str){
		if(empty($str)) return false;
		$hex = hexdec(strrev(substr($str,0,4)));
		$str = substr($str,4);
		$pre = $tail = array();
		foreach(str_split($hex) as $i=>$k){
			if($i<2){
				$pre[$i]=$k;
			}else{
				$tail[($i-2)]=$k;
			}
		}
		$str2 = substr($str,$pre[0],$pre[1]);
		$str = str_replace($str2,"",$str);
		$tail[0] = (strlen($str)-$tail[0]-$tail[1]);
		$str2 = substr($str,$tail[0],$tail[1]);
		$str = str_replace($str2,"",$str);
		return base64_decode($str);
	}
}