<?php

$info['seo_title'] = 'facebook视频在线解析，facebook视频下载方法-parsevideo.com';
$info['seo_keywords'] = 'facebook视频下载,facebook视频在线解析，facebook视频下载app';
$info['seo_description'] = 'facebook视频下载地址在线解析，将facebook的视频保存到本地。';
$info['url_input_placeholder'] = "请输入facebook网址，如：https://www.facebook.com/lisaeldridgedotcom/videos/10154227666371416/";

class Facebook {
	
	public static function parse($url){
		$html = $vid = "";
		$data = $video = array();
		$html = Base::_cget($url);
		if(!empty($html)){
			preg_match_all("~,([a-z]*?d_src[^,\"]*?):\"(.*?)\"~i", $html, $temp);
			if(!empty($temp[1]) && is_array($temp[1])){
				foreach ($temp[1] as $key => $value) {
					$video[] = array(
						'url'=>$temp[2][$key],
						'thumb'=>'',
						'desc'=>$temp[1][$key],
					);						
				}
				$data['pages'] = 0;
				$data['total'] = count($video);
				$data['video'] = $video;			
				return $data;	
			}

			preg_match("~/video_redirect/\?src=([^<>]*?)\"~i", $html, $temp);
			if(!empty($temp[1])){
				$video[] = array(
					'url'=>htmlspecialchars_decode(urldecode($temp[1])),
					'thumb'=>'',
					'desc'=>'',
				);					
				$data['pages'] = 0;
				$data['total'] = count($video);
				$data['video'] = $video;			
				return $data;	
			}

		}
		return false;
	}
}