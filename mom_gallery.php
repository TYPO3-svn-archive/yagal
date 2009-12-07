<?php
class ControllerShow {
	var $baseDir;
	var $sizedDir = '.sized/';
	var $galleryDir;

	var $view;
	var $pi;
	var $thumbsDir = 'thumbs/';
	var $fullsizeDir = 'fullsize/';

	function ControllerShow($pi) {
		$this->pi = $pi;
		$this->view = new ViewShow($this->pi);
	}

	function getDir($dir) {
		$res = '';
		$list = t3lib_div::get_dirs($dir);
		//echo $list;
		if ($list) {
			foreach ($list as $item) {
				if ($item == '.sized') continue;
				if ($item == 'thumb') continue;
				if ($item == 'thumbs') continue;
				$res .= $dir . $item . '/,';
				$res .= $this->getDir($dir . $item . '/');
			}
		}

		return $res;

	}

	function process($baseDir, $galleryDir) {
		$this->baseDir = $baseDir;
		$this->galleryDir = $galleryDir;
		$this->cObj = new tslib_cObj();

		
		//echo $this->baseDir . $this->galleryDir;

		//$orgFileList = explode(',',$this->cObj->filelist($this->baseDir . $this->galleryDir));
		$orgFileList = t3lib_div::getFilesInDir($this->baseDir . $this->galleryDir , '', 0, '1');

		//$dirList = array();
		//$dirList = explode(',',$this->getDir($this->baseDir, $dirList));

		if (false) $content .= '<pre>'. var_export($orgFileList, true).'</pre>';

		$this->checkResized($orgFileList);
		//$sizedFileList = explode(',',$this->cObj->filelist($this->baseDir . $this->sizedDir . $this->galleryDir. '/thumbs'));
		//$sizedFileList = t3lib_div::getFilesInDir($this->baseDir . $this->sizedDir . $this->galleryDir. '/thumbs', '', 0, '1');
		//		sort($sizedFileList, SORT_NUMERIC);
		//$content = var_export($sizedFileList, true);
		if (false) $content .= '<pre>'. var_export($orgFileList, true).'</pre>';
		$content .= '<div id="myGallery">';
			
		$content .= '';
		foreach ($orgFileList as $file) {
			$img = array();
			// Pfad zur Datei
			$img['file'] = $this->baseDir . $this->galleryDir . $this->sizedDir . $this->thumbsDir . $file;
			$thumbImage = $this->cObj->IMG_RESOURCE($img);
			$img = array();
			$img['file'] = $this->baseDir .  $this->galleryDir . $this->sizedDir .  $this->fullsizeDir . $file;
			$fullImage = $this->cObj->IMG_RESOURCE($img);


			//$content .= '<li value="'.$counter++.'">'.$imageTag.'</li>';
			$content .= '<div class="imageElement">
					<h3></h3>
					<p></p>
					<a title="open image" href="'.$this->baseDir . $this->galleryDir . $file.'" class="open"></a>
					<img src="'.$fullImage.'" class="full" />
					<img src="'.$thumbImage.'" class="thumbnail" />
				</div>';

		}
		$content .= '</div>';
		$content .= '<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($("myGallery"), {
					timed: true,
					showInfopane: false,
					delay: '.$this->pi->flex['delay'].',
					embedLinks: true,
					showPlay: true
				});

				aGallery = myGallery;
			}
			window.addEvent("domready",startGallery);
		</script>';

		return $content; // = $this->view->render();
	}

	function toBeRized($orgFileList) {
		$sizedFileList = explode(',',$this->cObj->filelist($this->baseDir . $this->galleryDir.  $this->sizedDir .$this->fullsizeDir));
		$thumbFileList = explode(',',$this->cObj->filelist($this->baseDir . $this->galleryDir. $this->sizedDir .$this->thumbsDir));

		$sizedFileList = t3lib_div::getFilesInDir($this->baseDir.$this->galleryDir.$this->sizedDir.$this->fullsizeDir , '', 0, '1');
		$thumbFileList = t3lib_div::getFilesInDir($this->baseDir.$this->galleryDir.$this->sizedDir.$this->thumbsDir , '', 0, '1');
//		echo count($orgFileList);
//		echo count($sizedFileList);

		if (count($orgFileList) != count($sizedFileList)) return true;
		if (count($orgFileList) != count($thumbFileList)) return true;
		if (count($sizedFileList) == 0) return true;
		if (count($thumbFileList) == 0) return true;
//		echo 'toBeRized:false';
		return false;
	}

	function resize($file,$w,$h, $dir) {
		$img = array();
		// Pfad zur Datei
		$img['file'] = $this->baseDir . $this->galleryDir . $file;

		// Auslesen der maximalen Bildbreite, z.B. 600 (Pixel)
		$img['file.']['maxW'] = $w;
		$img['file.']['maxH'] = $h;

		//echo 'thumb:'.$file;
		// Erstellen des skalierten Bildes, hier Zuweisung zu einem Template Marker
		$sizedFile = $this->cObj->IMG_RESOURCE($img);

		//echo PATH_site. $sizedFile.', ', PATH_site. $this->baseDir . $this->sizedDir . $this->galleryDir .'/fullsize/'.$file;
		//echo 'newThumb:'.$sizedFile;
		t3lib_div::upload_copy_move(PATH_site. $sizedFile, PATH_site. $this->baseDir . $this->galleryDir . $this->sizedDir . $dir . $file);

	}

	function mustResizeImage($file, $dir) {
		return !t3lib_div::inArray( t3lib_div::getFilesInDir($this->baseDir.$this->galleryDir.$this->sizedDir.$dir , '', 0, '1'), $file);
	}
	
	function checkResized($orgFileList) {

		if ($this->toBeRized($orgFileList)) {
			// create directory

			$this->createSizedDirectory($this->galleryDir);

			foreach ($orgFileList as $file) {
				if ($this->mustResizeImage($file, $this->fullsizeDir)) {
					$this->resize($file, $this->pi->flex['maxW'], $this->pi->flex['maxH'], $this->fullsizeDir);
				}
				if ($this->mustResizeImage($this->fullsizeDir.$file, $this->thumbsDir)) {
					$this->resize($file, 100, 75, $this->thumbsDir);
				}
			}


		}
	}

	function createSizedDirectory ($dir) {
		$this->createDirectory($dir .  $this->sizedDir . $this->thumbsDir);
		$this->createDirectory($dir .  $this->sizedDir. $this->fullsizeDir);
			
	}

	function createDirectory ($dir) {
		t3lib_div::mkdir_deep(PATH_site. $this->baseDir, $dir);
	}

}
?>
