<?php

$info['seo_title'] = 'youtube视频下载地址在线解析，youtube视频下载工具-parsevideo.com';
$info['seo_keywords'] = 'youtube视频下载地址在线解析，youtube视频下载工具，youtube视频下载器';
$info['seo_description'] = 'youtube视频真实下载地址在线解析，可以直接得到youtube的MP4下载地址，然后导入到下载工具中下载。';
$info['url_input_placeholder'] = "请输入youtube网址，如：https://www.youtube.com/watch?v=UUweG0bobAc";


class Youtube {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~(v=|/embed/|youtu.be/)([^&\?\"]+)~i", $url,$id)){
			$vid = $id[2];
		}

		if(!empty($vid)){
			//$url = "https://m.youtube.com/watch?ajax=1&debug_prerolls=false&layout=mobile&tsp=1&utcoffset=&v={$vid}";
			$url = "http://www.youtube.com/get_video_info?video_id={$vid}&el=vevo&ps=default&eurl=&asv=2";
			$html = Base::_cget($url,"","","Mozilla/5.0 (Linux; U; Android 4.4.4; Nexus 5 Build/KTU84P) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30");
			$html = str_replace(")]}'", "", $html);
			parse_str($html,$temp);
			//print_r($temp);exit;
			foreach (@explode(",", $temp['url_encoded_fmt_stream_map']) as $key => $value) {
				parse_str($value,$temp2);
				if($temp2['url'] && preg_match("~mp4~i", $temp2['type'])){
					$video[] = array(
						'url'=>preg_replace("~//.*?googlevideo\.com~i", "//redirector.googlevideo.com", $temp2['url']),
						'thumb'=>$temp['iurl'],
						'desc'=>$temp['title'],
					);
					break;
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