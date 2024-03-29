<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3.
*  All credits go to the v5 team.
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
 * A Galleryvalidator
 *
 * @version $Id: GalleryValidator.php 2863 2009-07-22 15:03:14Z robert $
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */
class Tx_Yagal_Domain_Validator_GalleryValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * If the given gallery is valid
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery
	 * @return boolean true
	 */
     public function isValid($gallery) {
		if ($gallery->getTitle() === 'Extbase') {
			$this->addError(Tx_Extbase_Utility_Localization::translate('error.gallery_name_extbase', 'GalleryExample'), 2);
			return FALSE;
		}
		return TRUE;
	}

}
?>