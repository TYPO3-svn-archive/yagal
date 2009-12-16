<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 * Description of GalleryBusiness
 * svn test boss
 *
 * @author mauri
 */
class Tx_Yagal_Business_GalleryBusiness {
//put your code here

	public function test() {
		$stdGrafix = t3lib_div::makeInstance('t3lib_stdGraphic');
		
		$out = $stdGrafix->imageMagickConvert('/home/mauri/public_html/t343/fileadmin/test.jpg', '', 100, 100);
		
		var_export($out);
	}
   
    private function resize($file, $dir, $w, $h) {
        $resize = false;

        // check if file exist
        $files = t3lib_div::getFilesInDir($dir .'sized/'.$w.'.'.$h.'/');
        if (!t3lib_div::inArray($files, $file)) {
        // file not exists need to be resized
            $resize = true;
        }

        // need to resize?
        if ($this->forceResize || $resize) {
            t3lib_div::devLog('resizing');
            $img = array();
            $img['file'] = $dir.  $file;
            $img['file.']['maxW'] = $w;
            $img['file.']['maxH'] = $h;

            $sizedFile = $this->cObj->IMG_RESOURCE($img);

            // make sized/ dir
            t3lib_div::mkdir_deep(PATH_site. $dir, 'sized');
            // make w.h/ dir
            t3lib_div::mkdir_deep(PATH_site. $dir.'sized/', $img['file.']['maxW'].'.'.$img['file.']['maxH'] );

            // move the file
            t3lib_div::upload_copy_move(PATH_site. $sizedFile, PATH_site. $dir .'sized/'.$w.'.'.$h.'/'. $file);
        }

    }

    public function getDir($album, $settings) {

        $albumRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_AlbumRepository');
        $dir = $album-> getFilepath();
        $this->cObj = t3lib_div::makeInstance('tslib_cObj');

          // force resizing
        if ($album->getResize()) {
            $this->forceResize = true;
            $album->setResize(0);
            $albumRepository->update($album);
        }
        
        
        $list = t3lib_div::getFilesInDir($dir , '', 0, '1');



        $res = array();
        //var_export( $list);
        if ($list) {
            foreach ($list as $item) {

                $originalUrl = $dir.$item;
                $size = $this->getSize($settings['maxSize']);
                $this->resize($item, $dir, $size['w'], $size['h']);
                $maximalUrl = $dir.'sized/'.$size['w'].'.'.$size['h'].'/'.$item;

                $size = $this->getSize($settings['normalSize']);
                $this->resize($item, $dir, $size['w'], $size['h']);
                $normalUrl = $dir.'sized/'.$size['w'].'.'.$size['h'].'/'.$item;

                $size = $this->getSize($settings['thumbSize']);
                $this->resize($item, $dir, $size['w'], $size['h']);
                $thumbUrl = $dir.'sized/'.$size['w'].'.'.$size['h'].'/'.$item;

                $foto = array('originalUrl' => $originalUrl,
                    'maximalUrl' => $maximalUrl,
                    'normalUrl' => $normalUrl,
                    'thumbUrl' => $thumbUrl);

                array_push($res, $foto);
            }
        }
        //var_export( $res);
        return $res;

    }

    private function getSize($size) {
        $w = 0;
        $h = 0;
        //echo $size;
        if ($size) {
            $sizes = explode("*", $size);
            $w = intval($sizes[0]);
            $h = intval($sizes[1]);
        }

        return array('w' => $w, 'h' => $h);
    }


}
?>
