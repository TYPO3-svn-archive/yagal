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
 * A gallery foto
 *
 * @package Gallery
 * @subpackage Domain
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Yagal_Domain_Model_Foto extends Tx_Extbase_DomainObject_AbstractEntity {


	/**
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 50)
	 */
	private $original;

	/**
	 * @var string
	 */
	private $thumbnail;

	/**
	 * @var string
	 */
	private $normal;

	/**
	 * @var string
	 */
	private $maximal;

	/**
	 * Sets the gallery this album is part of
	 *
	 * @param string $originalURL of the Foto
	 * @return void
	 */
	public function setOriginal($originalURL) {
		$this->original = $originalURL;
	}

	/**
	 * Returns the originalURL of the Foto
	 *
	 * @return string The originalURL of the Foto
	 */
	public function getOriginal() {
		return $this->original;
	}

	/**
	 * Sets the Thumbnail 
	 *
	 * @param string $thumbnailURL of the Foto
	 * @return void
	 */
	public function setThumbnail($thumbnailURL) {
		$this->thumbnail = $thumbnailURL;
	}

	/**
	 * Returns the thumbnailURL of the Foto
	 *
	 * @return string The thumbailURL of the Foto
	 */
	public function getThumbnail() {
		return $this->thumbnail;
	}

	/**
	 * Sets the Normal
	 *
	 * @param string $normalURL of the Foto
	 * @return void
	 */
	public function setNormal($normalURL) {
		$this->normal = $normalURL;
	}

	/**
	 * Returns the thumbnailURL of the Foto
	 *
	 * @return string The thumbailURL of the Foto
	 */
	public function getNormal() {
		return $this->normal;
	}


    /**
	 * Sets the Miximal
	 *
	 * @param string $normalURL of the Foto
	 * @return void
	 */
	public function setMaximal($maximalURL) {
		$this->maximal = $maximalURL;
	}

	/**
	 * Returns the thumbnailURL of the Foto
	 *
	 * @return string The thumbailURL of the Foto
	 */
	public function getMaximal() {
		return $this->maximal;
	}

}
?>