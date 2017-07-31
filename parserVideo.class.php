<?php
//自动加载core里的class
define('CLASS_DIR', 'core/');
//define("PROXY", "socks5h://127.0.0.1:10801");
// Add your class dir to include path
set_include_path(str_replace("\\","/",__DIR__."/".CLASS_DIR));
// You can use this trick to make autoloader look for commonly used "My.class.php" type filenames
spl_autoload_extensions('.class.php');
// Use default autoload implementation
spl_autoload_register();


class ParserVideo
{
    const CHECK_URL_VALID = "~(tumblr\.com|youtube\.com|youtu\.be|weibo\.com|weibo\.cn|miaopai\.com|yinyuetai\.com|kuaishou\.com|gifshow\.com|vlook\.cn|xiaokaxiu\.com|kuwo\.cn|instagram\.com|facebook\.com|meipai\.com|bilibili\.com)~i";

    /**
     * parse 
     * @param string $url 
     * @static
     * @access public
     * @return void
     */
    static public function parse($url=''){
        $lowerurl = strtolower($url);
        preg_match(self::CHECK_URL_VALID, $lowerurl, $matches);
        if(!$matches) return false;

        switch($matches[1]){
            case 'tumblr.com':
                $data = self::_parseTumblr($url);
                break;
				
			case 'youtu.be':
            case 'youtube.com':
                $data = self::_parseYoutube($url);
                break;
			case 'weibo.cn':
            case 'weibo.com':
                $data = self::_parseWeibo($url);
                break;	
            case 'miaopai.com':
                $data = self::_parseMiaopai($url);
                break;				
            case 'yinyuetai.com':
                $data = self::_parseYinyuetai($url);
                break;
			case 'kuaishou.com':
			case 'gifshow.com':
                $data = self::_parseKuaishou($url);
                break;
			case 'vlook.cn':
                $data = self::_parseVlook($url);
                break;
			case 'xiaokaxiu.com':
                $data = self::_parseXiaokaxiu($url);
                break;
			case 'kuwo.cn':
                $data = self::_parseKuwo($url);
                break;
			case 'instagram.com':
                $data = self::_parseInstagram($url);
                break;
			case 'facebook.com':
                $data = self::_parseFacebook($url);
                break;
			case 'bilibili.com':
                $data = self::_parseBilibili($url);
                break;				
			case 'meipai.com':
                $data = self::_parseMeipai($url);
                break;								
            default:
                $data = false;
        }
        return $data;
    }



    static private function _parseTumblr($url){
        $data = array();
        $data = Tumblr::parse($url);
        return $data;
    }

    static private function _parseYoutube($url){
        $data = array();
        $data = Youtube::parse($url);
        return $data;
    }	

    static private function _parseWeibo($url){
        $data = array();
        $data = Weibo::parse($url);
        return $data;
    }

    static private function _parseMiaopai($url){
        $data = array();
        $data = Miaopai::parse($url);
        return $data;
    } 
	
    static private function _parseYinyuetai($url){
        $data = array();
        $data = Yinyuetai::parse($url);
        return $data;
    }  

    static private function _parseKuaishou($url){
        $data = array();
        $data = Kuaishou::parse($url);
        return $data;
    }  

    static private function _parseVlook($url){
        $data = array();
        $data = Vlook::parse($url);
        return $data;
    }  
	
    static private function _parseXiaokaxiu($url){
        $data = array();
        $data = Xiaokaxiu::parse($url);
        return $data;
    }  	
		
    static private function _parseKuwo($url){
        $data = array();
        $data = Kuwo::parse($url);
        return $data;
    }  	
	
    static private function _parseInstagram($url){
        $data = array();
        $data = Instagram::parse($url);
        return $data;
    }  		
	
    static private function _parseFacebook($url){
        $data = array();
        $data = Facebook::parse($url);
        return $data;
    }  		
    
    static private function _parseBilibili($url){
        $data = array();
        $data = Bilibili::parse($url);
        return $data;
    } 
     
    static private function _parseMeipai($url){
        $data = array();
        $data = Meipai::parse($url);
        return $data;
    } 
}
