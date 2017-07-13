<?php
/**解析pdf ,doc 中的内容为根本的类
 * Created by PhpStorm.
 * User: chindor
 * Date: 2017/6/24
 * Time: 17:33
 */
namespace office2text;

class OfficeToText
{
    const NOT_AN_VALID_PATH = '不是有效的文件!';
    const PDF_TO_TXT        = '解析pdf内容失败';
    const DOC_TO_TXT        = '解析doc文档内容失败';
    const DOCX_TO_TXT       = '解析docx文档内容失败';
    const NO_FOUND_XPDF     = '没有在服务器上发现xpdf组件';
    const NO_FOUND_ANTIWORD = '没有在服务器上发现antiword组件';
    const NOT_SUPPORT_FILE  = '暂不支持该文件类型';
    
    public  static  $error ;  //存放错误信息的容器
    private static  $environment;
    private static  $file_path;

    public  static  $configList = [
        'base_bath'         => '',    //默认为空 以ApiOfficeTotext文件所在的为基础目录
        'ignore_whitespace' => false,  //'是否忽略空格'
        'filter_pattern'    => '',    //'用于过滤的正则表达式' ///\w+|[\\/{}\-\^\$\|=*#@~&:]/

        //组件位置
        'antiword_path'  => [
            'windows' => 'G:\\wamp\\www\\baiduandTencentApi\\plugin\\antiword\\antiword\\antiword.exe',
            'linux'   => '/usr/local/bin/antiword',
        ],
        'xpdf_path'   => [
            'windows' => 'C:\\xpdftest\\xpdf\\bin32\\pdftotext.exe',
            'linux'   => '/usr/local/bin/pdftotext',
        ],
    ];

    /**低估合并数组 覆盖键
     * [array_merge_recursive_cover description]
     * @return [type] [description]
     */
    public static function array_merge_recursive_cover()
    {
        $func_arr = func_get_args();
        $res = $func_arr[0];
        foreach($func_arr as $arr){
            if(!is_array($arr)){
                return false;
            }

            foreach($arr as $k =>$v){
                $res[$k] = isset($res[$k])?$res[$k]:[];
                $res[$k] = is_array($v)?self::array_merge_recursive_cover($res[$k],$v):$v;
            }
        }
        return $res;
    }


    /**配置方法
     * [config description]
     * @param  [type] $arr [description]  配置数组
     * @return [type]      [description]
     */
    public static function config($arr)
    {
        self::$configList = self::array_merge_recursive_cover(self::$configList,$arr);
    }

    
    /**设置文档的错误提示内容
     * [setError description]  
     * @param [type] $erroNum [错误号]
     */
    public static function setError($erroNum)
    {
       switch($erroNum){
            case 1:
                $error = self::NOT_AN_VALID_PATH;
            break;
            case 2:
                $error = self::PDF_TO_TXT;
            break;
            case 3:
                $error = self::DOC_TO_TXT;
            break;
            case 4:
                $error = self::DOCX_TO_TXT;
            break;
            case 5:
                $error = self::NO_FOUND_XPDF;
            break;
            case 6:
                $error = self::NO_FOUND_ANTIWORD; 
            break;
            case 7:
                $error = self::NOT_SUPPORT_FILE; 
            break;
       }
       self::$error = $error;
    }

    /**解析pdf和doc,docx的公共調用方法
     * @param string $file   文件名或者路径(含文件名)
     * @return bool|mixed    失败返回false 成功返回相应的文本内容
     */
    public static function text($file = '')
    {
       //检查配置
       if(!self::check_config()){
          return false;
       }
       
       //检查文件路径是否正确
       if(!self::check_path($file)){
          return false;
       }

       $arr = explode('.',$file);
       $extension = array_pop($arr);
       if(strtolower($extension) == 'docx'){
           $txt = self::docToText($file);
       }else if(strtolower($extension) == 'pdf'){
           if(!self::check_pdf_plugin()) return false;
           $txt = self::PdfToText($file);
       }else if(strtolower($extension) == 'doc'){
           if(!self::check_doc_plugin()) return false;
           $txt = self::doc2003ToText($file);
       }else{
           self::setError(7);
           return false;
       }

       if($txt!==false && $txt!==''){
            return self::filter_by_pattern($txt);
       }

       return $txt;
    }

    /**对解析出来的txt 进行过滤
     * [filter_by_pattern description]
     * @param  [type] $txt [description]
     * @return [type]      [description]
     */
    public static function filter_by_pattern($txt)
    {
        if(self::$configList['ignore_whitespace'] === true) $txt = preg_replace('/\s+/', '', $txt);
        if(empty(self::$configList['filter_pattern'])) return $txt;
        return preg_replace(self::$configList['filter_pattern'], '', $txt);
    }
    
    /**将word2003 解析word2003中的文档内容
     * [doc2003ToText description]
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public static function doc2003ToText()
    { 
        $content = shell_exec(self::get_plugin('antiword').' -m UTF-8.txt '.self::filter_ilegal_charater(self::$file_path));
        if(isset($content)) return $content;
        self::setError(3);
        return false;
    }

    /**将doc文件中的内容转为文本
     * @param $file      文件名或者路径(含文件名)
     * @return mixed     返回提取出来的文本
     */
    public static function docToText()
    {
    
        $doc = new DocxToText();

        //加载docx文件
        if(!$doc -> setDocx(self::$file_path)){
            self::setError(4);
            return false;
        }

        // 将内容存入$docx变量中
        $text = $doc -> extract();
        return  $text;
    }

    /**将pdf中的内容解析成文字
     * @param $file         文件名或者路径(含文件名)
     * @return bool|mixed   返回提取出来的文本
     */
    public static function PdfToText($file)
    {

        shell_exec(self::get_plugin('xpdf').' '.self::filter_ilegal_charater(self::$file_path));
        var_dump(self::get_plugin('xpdf').' '.self::filter_ilegal_charater(self::$file_path));
        exit;
        $txt_path = self::changeExtension(self::$file_path,'txt');
            
        if(file_exists($txt_path) && is_file($txt_path)){
            return file_get_contents($txt_path);
        }

        self::setError(2);
        return false;
    }

    /**解析文件路径的方法
     * @param $file_path   文件名或者文件路径(含文件名)
     * @return bool|string
     */
    public static function check_path($file_path)
    {
        $file_path = rtrim(self::get_base_path(),'\\,/').DIRECTORY_SEPARATOR.ltrim($file_path,'/,\\');
        if(file_exists($file_path) && is_file($file_path)){
            self::$file_path = $file_path;
            return true;
        }
        self::setError(1);
        return false;
    }

    /**取得文件路径的方法
     * [get_base_path description]   取得配置文件中的基本的文件路径
     * @return [type] [description]  返回基本的文件路径
     */
    private static function get_base_path()
    {
        //默认为当前脚本所在的目录
        //否则为设置的路径
        return empty(self::$configList['base_bath'])?__DIR__:self::$configList['base_bath'];
    }

    /**切换文件后缀名的方法
     * @param $file               文件名或者文件路径(含文件名)
     * @param string $extension   要切换的后缀
     * @return string
     */
    public static function changeExtension($file,$extension='txt')
    {
        $lastDotIndex = mb_strripos($file,'.',0,'utf-8');
        if($lastDotIndex){
            return mb_substr($file,0,$lastDotIndex+1).$extension;
        }
        return false;
    }

    /**过滤非法字符
     * [filter_ilegal_charater description]
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    public static function filter_ilegal_charater($str)
    {
        return escapeshellcmd($str);
    }


    /**检查组件配置和系统环境
     * [check_config description]
     * @return [type] [description]
     */
    private static function check_config()
    {
        if(DIRECTORY_SEPARATOR=='/') self::$environment = 'linux' ;
        if(DIRECTORY_SEPARATOR=='\\') self::$environment = 'windows';
        return true;
    }

    private static function check_doc_plugin()
    {
        if(!file_exists(self::$configList['antiword_path'][self::$environment])){
            self::setError(6);
            return false;
        }
        return true;
    }

    private static function check_pdf_plugin()
    {
        if(!file_exists(self::$configList['xpdf_path'][self::$environment])){
            self::setError(7);
            return false;
        }
        return true;
    }

    /**
     * [get_plugin description]
     * @param  [type] $pluginName [description]
     * @return [type]             [description]
     */
    private static function get_plugin($pluginName)
    {
        return self::$configList[$pluginName.'_path'][self::$environment];
    }
}