<?php

$info['seo_title'] = 'B站视频在线解析提取工具，哔哩哔哩bilibili视频在线下载-parsevideo.com';
$info['seo_keywords'] = 'B站视频在线解析，哔哩哔哩下载电脑版，bilibili怎么下载视频，哔哩哔哩视频下载方法';
$info['seo_description'] = '哔哩哔哩视频下载工具，解决将bilibili怎么保存视频的方法，哔哩哔哩下载电脑版，可以手机bilibili视频导出。';
$info['url_input_placeholder'] = "请输入B站网址，如：http://www.bilibili.com/video/av9061677/";

class Bilibili {
	
	public static function parse($url){
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~/av([\d]+)~i", $url,$id)){
			$vid = $id[1];
		}

		if(!empty($vid)){
			echo $url = "http://api.bilibili.com/playurl?aid=8825898&page=1&platform=html5&quality=1&vtype=mp4&type=json&token=".md5(time());
			$url = 'http://api.bilibili.com/playurl?aid=8825898&page=1&platform=html5&quality=1&vtype=mp4&type=jsonp&token=4209ef9406457f0e2ef24c9edacb60c9&_=1489328813998';
			echo $html = Base::_cget($url);
			if(!empty($html)){
				$html = @json_decode($html,1);
				print_r($html);exit;
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