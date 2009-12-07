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
 * Comments controller for the Gallery package
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_Yagal_Controller_CommentController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * Action that adds a comment to a gallery album and redirects to single view
	 *
	 * @param Tx_Yagal_Domain_Model_Album $album The album the comment is related to
	 * @param Tx_Yagal_Domain_Model_Comment $newComment The comment to create
	 * @return void
	 */
	public function createAction(Tx_Yagal_Domain_Model_Album $album, Tx_Yagal_Domain_Model_Comment $newComment) {
		$album->addComment($newComment);
		$this->flashMessages->add('Your new comment was created.');
		$this->redirect('show', 'Album', NULL, array('album' => $album));
	}

	/**
	 * Deletes an existing comment
	 *
	 * @param Tx_Yagal_Domain_Model_Album $album The album the comment is related to
	 * @param Tx_Yagal_Domain_Model_Comment $comment The comment to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_Yagal_Domain_Model_Album $album, Tx_Yagal_Domain_Model_Comment $comment) {
		$album->removeComment($comment);
		$this->flashMessages->add('The comment was removed.');
		$this->redirect('edit', 'Album', NULL, array('album' => $album, 'gallery' => $album->getGallery()));
	}

	/**
	 * Deletes all comments of the given album
	 *
	 * @param Tx_Yagal_Domain_Model_Album $album The album the comment is related to
	 * @return void
	 */
	public function deleteAllAction(Tx_Yagal_Domain_Model_Album $album) {
		$album->removeAllComments();
		$this->flashMessages->add('Comments have been removed.');
		$this->redirect('edit', 'Album', NULL, array('album' => $album, 'gallery' => $album->getGallery()));
	}

	/**
	 * Override getErrorFlashMessage to present
	 * nice flash error messages.
	 *
	 * @return string
	 */
	protected function getErrorFlashMessage() {
		switch ($this->actionMethodName) {
			case 'createAction' :
				return 'Could not create the new comment:';
			case 'deleteAction' :
				return 'Could not delete comment:';
			case 'createAction' :
				return 'Could not delete comments:';
			default :
				return parent::getErrorFlashMessage();
		}
	}
		
}

?>
