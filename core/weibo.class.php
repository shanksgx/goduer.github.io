<?php

$info['seo_title'] = '微博视频下载地址在线解析，微博视频下载器-parsevideo.com';
$info['seo_keywords'] = '微博秒拍保存到手机，新浪微博视频怎么保存，手机怎么下微博视频，微博视频下载器，手机能下微博视频软件';
$info['seo_description'] = '微博视频下载地址在线解析，使用视频解析得到下载地址，可以直接将新浪微博的视频保存到手机或电脑，是专业的微博视频下载器，微博福利视频备份利器。';
$info['url_input_placeholder'] = "请输入微博视频网址，如：http://weibo.com/tv/v/EyR7RBViW";

class Weibo {
	//http://video.weibo.com/media/play?livephoto=http%3A%2F%2Fus.sinaimg.cn%2F004FBY38jx0767Uy0HdC050401009o5O0k01.mp4
	public static function parse($url) {
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		$html = Base::_cget($url, "", "", "Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html）");
		if (!empty($html)) {
			preg_match("~node-type=\"[^<>]*?_video[^<>]*?\"[\s\S]*?action-data=\"(.*?)\"~i", $html, $temp);
			if (!empty($temp[1])) {
				parse_str($temp[1], $temp2);
				//print_r($temp2);
				$video[] = array(
					"url" => "http://video.weibo.com/media/play?livephoto=" . @current(@explode("?",$temp2['video_src'])), 
					"thumb" => $temp2['cover_img'],
					'desc'=>'',
				);
				$data['pages'] = 0;
				$data['total'] = count($video);
				$data['video'] = $video;
				return $data;
			}
			preg_match_all("~\"([^\"'<>]*?)\": \"([^\"'<>]*?)\"~i", $html, $temp);
			if (is_array($temp[1]) && !empty($temp[1]) && is_array($temp[2])) {
				$temp2 = array_combine($temp[1], $temp[2]);
				$video[] = array(
					"url" => $temp2['stream_url'], 
					"thumb" => $temp2['url'],
					'desc'=>'',
				);
				$data['pages'] = 0;
				$data['total'] = count($video);
				$data['video'] = $video;
				return $data;
			}
			
			preg_match("~flashvars=\"([^\"'<>]*?)\"~i", $html, $temp);
			if (!empty($temp[1])) {
				parse_str($temp[1], $temp2);
				$video[] = array(
					"url" => $temp2['list'], 
					"thumb" => $temp2['cover_img'],
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
