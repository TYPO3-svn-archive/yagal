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
 * The albums controller for the Gallery package
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_Yagal_Controller_AlbumController extends Tx_Extbase_MVC_Controller_ActionController {

/**
 * @var Tx_Yagal_Business_GalleryBusiness
 */
    protected $galleryBusiness;


    /**
     * @var Tx_Yagal_Domain_Model_AlbumRepository
     */
    protected $albumRepository;
    private $forceResize = false;

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction() {
        $this->albumRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_AlbumRepository');
        $this->personRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_PersonRepository');
        $this->galleryBusiness = t3lib_div::makeInstance('Tx_Yagal_Business_GalleryBusiness');
    }

    /**
     * List action for this controller. Displays latest albums
     *
     * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery to show the albums of
     * @return string
     */
    public function indexAction(Tx_Yagal_Domain_Model_Gallery $gallery) {
        $this->view->assign('gallery', $gallery);
        $this->view->assign('recentAlbums', $this->albumRepository->findRecentByGallery($gallery, $this->settings['maxAlbums']));
    }

    public function listAction() {
        $albums = array();

        $this->view->assign('albums', $this->albumRepository->findAlbums($this->settings['gallery'], $this->settings['tags']) );
    }

    /**
     * Action that displays one single album
     *
     * @param Tx_Yagal_Domain_Model_Album $album The album to display
     * @return string The rendered view
     */
    public function showAction(Tx_Yagal_Domain_Model_Album $album) {


        $fotos = $this->galleryBusiness->getDir($album, $this->settings);

        $this->view->assign('settings', $this->settings);
        $this->view->assign('album', $album);
        $this->view->assign('fotos', $fotos);
    }



}

?>