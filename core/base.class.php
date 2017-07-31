<?php
$info = array();
$info['seo_title'] = '视频解析网，微博、秒拍、汤不热视频解析下载网站-parsevideo.com';
$info['seo_keywords'] = '微博秒拍视频下载，微博视频解析下载,秒拍视频解析下载,汤不热视频解析下载,youtube视频解析下载,酷我MV在线下载,facebook视频解析下载,音悦台VIP在线解析下载,在线网页视频地址解析';
$info['seo_description'] = '视频解析网是专业的视频下载地址解析网站，提供微博视频、秒拍视频、汤不热视频(tumblr)、哔哩哔哩(B站)、facebook视频、快手等视频网站的下载地址解析服务，用户可以直接输入视频网址，得到视频文件的真实下载地址。';
$info['url_input_placeholder'] = "请输入视频地址，如：http://weibo.com/tv/v/Ez325gw4G";

class Base
{

    const USER_AGENT = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36";
    private static $proxy = null;

    /*
     * 通过 file_get_contents 获取内容
     */
    public static function _fget($url = '')
    {
        if (!$url) return false;
        $html = file_get_contents($url);
        return $html;
    }

    /*
     * 通过 fsockopen 获取内容
     */
    public static function _fsget($path = '/', $host = '', $user_agent = '')
    {
        if (!$path || !$host) return false;
        $html = null;
        $user_agent = $user_agent ? $user_agent : self::USER_AGENT;

        $out = <<<HEADER
GET $path HTTP/1.1
Host: $host
User-Agent: $user_agent
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: zh-cn,zh;q=0.5
Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7\r\n\r\n
HEADER;
        $fp = @fsockopen($host, 80, $errno, $errstr, 10);
        if (!$fp) return false;
        if (!fputs($fp, $out)) return false;
        while (!feof($fp)) {
            $html .= @fgets($fp, 1024);
        }
        fclose($fp);
    }

    
    /*
     * 通过 curl 获取内容
     */  
	public static function _cget($url, $data = "", $header = array(), $user_agent = '', $referer = '')
	{
		if (!$url) return false;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 99);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
	    if(defined('PROXY') && !empty(PROXY)){
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5_HOSTNAME);
			curl_setopt($ch, CURLOPT_PROXY, PROXY); //代理ip 端口	    	
	    }
	    if ($data) {
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    }
		
		if(is_array($header) && !empty($header)){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
	    
		if($referer){
			curl_setopt($ch, CURLOPT_AUTOREFERER, $referer);
		} else {
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		}
	    
		if($user_agent){
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		} else {
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0');
		}
	    
	    $temp = curl_exec($ch);
		if(is_string($temp) && !empty($temp)){
			return $temp;
		}
		return false;	    
	}

    /**
     * [getHeader 通过curl获得header]
     * @param  [type] $url        [description]
     * @param  string $user_agent [description]
     * @return [type]             [description]
     */
    public static function getHeader($url, $user_agent = '')
    {
        $user_agent = $user_agent ? $user_agent : self::USER_AGENT;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE); //表示需要response header
        curl_setopt($ch, CURLOPT_NOBODY, TRUE); //表示不需要需要response body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
            return $result;
        }

        return NULL;
    }

    /**
     * [rolling_curl curl 并发]
     * @param  [type] $urls  [description]
     * @return [type]        [description]
     */
    public static function rolling_curl($urls)
    {
        $queue = curl_multi_init();
        $map = array();
        foreach ($urls as $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
            curl_multi_add_handle($queue, $ch);
            $map[(string)$ch] = $url;
        }
        $responses = array();
        do {
            while (($code = curl_multi_exec($queue, $active)) == CURLM_CALL_MULTI_PERFORM);
            if ($code != CURLM_OK) {
                break;
            }
            // a request was just completed -- find out which one
            while ($done = curl_multi_info_read($queue)) {
                // get the info and content returned on the request
                $info = curl_getinfo($done['handle']);//获得请求信息
                $error = curl_error($done['handle']);//获得错误信息
                $results = curl_multi_getcontent($done['handle']);//获得请求结果
                $responses[$map[(string)$done['handle']]] = compact('info','error','results');//获得的信息，重组数组
                // remove the curl handle that just completed
                curl_multi_remove_handle($queue, $done['handle']);
                curl_close($done['handle']);
            }
            // Block for data in / output; error handling is done by curl_multi_exec
            if ($active > 0) {
                curl_multi_select($queue, 0.5);
            }
        } while ($active);
        curl_multi_close($queue);
        return $responses;
    }

}