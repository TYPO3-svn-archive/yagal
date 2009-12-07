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
 * A gallery
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Yagal_Domain_Model_Gallery extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The gallery's title.
	 *
	 * @var string
	 * @validate StringLength(minimum = 1, maximum = 80)
	 */
	protected $title = '';

	/**
	 * A short description of the gallery
	 *
	 * @var string
	 * @validate StringLength(maximum = 150)
	 */
	protected $description = '';
	
	/**
	 * The highlight
	 *
	 * @var string
	 */
	protected $highlight = '';
	
	/**
	 * The width
	 *
	 * @var int
	 */
	protected $width = 0;
	
	/**
	 * The height
	 *
	 * @var int
	 */
	protected $height = 0;
	
	/**
	 * The albums of this gallery
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yagal_Domain_Model_Album>
	 * @lazy
	 * @cascade remove
	 */
	protected $albums;

	/**
	 * The gallery's administrator
	 *
	 * @var Tx_Yagal_Domain_Model_Administrator
	 */
	protected $administrator;

	/**
	 * Constructs a new Gallery
	 *
	 */
	public function __construct() {
		$this->albums = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Sets this gallery's title
	 *
	 * @param string $title The gallery's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the gallery's title
	 *
	 * @return string The gallery's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the description for the gallery
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description for the gallery
	 *
	 * @param string $description
	 * @return void
	 */
	public function setHighlight($highlight) {
		$this->highlight = $highlight;
	}

	/**
	 * Returns the description
	 *
	 * @return string
	 */
	public function getHighlight() {
		return $this->highlight;
	}
	
	/**
	 * Adds a album to this gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Album $album
	 * @return void
	 */
	public function addAlbum(Tx_Yagal_Domain_Model_Album $album) {
		$this->albums->attach($album);
	}

	/**
	 * Remove a album from this gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Album $albumToRemove The album to be removed
	 * @return void
	 */
	public function removeAlbum(Tx_Yagal_Domain_Model_Album $albumToRemove) {
		$this->albums->detach($albumToRemove);
	}

	/**
	 * Remove all albums from this gallery
	 *
	 * @return void
	 */
	public function removeAllAlbums() {
		$this->albums = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns all albums in this gallery
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage
	 */
	public function getAlbums() {
		return $this->albums;
	}

	/**
	 * Sets the administrator value
	 *
	 * @param Tx_Yagal_Domain_Model_Administrator $administrator The Administrator of this Gallery
	 * @return void
	 */
	public function setAdministrator(Tx_Yagal_Domain_Model_Administrator $administrator) {
		$this->administrator = $administrator;
	}

	/**
	 * Returns the administrator value
	 *
	 * @return Tx_Yagal_Domain_Model_Administrator
	 */
	public function getAdministrator() {
		return $this->administrator;
	}

}
?>