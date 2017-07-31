<?php

$info['seo_title'] = '小咖秀视频下载地址在线解析，xiaokaxiu视频下载工具-parsevideo.com';
$info['seo_keywords'] = '小咖秀保存别人的视频,小咖秀视频下载地址在线解析';
$info['seo_description'] = '小咖秀保存别人的视频方法，使用视频下载地址解析工具，得到小咖秀视频的真实地址后直接下载到本地电脑或手机上即可。';
$info['url_input_placeholder'] = "请输入小咖秀视频网址，如：https://v.xiaokaxiu.com/v/t4bv1pNMpEPp3u8q8L2MWqf9sMXVLrL5.html";

class Xiaokaxiu {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~(/m/|/v/)([^\/\.]+)~i", $url,$id)){
			$vid = $id[2];
		}

		if(!empty($vid)){
			$url = "http://api.xiaokaxiu.com/video/web/get_play_video?scid={$vid}";
			$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
			$html = @json_decode($html,1);
			if(is_array($html) && !empty($html['data'])){
				$video[] = array(
					'url'=>$html['data']['linkurl'],
					'thumb'=>$html['data']['cover'],
					'desc'=>$html['data']['title'],
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