<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 *
 * Description of GalleryBusiness
 *
 * @author mauri
 */
class Tx_Yagal_Business_GalleryBusiness {


    public function resizeHighlight($highLightFoto, $settings) {


        $pieces = explode('/', $highLightFoto);
        $item = array_pop($pieces);
        $dir = implode('/', $pieces) . '/';

        echo 'dir:'.$dir.'<br>';
        echo '$item:'.$item.'<br>';


        $size['w'] = $settings['piHighlightSizeW'] ? $settings['piHighlightSizeW'] : $settings['highlightSizeW'];
        $size['h'] = $settings['piHighlightSizeH'] ? $settings['piHighlightSizeH'] : $settings['highlightSizeH'];
        $this->resize($item, $dir, $size['w'], $size['h']);
        $resizedUrl = $dir.'sized/'.$size['w'].'.'.$size['h'].'/'.$item;
    }

    private function resize($file, $dir, $w, $h) {

        if(true) {
           echo "$file, $dir, $w, $h<br>";
        }

        $this->cObj = t3lib_div::makeInstance('tslib_cObj');
        $resize = false;

        // check if file exist
        $files = t3lib_div::getFilesInDir($dir .'sized/'.$w.'.'.$h.'/');
        if (!t3lib_div::inArray($files, $file)) {
            // file not exists need to be resized
            $resize = true;
        }

        // need to resize?
        if ($this->forceResize || $resize) {
            echo('resizing<br>');
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

        //$this->forceResize = true;
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

                $size['w'] = $settings['piMaxSizeW'] ? $settings['piMaxSizeW'] : $settings['maxSizeW'];
                $size['h'] = $settings['piMaxSizeH'] ? $settings['piMaxSizeH'] : $settings['maxSizeH'];
                $this->resize($item, $dir, $size['w'], $size['h']);
                $maximalUrl = $dir.'sized/'.$size['w'].'.'.$size['h'].'/'.$item;

                $size['w'] = $settings['piNormalSizeW'] ? $settings['piNormalSizeW'] : $settings['normalSizeW'];
                $size['h'] = $settings['piNormalSizeH'] ? $settings['piNormalSizeH'] : $settings['normalSizeH'];
                $this->resize($item, $dir, $size['w'], $size['h']);
                $maximalUrl = $dir.'sized/'.$size['w'].'.'.$size['h'].'/'.$item;


                $size['w'] = $settings['piThumbSizeW'] ? $settings['piThumbSizeW'] : $settings['thumbSizeW'];
                $size['h'] = $settings['piThumbSizeH'] ? $settings['piThumbSizeH'] : $settings['thumbSizeH'];
                $this->resize($item, $dir, $settings['thumbSizeW'], $settings['thumbSizeH']);
                $thumbUrl = $dir.'sized/'.$settings['thumbSizeW'].'.'.$settings['thumbSizeH'].'/'.$item;

//                $foto = array('originalUrl' => $originalUrl,
//                        'maximalUrl' => $maximalUrl,
//                        'normalUrl' => $normalUrl,
//                        'thumbUrl' => $thumbUrl);

                $foto = t3lib_div::makeInstance('Tx_Yagal_Domain_Model_Foto');
                $foto->setOriginal($originalUrl);
                $foto->setNormal($normalUrl);
                $foto->setMaximal($maximalUrl);
                $foto->setThumbnail($thumbUrl);


                array_push($res, $foto);
            }
        }
        //var_export( $res);
        return $res;

    }







}
?>
