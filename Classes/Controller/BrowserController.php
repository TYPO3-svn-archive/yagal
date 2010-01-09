<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The gallery controller for the Gallery package
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_Yagal_Controller_BrowserController extends Tx_Yagal_Controller_GalleryAbstractController {

    /**
     * @var Tx_Yagal_Domain_Model_AlbumRepository
     */
    protected $albumRepository;

    /**
     * @var Tx_Yagal_Domain_Model_GalleryRepository
     */
    protected $galleryRepository;

    /**
     * @var Tx_Yagal_Domain_Model_AdministratorRepository
     */
    protected $administratorRepository;

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction() {
        $this->init();
        $this->galleryRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_GalleryRepository');
        $this->albumRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_AlbumRepository');
        $this->administratorRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_AdministratorRepository');
    }

    

    public function browserAction () {
        var_export($this->request->getArguments());

        $currentAlbumUid = 0;
        $currentGalleryUid = 0;
        
        if ($this->request->getArguments()) {
            $arg = $this->request->getArguments();
            if ($arg['album']) {
                $currentAlbumUid =   intval($arg['album'] );
                $aa =   $this->albumRepository->findByUid( intval($arg['album'] )) ;
                    $currentGalleryUid = $aa->getGallery()->getUid();
            }
            if ($arg['gallery']) {
                $currentGalleryUid =   intval($arg['gallery'] ) ;
            }
        }
        

        $galleries = $this->galleryRepository->findAll();
        $album = $this->albumRepository->findAll();

        $this->view->assign('galleries', $galleries );
        $this->view->assign('albums', $album );
        $this->view->assign('currentAlbumUid', $currentAlbumUid );
        $this->view->assign('currentGalleryUid', $currentGalleryUid );
    }

   
    public function detailAction () {
       


        if ($this->request->getArguments()) {
            $arg = $this->request->getArguments();
            if ($arg['album']) {
                $album =  $this->albumRepository->findByUid( intval($arg['album'] )  );
            }
            if ($arg['gallery']) {
                $gallery =  $this->galleryRepository->findByUid( intval($arg['gallery'] )  );
            }
        }

        //$album = $this->arguments->getArgument('album');
        //$gallery = $this->arguments->getArgument('gallery');
        if ($album) {
            $this->view->assign('album', $album );
            $this->view->assign('gallery', $album->getGallery() );
        }
        if ($gallery) {
            $this->view->assign('gallery', $gallery );
        }
    }


}

?>
