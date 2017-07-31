<?php

$info['seo_title'] = '音悦台1080P解析破解免积分下载软件，音悦台VIP视频下载，音悦台MV在线解析-parsevideo.com';
$info['seo_keywords'] = '音悦台MV,音悦台MV 1080p下载,高清MV下载，音悦台1080p解析，音悦台视频下载器，音悦台VIP视频下载，音悦台视频在线解析，音悦台mv解析';
$info['seo_description'] = '音悦台1080P解析破解免积分下载软件，可以直接下载音悦台MV，将音悦台MV保存到本地电脑或手机。';
$info['url_input_placeholder'] = "请输入音悦Tai网址，如：http://v.yinyuetai.com/video/2804848";

class Yinyuetai {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~(\?id=|/video/|/video/h5/)([\d]+)~i", $url,$id)){
			$vid = $id[2];
		}

		if(!empty($vid)){
			//http://choosek.net/index.php/archives/42/			
			$url = "http://www.yinyuetai.com/insite/get-video-info?json=true&videoId={$vid}";
			$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
			$html = @json_decode($html,1);
			//print_r($html);exit;
			if(is_array($html) && !empty($html['videoInfo']['coreVideoInfo'])){
				foreach ($html['videoInfo']['coreVideoInfo']['videoUrlModels'] as $key => $value) {
					$video[] = array(
						'url'=>$value['videoUrl'],
						'thumb'=>$html['videoInfo']['bigHeadImage'],
						'desc'=>$value['qualityLevelName'],
					);						
				}
		
			}
			$data['pages'] = 0;
			$data['total'] = count($video);
			$data['video'] = $video;			
			return $data;
		}
		return false;
	}
}