<?php

$info['seo_title'] = '秒拍视频下载工具，秒拍福利视频下载-parsevideo.com';
$info['seo_keywords'] = '微博秒拍视频下载，秒拍福利视频，秒拍视频怎么下载，微博秒拍视频解析';
$info['seo_description'] = '想要把微博秒拍视频下载到本地？就使用视频解析网提供的秒拍视频下载工具，帮助你下载秒拍视频，将秒拍的视频保存到电脑或手机，。';
$info['url_input_placeholder'] = "请输入秒拍网址，如：http://www.miaopai.com/show/hrBaufJ83hueNLuuhPifdw__.htm";


class Miaopai {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~(show|channel)/([^\.\/]+)~i", $url,$id)){
			$vid = $id[2];
		}

		if(!empty($vid)){			
			$url = "http://api.miaopai.com/m/v2_channel.json?fillType=259&scid={$vid}&vend=miaopai";
			$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
			$html = @json_decode($html,1);
			//print_r($html);exit;
			if(is_array($html) && !empty($html['result'])){
						$video[] = array(
						'url'=>$html['result']['stream']['base'].$html['result']['stream']['sign'],
						'thumb'=>$html['result']['pic']['base'].$html['result']['pic']['m'],
						'desc'=>$html['result']['ext']['t'],
					);			
			}
			$data['pages'] = 0;
			$data['total'] = count($video);
			$data['video'] = $video;			
			return $data;
		}
		return false;
	}
}