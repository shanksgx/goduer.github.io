<?php

$info['seo_title'] = 'tumblr视频下载,汤不热视频下载地址在线解析-parsevideo.com';
$info['seo_keywords'] = 'tumblr视频下载，汤不热视频下载地址在线解析，手机tumblr视频提取，汤不热福利视频，汤不热视频批量下载';
$info['seo_description'] = '汤不热视频下载地址在线解析，汤不热福利视频批量下载工具，可以下载tumblr视频';
$info['url_input_placeholder'] = "请输入tumblr网址，如：https://xizi199108.tumblr.com/post/158057213058/";

class Tumblr {
	
	public static function parse($url){
		if (!$url) return false;
		$html = $vid = "";
		$data = $video = array();
		if(preg_match("~/post/(\d+)~i", $url,$id)){
			$vid = $id[1];
		}
		$page = 0;
		if(preg_match("~/page/(\d+)~i", $url,$p)){
			$page = $p[1];
		}
		$uri = parse_url($url);

		if(!empty($vid)){
			$url = "https://{$uri[host]}/api/read/json?debug=1&type=video&id={$vid}";
			//$url = "http://api.tumblr.com/v2/blog/{$uri[host]}/posts/video/?api_key=0vnPZgYAxI84PbLXDhSsQX3snzk5OSfJdyttEA28en26KvwWQ3&notes_info=false&id={$vid}";
			$html = Base::_cget($url);
			$html = @json_decode($html,1);
			//print_r($html);
			if(!empty($html['posts'][0]['video-source'])){
				$temp = @array_filter(@unserialize($html['posts'][0]['video-source']));
				if(!empty($temp['o1']['video_preview_filename_prefix'])){
					$video[] = array(
						'url'=>"https://vt.media.tumblr.com/".trim($temp['o1']['video_preview_filename_prefix'],"_").".".$temp['o1']['extension'],
						'thumb'=>$temp['o1']['video_preview_filmstrip_url'],
						'desc'=>strip_tags($html['posts'][0]['video-caption']),
					);
					$data['total'] = count($video);
					$data['video'] = $video;				
					return $data;					
				}
			}
		}else{
			$url = "https://{$uri[host]}/api/read/json?debug=1&type=video&num=50&start=".($page*50);
			$html = Base::_cget($url);
			$html = @json_decode($html,1);
			//print_r($html);
			if(!empty($html['posts']) && is_array($html['posts'])){
				foreach ($html['posts'] as $key => $value) {
					$temp = @array_filter(@unserialize($value['video-source']));
					if(!empty($temp['o1']['video_preview_filename_prefix'])){
						$video[] = array(
							'url'=>"https://vt.media.tumblr.com/".trim($temp['o1']['video_preview_filename_prefix'],"_").".".$temp['o1']['extension'],
							'thumb'=>$temp['o1']['video_preview_filmstrip_url'],
							'desc'=>strip_tags($value['video-caption']),
						);							
					}				
				}
				$data['pages'] = round($html['posts-total']/50);	
				$data['total'] = count($video);
				$data['video'] = $video;							
				return $data;
			}else{
				return false;
			}	
		}
		return false;
	}
}