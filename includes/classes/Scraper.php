<?php
namespace Mhmmdq\Wordpress\Cer;
use PHPHtmlParser\Dom;
class Scraper {

    protected static $url = 'https://irica.ir/web_directory/54345-%D9%86%D8%B1%D8%AE-%D8%A7%D8%B1%D8%B2.html';
    protected static $html;
    protected static $dom;
    protected static $cacheFolder = CER_PLUGIN_PATH . '/cache/';
    protected static $cash;
    public function __construct()
    {
        
        if(self::checkLastedCrawel()) {
            self::updateCache(self::crawlData());
        }

    }

    public static function checkLastedCrawel() {
        return !file_exists(self::$cacheFolder . date('Y-m-d'));
    }

    public static function getCache() {
        if(file_exists(self::$cacheFolder . date('Y-m-d'))) {
            $f = fopen(self::$cacheFolder . date('Y-m-d') , 'r');
            return unserialize(fread($f , filesize(self::$cacheFolder . date('Y-m-d'))));
            fclose($f);
        }else {
            return self::crawlData();
        }
        
    }
    
    public static function crawlData() {
        set_time_limit(0);
        $dom = new Dom;
        $dom->loadFromUrl(self::$url);
        $html = $dom->outerHtml;
        $table = $dom->find('table')[3];
        $dom->loadStr($table);
        foreach($dom->find('img') as $img) {
            $img->delete();
        }
        $dom->loadStr($dom);
        unset($img);
        $result = [];
        foreach($dom->find('tr') as $tr) {
            $dom->loadStr($tr);
            foreach($dom->find('td') as $td) {
                if(strpos($td , '<a') !==false){
                    continue;
                }
                $result[] = str_replace('&nbsp;' , '' , $td->innerHtml);
            }
        }
        unset($result[count($result) - 1] ,$result[0] , $result[1] , $result[2]);
        return $result;
    }
    public static function updateCache($array) {
        $f = fopen(self::$cacheFolder . date('Y-m-d') , 'w');
        fwrite($f , serialize([
            'nextCrawlTime' =>  time() * 60 * 60 * 24 ,
            'data' => $array
        ]));
        fclose($f);
    }

}