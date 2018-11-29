<?php
class ImgMake{
	public function mergeImage($bg, $qr, $out, $param)
    {
        list($bgWidth, $bgHeight) = getimagesize($bg);
        list($qrWidth, $qrHeight) = getimagesize($qr);
        extract($param);
        $tmpfile1 = rand(10000, 99999) . '.jpg';
        copy($bg, $tmpfile1);
        $tmpfile2 = rand(10000, 99999) . '.jpg';
        copy($qr, $tmpfile2);
        $bgImg = $this->imagecreate($tmpfile1);
        $qrImg = $this->imagecreate($tmpfile2);
        imagecopyresized($bgImg, $qrImg, $left, $top, 0, 0, $width, $height, $qrWidth, $qrHeight);
        ob_start();
        imagejpeg($bgImg, NULL, 100);
        $contents = ob_get_contents();
        ob_end_clean();
        @unlink($tmpfile1);
        @unlink($tmpfile2);
        $fh = fopen($out, 'w+');
        fwrite($fh, $contents);
        fclose($fh);
    }
    public function imagecreate($bg)
    {
        $bgImg = @imagecreatefromjpeg($bg);
        if (FALSE == $bgImg) {
            $bgImg = @imagecreatefrompng($bg);
        }
        if (FALSE == $bgImg) {
            $bgImg = @imagecreatefromgif($bg);
        }
        return $bgImg;
    }

    public function writeText($bg, $out, $text, $param = array())
    {
        list($bgWidth, $bgHeight) = getimagesize($bg);
        extract($param);
        $im = imagecreatefromjpeg($bg);
        $black = imagecolorallocate($im, 0, 0, 0);
        $font = 'Public/res/font.TTF'; //字体文件
        $white = imagecolorallocate($im, 255, 255, 255);
        imagettftext($im, $size, 0, $left, $top + $size / 2, $black, $font, $text);
        ob_start();
        imagejpeg($im, NULL, 100);
        $contents = ob_get_contents();
        ob_end_clean();
        imagedestroy($im);
        $fh = fopen($out, 'w+');
        fwrite($fh, $contents);
        fclose($fh);
    }

    /**
	 * $srcFile - 图形文件
	 * $pixel - 尺寸大小，如：400*300
	 * $_quality - 图片质量，默认75
	 * $cut - 是否裁剪，默认1，当$cut=0的时候，将不进行裁剪
	 * $cache - 如果有缓存，是否直接用缓存，默认true
	 * 示例："< img src=\"".MiniImg('images/image.jpg','300*180',72,0)."\">"
	 * */
	public function thumb($srcFile, $w,$h, $_quality = 90, $cut=1, $cache=true){
		$_type = strtolower(substr(strrchr($srcFile,"."),1));
		$pixelInfo = array($w,$h);
		$pathInfo = pathinfo($srcFile);
		$_cut = intval($cut);
		$searchFileName = preg_replace("/\.([A-Za-z0-9]+)$/isU", "_"."m".".\\1", $pathInfo['basename']);
		$miniFile = $pathInfo['dirname'].'/'.$searchFileName;
		if($cache and file_exists($miniFile)) return ltrim($miniFile,'.');
		$data = GetImageSize($srcFile);
		$FuncExists = 1;
		switch ($data[2]) {
			case 1:         //gif
				if(function_exists('ImageCreateFromGIF')) $_im = ImageCreateFromGIF($srcFile);
				break;
			case 2:         //jpg
				if(function_exists('imagecreatefromjpeg')) $_im = imagecreatefromjpeg($srcFile);
				break;
			case 3:         //png
				if(function_exists('ImageCreateFromPNG')) $_im = ImageCreateFromPNG($srcFile);
				break;
			case 6:         //bmp，这里需要用到ImageCreateFromBMP
				$_im = ImageCreateFromBMP($srcFile);
				break;
		}
		if(!$_im) return $srcFile;
		$sizeInfo['width'] = @imagesx($_im);
		$sizeInfo['height'] = @imagesy($_im);
		if(!$sizeInfo['width'] or !$sizeInfo['height']) return $srcFile;
		if($sizeInfo['width'] == $pixelInfo[0] && $sizeInfo['height'] == $pixelInfo[1] ) {
			return $srcFile;
		}elseif($sizeInfo['width'] < $pixelInfo[0] && $sizeInfo['height'] < $pixelInfo[1] && $miniMode=='2'){
			return $srcFile;
		}else{
			$resize_ratio = ($pixelInfo[0])/($pixelInfo[1]);
			$ratio = ($sizeInfo['width'])/($sizeInfo['height']);
			if($cut==1){
				$newimg = imagecreatetruecolor($pixelInfo[0],$pixelInfo[1]);
				if($ratio>=$resize_ratio){                                      //高度优先
					imagecopyresampled($newimg, $_im, 0, 0, 0, 0, $pixelInfo[0],$pixelInfo[1], (($sizeInfo['height'])*$resize_ratio), $sizeInfo['height']);
					$_result = ImageJpeg ($newimg,$miniFile, $_quality);
				}else{                                                          //宽度优先
					imagecopyresampled($newimg, $_im, 0, 0, 0, 0, $pixelInfo[0], $pixelInfo[1], $sizeInfo['width'], (($sizeInfo['width'])/$resize_ratio));
					$_result = ImageJpeg ($newimg,$miniFile, $_quality);
				}
			}else{                                                              //不裁图
				if($ratio>=$resize_ratio){
					$newimg = imagecreatetruecolor($pixelInfo[0],($pixelInfo[0])/$ratio);
					imagecopyresampled($newimg, $_im, 0, 0, 0, 0, $pixelInfo[0], ($pixelInfo[0])/$ratio, $sizeInfo['width'], $sizeInfo['height']);
					$_result = ImageJpeg ($newimg,$miniFile, $_quality);
				}else{
					$newimg = imagecreatetruecolor(($pixelInfo[1])*$ratio,$pixelInfo[1]);
					imagecopyresampled($newimg, $_im, 0, 0, 0, 0, ($pixelInfo[1])*$ratio, $pixelInfo[1], $sizeInfo['width'], $sizeInfo['height']);
					$_result = ImageJpeg ($newimg,$miniFile, $_quality);
				}
			}
			ImageDestroy($_im);
			ImageDestroy($newimg);
			if($_result) return ltrim($miniFile,'.');
			return ltrim($srcFile,'.');
		}
	}

	//生成缩略图
	public function thumbnails($srcFile,$dstFile,$maxWidth = 450,$maxHeight = ''){
	    ini_set('memory_limit', '-1'); //没有最大内存限制
	    set_time_limit(0); //设置无超时

	    $pattern = "/(.+).(jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF)$/";
	    preg_match($pattern,$srcFile,$matches);
	    $type = strtolower($matches[2]);
	    $type = ($type=='jpg')? 'jpeg' : $type;


	    list($srcPicW, $srcPicH) = @getimagesize($srcFile);

	    if(!empty($maxHeight)){
	        // 缩略图尺寸(按固定大小)
	        if($srcPicW > $maxWidth){
	            $dstPicW = $maxWidth;
	        }
	        else{
	            $dstPicW = $srcPicW;
	        }
	        if($srcPicH > $maxHeight){
	            $dstPicH = $maxHeight;
	        }
	        else{
	            $dstPicH = $srcPicH;
	        }
	    }
	    else{
	        // 缩略图尺寸(按比例)
	        if($srcPicW > $maxWidth){
	            $percent = $maxWidth/$srcPicW;
	            $dstPicW = $srcPicW * $percent;
	            $dstPicH = $srcPicH * $percent;
	        }
	        else{
	            $dstPicW = $srcPicW;
	            $dstPicH = $srcPicH;
	        }
	    }


	    //缩略图在画布中显示的坐标
	    $dstPicX = 0;
	    $dstPicY = 0;

	    //原图裁切的坐标
	    $srcPicX = 0;
	    $srcPicY = 0;

	    // 加载图像
	    switch($type){
	        case 'jpeg': {
	            $srcIm = @imagecreatefromjpeg($srcFile);
	        }
	        break;
	        case 'gif': {
	            $srcIm = @imagecreatefromgif($srcFile);
	        }
	        break;
	        case 'png': {
	            $srcIm = @imagecreatefrompng($srcFile);
	        }
	    }

	    $dstIm = @imagecreatetruecolor($dstPicW, $dstPicH);

	    // 调整大小
	    @imagecopyresized($dstIm,$srcIm,$dstPicX,$dstPicY,$srcPicX,$srcPicY,$dstPicW,$dstPicH,$srcPicW,$srcPicH);

	    //另存为自定义的文件
	    switch($type){
	        case 'jpeg': {
	            @imagejpeg($dstIm,$dstFile,100);
	        }
	        break;
	        case 'gif': {
	            @imagegif($dstIm,$dstFile,100);
	        }
	        break;
	        case 'png': {
	            @imagepng($dstIm,$dstFile,9);
	        }
	    }

	    //释放内存
	    @imagedestroy($dstIm);
	    @imagedestroy($srcIm);
	}

}