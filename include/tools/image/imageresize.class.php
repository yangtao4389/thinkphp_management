<?php
//生成缩略图通用函数makelitpic(dirname(__FILE__).'/distribdata/uploadpic/201012/1459298196.jpg',150,150);
function makelitpic($filepath,$needw,$needh,$diyname='',$isdel=false){
	//$needw = 150;$needh = 120;
	$rwidth= $needw<=$needh ? $needw : 0;
	$rheight=$needh<=$needw ? $needh:0;
 	$obj_img = new ImageResize();
	$obj_img->load($filepath);
	if($rwidth==$rheight){
		$sourcew = $obj_img->_width;
		$sourceh = $obj_img->_height;
		if($sourcew>$sourceh){
			$rwidth =0 ;$rheight =$needh ;
		}else{
			$rwidth =$needw ;$rheight =0 ;
		}
	}
	 
  	//按比例缩放
	$obj_img->resize($rwidth,$rheight);
	//获得当前宽高
	$noww = $obj_img->_width;
	$nowh = $obj_img->_height;
   	$x=0;$y=0;
	if($noww>$needw){
		$x = intval(($noww-$needw)/2);
		$y=0;
	}else{
		$x =0 ;
		$y=intval(($nowh-$needh)/2);
	}
 	
	$obj_img->cut($needw,$needh,$x,$y);
	$filename = pathinfo($filepath, PATHINFO_BASENAME);
 	$fullpath = str_replace($filename,'lit_'.$diyname.$filename,$filepath);
 	$obj_img->save($fullpath);
	if($isdel){$obj_img->delpic();}
	return $fullpath;
}
/**
* 图片缩放和裁剪类
*/

class ImageResize
{
	//源图象
	var $_img;
	//图片类型
	var $_imagetype;
	//实际宽度
	var $_width;
	//实际高度
	var $_height;
	var $oldimg;
 	var $fontpath;
 

	//载入图片
	/**
	 * @param $img_name
	 * @param $img_type
	 * @return unknown_type
	 */
	function load($img_name){
 	    $this->get_type($img_name);//获得图片类型
		switch ($this->_imagetype){
			case 'gif':
				$this->_img=imagecreatefromgif($img_name);
				break;
			case 'jpg':
				$this->_img=imagecreatefromjpeg($img_name);
				break;
			case 'png':
				$this->_img=imagecreatefrompng($img_name);
				break;
			default:
				$this->_img=imagecreatefromstring($img_name);
				break;
		}
		$this->oldimg = $img_name;
		$this->getxy();
	}

	//缩放图片
	function resize($needw, $needh){
    	
		if($this->_width>$this->_height){//若原图像宽大于高,根据高度计算出宽度
			$rwidth = round($needh * $this->_width / $this->_height );
			$rheight=$needh;
		}else{
			$rwidth = $needw;
			$rheight = round($needw * $this->_height / $this->_width);
		}
   		$tmpimg = imagecreatetruecolor($rwidth,$rheight);//等比例缩放后图片
		imagecopyresampled($tmpimg, $this->_img, 0, 0, 0, 0, $rwidth, $rheight, $this->_width, $this->_height);
   		$this->destroy();
		$this->_img = $tmpimg;
		$this->getxy();
	
	}
	
	//裁剪图片
	function cut($width, $height, $x=0, $y=0){
		if($width>$this->_width && $height>$this->_height){
			return;
		}
		if(!is_resource($this->_img)) return false;
		if($width > $this->_width) $width = $this->_width;
		if($height > $this->_height) $height = $this->_height;
		if($x < 0) $x = 0;
		if($y < 0) $y = 0;
		$tmpimg = imagecreatetruecolor($width,$height);
		imagecopy($tmpimg, $this->_img, 0, 0, $x, $y, $width, $height);
		$this->destroy();
		$this->_img = $tmpimg;
		$this->getxy();
	}
	
	
	//显示图片
	function display($destroy=true)
	{
		if(!is_resource($this->_img)) return false;
		switch($this->_imagetype){
			case 'jpg':
			case 'jpeg':
				header("Content-type: image/jpeg");
				imagejpeg($this->_img);
				break;
			case 'gif':
				header("Content-type: image/gif");
				imagegif($this->_img);
				break;
			case 'png':
			default:
				header("Content-type: image/png");
				imagepng($this->_img);
				break;
		}
		if($destroy) $this->destroy();
	}

	//保存图片 $destroy=true 是保存后销毁图片变量，false这不销毁，可以继续处理这图片
	function save($fname, $destroy=false, $type=''){
		if(!is_resource($this->_img)) return false;
		if(empty($type)) $type = $this->_imagetype;
		switch($type){
			case 'jpg':
			case 'jpeg':
				$ret=imagejpeg($this->_img, $fname);
				break;
			case 'gif':
				$ret=imagegif($this->_img, $fname);
				break;
			case 'png':
			default:
				$ret=imagepng($this->_img, $fname);
				break;
		}
		if($destroy) $this->destroy();
		return $ret;
	}
	/**
	 * 设置中文字体路径
	 * @return void
	 */
	function setfontpath($path){
		$this->fontpath = $path;		
	}
	/**
	 *  给图片加文字imgsrc=图片路径,text=文字,
	 *  fcolor=文字颜色,newpath=存储路径空则覆盖原图片
	 * @param $imgsrc
	 * @param $text
	 * @param $fcolor
	 * @param $newpath
	 * @return unknown_type
	 */
	function makeImageText($imgsrc,$text,$fcolor='#000000',$newpath=''){
		$fontfile = $this->fontpath; $textFont=5;
		$newpath = $newpath==''? $imgsrc : $newpath;
		list($imgwidth,$imgheight,$type, $attr) = getimagesize($imgsrc);//获得图像信息
	 	switch($type){//1 = GIF，2 = JPG，3 = PNG，
			case 1:
				$im = imagecreatefromgif($imgsrc);break;
			case 2:
				$im = imagecreatefromjpeg($imgsrc);break;
			case 3:
				$im = imagecreatefrompng($imgsrc);break;
		}
	 	$bgcolor = imagecolorallocatealpha($im,0,0, 0,80);//透明背景层颜色
		if($fcolor){
			$fcolor = str_replace('#','',$fcolor);
			$r = hexdec(substr($fcolor,0,2));//16进制颜色转成10进制
			$g = hexdec(substr($fcolor,2,2));
			$b = hexdec(substr($fcolor,4,2));
		}else{
			$r=0;$g=0;$b=0;
		}
	 
		$fontcolor = imagecolorallocate($im,$r,$g,$b);
		$bgheight=18;
		//计算底部中间位置
		$y1 = $imgheight-$bgheight;
		$x2 = $imgwidth;$y2=$imgheight;
		//画一长方形
		imagefilledrectangle($im,0,$y1,$x2,$y2,$bgcolor);
		$temp = imagettfbbox ( ceil ( $textFont * 2.5 ), 0 ,$fontfile , $text ); //取得使用 TrueType 字体的文本的宽高范围 
	    $w = $temp [ 2 ] - $temp [ 6 ]; 
		$h = $temp [ 3 ] - $temp [ 7 ]; 
	
	 	$strx1=($imgwidth - $w)/2;
		$stry1 =$imgheight-$bgheight/3;	
		imagettftext($im,ceil ($textFont * 2.5),0,$strx1,$stry1,$fontcolor,$fontfile,$text); 
		
		//imagestring($im,5,$strx1,$stry1,$text,$fontcolor);只适用英文
		switch($type){//1 = GIF，2 = JPG，3 = PNG，
			case 1:
				imagegif($im,$newpath);break;
			case 2:
				imagejpeg($im,$newpath);break;
			case 3:
				imagepng($im,$newpath);break;
		}
		
	}
	//销毁图像
	function destroy()
	{
		if(is_resource($this->_img)) imagedestroy($this->_img);
 	
	}
	function delpic(){
		@unlink($this->oldimg);
	}
	//取得图像长宽
	function getxy()
	{
		if(is_resource($this->_img)){
			$this->_width = imagesx($this->_img);
			$this->_height = imagesy($this->_img);
		}
	}
	

	//获得图片的格式，包括jpg,png,gif
	function get_type($img_name){
		list($imgwidth,$imgheight,$type, $attr) = getimagesize($img_name);
 		switch($type){
			case 1:
				$this->_imagetype = 'gif';break;
			case 2:
				$this->_imagetype = 'jpg';break;
			case 3:
				$this->_imagetype = 'png';break;
		}
		 
	}
}
?>