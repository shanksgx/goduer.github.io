<?php
$info['seo_title'] = 'Instagram视频下载工具，Instagram视频下载地址解析-parsevideo.com';
$info['seo_keywords'] = 'Instagram视频下载方法，Instagram视频下载地址解析，Instagram视频导出，Instagram的视频怎么下载到手机上，';
$info['seo_description'] = 'Instagram视频下载到电脑的方法，可以奖Instagram的视频导出到手机，提供Instagram视频下载地址解析。';
$info['url_input_placeholder'] = "请输入instagram网址，如：https://www.instagram.com/p/BRhUm9ugipK/";

class Instagram {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~/p/(.*?)/~i", $url,$id)){
			$vid = $id[1];
		}

		if(!empty($vid)){
			$url = "https://www.instagram.com/p/{$vid}/?__a=1";
			$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
			if(!empty($html)){
				$html = @json_decode($html,1);
				//print_r($html);exit;
				if(!empty($html['media'])){
					$video[] = array(
						'url'=>$html['media']['video_url'],
						'thumb'=>$html['media']['display_src'],
						'desc'=>$html['media']['caption'],
					);	
				
					$data['pages'] = 0;
					$data['total'] = count($video);
					$data['video'] = $video;			
					return $data;					
				}
	
			}

		}
		return false;
	}
}