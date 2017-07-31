<?php

$info['seo_title'] = '快手视频下载工具，快手视频免水印下载方法，快手视频地址在线解析-parsevideo.com';
$info['seo_keywords'] = '快手视频无水印下载，快手无水印视频下载器，快手视频下载工具，快手视频提取工具，快手视频怎么保存本地';
$info['seo_description'] = '视频解析网提供的快手视频无水印下载工具，可以直接解析快手视频的下载地址，将快手视频保存到本地，不用再为不知道快手视频怎么下载而烦恼。';
$info['url_input_placeholder'] = "请输入快手视频网址，如：http://www.kuaishou.com/photo/188818/1712172300";

class Kuaishou {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		$html = Base::_cget($url);
		preg_match("~(poster=|<meta property=\"og:video:url\" content=)\"(.*?)\"~i", $html, $temp);
		preg_match("~<title>([\s\S]*?)<~i", $html, $temp2);

		if(!empty($temp[2])){
			$video[] = array(
				'url'=>str_replace(".jpg", ".mp4", $temp[2]),
				'thumb'=>str_replace(".mp4", ".jpg", $temp[2]),
				'desc'=>trim(strip_tags($temp2[1])),
			);	
			$data['pages'] = 0;
			$data['total'] = count($video);
			$data['video'] = $video;			
			return $data;
		}
		return false;
	}
}