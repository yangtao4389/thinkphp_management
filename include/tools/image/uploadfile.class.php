<?

/* 
* 功能：PHP图片水印 (水印支持图片或文字) 
* 参数： 
*       $groundImage     背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式； 
*       $waterPos        水印位置，有10种状态，0为随机位置； 
*                       1为顶端居左，2为顶端居中，3为顶端居右； 
*                       4为中部居左，5为中部居中，6为中部居右； 
*image_watermark('3564_101207100851_1.jpg',9,'mark.png');
*/ 

function image_watermark($groundImage,$waterPos=0,$waterImage="",$waterText="",$fontSize=12,$textColor="#CCCCCC", $fontfile='',$xOffset=0,$yOffset=0){ 
     $isWaterImage = FALSE; 
     //读取水印文件 
     if(!empty($waterImage) && file_exists($waterImage)) { 
         $isWaterImage = TRUE; 
         $water_info = getimagesize($waterImage); 
         $water_w     = $water_info[0];//取得水印图片的宽 
         $water_h     = $water_info[1];//取得水印图片的高 

         switch($water_info[2])   {    //取得水印图片的格式  
             case 1:$water_im = imagecreatefromgif($waterImage);break; 
             case 2:$water_im = imagecreatefromjpeg($waterImage);break; 
             case 3:$water_im = imagecreatefrompng($waterImage);break; 
             default:return 1; 
         } 
     } 

     //读取背景图片 
     if(!empty($groundImage) && file_exists($groundImage)) { 
         $ground_info = getimagesize($groundImage); 
         $ground_w     = $ground_info[0];//取得背景图片的宽 
         $ground_h     = $ground_info[1];//取得背景图片的高 

         switch($ground_info[2]) {    //取得背景图片的格式  
             case 1:$ground_im = imagecreatefromgif($groundImage);break; 
             case 2:$ground_im = imagecreatefromjpeg($groundImage);break; 
             case 3:$ground_im = imagecreatefrompng($groundImage);break; 
             default:return 1; 
         } 
     } else { 
         return 2; 
     } 

     //水印位置 
     if($isWaterImage) { //图片水印  
         $w = $water_w; 
         $h = $water_h; 
         $label = "图片的";
         } else {  
     //文字水印 
        if(!file_exists($fontfile))return 4;
         $temp = imagettfbbox($fontSize,0,$fontfile,$waterText);//取得使用 TrueType 字体的文本的范围 
         $w = $temp[2] - $temp[6]; 
         $h = $temp[3] - $temp[7]; 
         unset($temp); 
     } 
     if( ($ground_w < $w) || ($ground_h < $h) ) { 
         return 3; 
     } 
     switch($waterPos) { 
         case 0://随机 
             $posX = rand(0,($ground_w - $w)); 
             $posY = rand(0,($ground_h - $h)); 
             break; 
         case 1://1为顶端居左 
             $posX = 0; 
             $posY = 0; 
             break; 
         case 2://2为顶端居中 
             $posX = ($ground_w - $w) / 2; 
             $posY = 0; 
             break; 
         case 3://3为顶端居右 
             $posX = $ground_w - $w; 
             $posY = 0; 
             break; 
         case 4://4为中部居左 
             $posX = 0; 
             $posY = ($ground_h - $h) / 2; 
             break; 
         case 5://5为中部居中 
             $posX = ($ground_w - $w) / 2; 
             $posY = ($ground_h - $h) / 2; 
             break; 
         case 6://6为中部居右 
             $posX = $ground_w - $w; 
             $posY = ($ground_h - $h) / 2; 
             break; 
         case 7://7为底端居左 
             $posX = 0; 
             $posY = $ground_h - $h; 
             break; 
         case 8://8为底端居中 
             $posX = ($ground_w - $w) / 2; 
             $posY = $ground_h - $h; 
             break; 
         case 9://9为底端居右 
             $posX = $ground_w - $w; 
             $posY = $ground_h - $h; 
             break; 
         default://随机 
             $posX = rand(0,($ground_w - $w)); 
             $posY = rand(0,($ground_h - $h)); 
             break;     
     } 

     //设定图像的混色模式 
     imagealphablending($ground_im, true); 
     if($isWaterImage) { //图片水印 
         imagecopy($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h);//拷贝水印到目标文件         
     } else {//文字水印
         if( !empty($textColor) && (strlen($textColor)==7) ) { 
             $R = hexdec(substr($textColor,1,2)); 
             $G = hexdec(substr($textColor,3,2)); 
             $B = hexdec(substr($textColor,5)); 
         } else { 
           return 5;
         } 
         imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
     } 
      //生成水印后的图片 
     @unlink($groundImage); 
     switch($ground_info[2]) {//取得背景图片的格式 
         case 1:imagegif($ground_im,$groundImage);break; 
         case 2:imagejpeg($ground_im,$groundImage);break; 
         case 3:imagepng($ground_im,$groundImage);break; 
         default: return 6; 
     } 

     //释放内存 
     if(isset($water_info)) unset($water_info); 
     if(isset($water_im)) imagedestroy($water_im); 
     unset($ground_info); 
     imagedestroy($ground_im); 
     //
     return 0;
}

/**
 * @author jyw
 *
 */
class uploadfile{
	var $uploaddir='';
	var $webroot = '';
 	/**
 	 * 设置上传目录最后带 '/'
 	 * @param $webroot
 	 * @param $dirpath
 	 * @return void
 	 */
 	function setuploaddir($webroot,$dirpath){
		$this->webroot = $webroot;
		$path =$this->webroot.$dirpath .date("Ym")."/";
		is_dir($path) || $this->make_dir($path);
		$this->uploaddir = $path;
	}
	
	/**
	 * 上传一张图片,type=1是图片,否则flash,返回array(1,相对路径,全路径)
	 * @param $filearr
	 * @param $type
	 * @return array
	 */
	function uploadimg($filearr,$type=1){
		if($type==1){//图片
 			$imginfo = getimagesize($filearr["tmp_name"]);
			if(!$imginfo)	return array(-1,'imagetype error');
		}else{
			$swfmime = 'application/x-shockwave-flash';
			if($swfmime != $filearr['type'])return array(-1,'swftype error');
		}
 		$extname = strtolower(pathinfo($filearr["name"], PATHINFO_EXTENSION)); //扩展名
		$newfilename = $this->getfilename();
 		$fullpath = $this->uploaddir."$newfilename.$extname";
 		if(!move_uploaded_file($filearr["tmp_name"], $fullpath))return array(-2,'move tmp error');
		$imgpath = str_replace($this->webroot, '', $fullpath);
		$this->writeimglog($imginfo[0],$imginfo[1],$imgpath);//写入日志
 		return array(1,$imgpath,$fullpath);
  	}
	
	
	/**
	 * 上传多张图片
	 * @param $filearr
	 * @param $type
	 * @return array
	 */
	function uploadmoreimg($filearr,$type=1){
		$rarr = array();
		for($i=0;$i<count($filearr['name']);$i++){
			$farr = array(
				'name'=>$filearr['name'][$i],
				'type'=>$filearr['type'][$i],
				'tmp_name'=>$filearr['tmp_name'][$i],
				'error'=>$filearr['error'][$i],
				'size'=>$filearr['size'][$i]
			);
		 
		 	$rarr[] = $this->uploadimg($farr,$type);
		}
		return $rarr;
	}
	
	
	/**
	 * 返回随机文件名
	 * @return string
	 */
	function getfilename(){
		return strftime("%H%M%S", time()) . mt_rand(1000, 9999);
	}
	
	/**
	 * 写入图片日志到数据库
	 * @param $width
	 * @param $height
	 * @param $uploadpath
	 * @return void
	 */
	function writeimglog($width,$height,$uploadpath){
		global $_SGLOBAL;
		$inarr = array(
			'username'=>$_SGLOBAL['super_username'],
			'uploadtime'=>time(),
			'imgwh'=>$width.'*'.$height,
 			'uploadpath'=>$uploadpath
		);
		inserttable('imagelog',$inarr);
	}
	/**
	 * 创建文件夹,需要全路径
	 * @param $dir
	 * @param $mode
	 * @return void
	 */
	function make_dir($dir, $mode = 0777){
    	if (is_dir($dir) || @mkdir($dir, $mode)) return true;
    	if (!$this->make_dir(dirname($dir), $mode)) return false;
    	return @mkdir($dir, $mode);
	}
}
/*
	$obj_img = new uploadfile();
	$obj_img->setuploaddir(WEB_ROOT,'uploadpic/');
	$file = $obj_img->uploadmoreimg($_FILES["fileup"]);
	print_r($file);
*/
?>