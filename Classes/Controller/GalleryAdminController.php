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
class Tx_Yagal_Controller_GalleryAdminController extends Tx_Extbase_MVC_Controller_ActionController {

	
	/**
	 * @var Tx_Yagal_Business_GalleryBusiness
	 */
	protected $galleryBusiness;
	
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
		$this->galleryRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_GalleryRepository');
		$this->administratorRepository = t3lib_div::makeInstance('Tx_Yagal_Domain_Repository_AdministratorRepository');
		$this->galleryBusiness = t3lib_div::makeInstance('Tx_Yagal_Business_GalleryBusiness');
		
	}

	/**
	 * Index action for this controller. Displays a list of gallerys.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$galleries = $this->galleryRepository->findAll();
		$this->view->assign('galleries', $galleries );
	}
	
	
	/**
	 * Displays a form for creating a new gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $newGallery A fresh gallery object taken as a basis for the rendering
	 * @return string An HTML form for creating a new gallery
	 * @dontvalidate $newGallery
	 */
	public function newAction(Tx_Yagal_Domain_Model_Gallery $newGallery = NULL) {
		$this->view->assign('newGallery', $newGallery);
		$this->view->assign('administrators', $this->administratorRepository->findAll());
	}

	/**
	 * Creates a new gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $newGallery A fresh Gallery object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(Tx_Yagal_Domain_Model_Gallery $newGallery) {
		$this->galleryRepository->add($newGallery);
		$this->flashMessages->add('Your new gallery was created.');
		$this->redirect('index');
	}

	/**
	 * Edits an existing gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery to be edited. This might also be a clone of the original gallery already containing modifications if the edit form has been submitted, contained errors and therefore ended up in this action again.
	 * @return string Form for editing the existing gallery
	 * @dontvalidate $gallery
	 */
	public function editAction(Tx_Yagal_Domain_Model_Gallery $gallery) {
		$this->view->assign('gallery', $gallery);
		$this->view->assign('administrators', $this->administratorRepository->findAll());
	}

	/**
	 * Updates an existing gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery A not yet persisted clone of the original gallery containing the modifications
	 * @return void
	 */
	public function updateAction(Tx_Yagal_Domain_Model_Gallery $gallery) {
		$this->galleryRepository->update($gallery);
		$this->flashMessages->add('Your gallery has been updated.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery to delete
	 * @return void
	 */
	public function deleteAction(Tx_Yagal_Domain_Model_Gallery $gallery) {
		$this->galleryRepository->remove($gallery);
		$this->flashMessages->add('Your gallery has been removed.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing gallery
	 *
	 * @return void
	 */
	public function deleteAllAction() {
		$galleries = $this->galleryRepository->findAll();
		foreach ($galleries as $gallery) {
			$this->galleryRepository->remove($gallery);
		}
		$this->redirect('index');
	}

	
	public function addGallery ($config) {
		$optionList = array();
		// add first option
		$optionList[0] = array(0 => 'option1', 1 => 'value1');
		// add second option
		$optionList[1] = array(0 => 'option2', 1 => 'value2');
		$config['items'] = array_merge($config['items'],$optionList);
		return $config;
	}

	/**
	 * Override getErrorFlashMessage to present
	 * nice flash error messages.
	 *
	 * @return string
	 */
	protected function getErrorFlashMessage() {
		switch ($this->actionMethodName) {
			case 'updateAction' :
				return 'Could not update the gallery:';
			case 'createAction' :
				return 'Could not create the new gallery:';
			default :
				return parent::getErrorFlashMessage();
		}
	}

}

?>
