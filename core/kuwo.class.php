<?php
$info['seo_title'] = '酷我MV在线解析提取工具，酷我MV下载方法-parsevideo.com';
$info['seo_keywords'] = '酷我MV在线解析，酷我MV提取工具，酷我MV下载方法，酷我mv在哪里';
$info['seo_description'] = '视频解析网提供酷我MV在线解析服务，是酷我MV下载地址的在线提取工具，也是最简单的酷我MV下载方法，可以直接将酷我MV保存到电脑。';
$info['url_input_placeholder'] = "请输入酷我MV网址，如：http://www.kuwo.cn/mv/6771610/";

class Kuwo {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~(mv/|yinyue/)([\d]+)~i", $url,$id)){
			$vid = $id[2];
		}

		if(!empty($vid)){
			$url = "http://antiserver.kuwo.cn/anti.s?rid=MUSIC_{$vid}&response=url&format=mp3%7Caac&type=convert_url";
			$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
			if(!empty($html)){
				$video[] = array(
					'url'=>$html,
					'thumb'=>'',
					'desc'=>'MP3',
				);		
			}
						
			$url = "http://antiserver.kuwo.cn/anti.s?rid=MUSIC_{$vid}&response=url&format=mp4|mkv&type=convert_url";
			$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");			
			if(!empty($html)){
				$video[] = array(
					'url'=>$html,
					'thumb'=>'',
					'desc'=>'MV',
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