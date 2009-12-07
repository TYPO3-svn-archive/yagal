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
 * A gallery album
 *
 * @package Gallery
 * @subpackage Domain
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Yagal_Domain_Model_Album extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var Tx_Yagal_Domain_Model_Gallery
	 * @lazy
	 */
	protected $gallery;

	/**
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 50)
	 */
	protected $title;

	/**
	 * @var DateTime
	 */
	protected $date;

	/**
	 * @var Tx_Yagal_Domain_Model_Person
	 */
	protected $photographer;

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * @var string
	 */
	protected $filepath;

	/**
	 * @var string
	 */
	protected $highlight;

	/**
	 * @var int
	 */
	protected $resize;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yagal_Domain_Model_Tag>
	 */
	protected $tags;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yagal_Domain_Model_Comment>
	 * @lazy
	 * @cascade remove
	 */
	protected $comments;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yagal_Domain_Model_Album>
	 */
	protected $relatedAlbums;

	/**
	 * Constructs this album
	 */
	public function __construct() {
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
		$this->comments = new Tx_Extbase_Persistence_ObjectStorage();
		$this->relatedAlbums = new Tx_Extbase_Persistence_ObjectStorage();
		$this->date = new DateTime();
	}

	/**
	 * Sets the gallery this album is part of
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery
	 * @return void
	 */
	public function setGallery(Tx_Yagal_Domain_Model_Gallery $gallery) {
		$this->gallery = $gallery;
	}

	/**
	 * Returns the gallery this album is part of
	 *
	 * @return Tx_Yagal_Domain_Model_Gallery The gallery this album is part of
	 */
	public function getGallery() {
		if ($this->gallery instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->gallery->_loadRealInstance();
		}
		return $this->gallery;
	}

	/**
	 * Setter for title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Setter for date
	 *
	 * @param DateTime $date
	 * @return void
	 */
	public function setDate(DateTime $date) {
		$this->date = $date;
	}

	/**
	 * Getter for date
	 *
	 *
	 * @return DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Setter for tags
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage $tags One or more Tx_Yagal_Domain_Model_Tag objects
	 * @return void
	 */
	public function setTags(Tx_Extbase_Persistence_ObjectStorage $tags) {
		$this->tags = clone $tags;
	}

	/**
	 * Adds a tag to this album
	 *
	 * @param Tx_Yagal_Domain_Model_Tag $tag
	 * @return void
	 */
	public function addTag(Tx_Yagal_Domain_Model_Tag $tag) {
		$this->tags->attach($tag);
	}

	/**
	 * Removes a tag from this album
	 *
	 * @param Tx_Yagal_Domain_Model_Tag $tag
	 * @return void
	 */
	public function removeTag(Tx_Yagal_Domain_Model_Tag $tag) {
		$this->tags->detach($tag);
	}

	/**
	 * Remove all tags from this album
	 *
	 * @return void
	 */
	public function removeAllTags() {
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Getter for tags
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage A storage holding Tx_Yagal_Domain_Model_Tag objects
	 */
	public function getTags() {
		return clone $this->tags;
	}

	/**
	 * Sets the photographer for this album
	 *
	 * @param Tx_Yagal_Domain_Model_Person $photographer
	 * @return void
	 */
	public function setPhotographer(Tx_Yagal_Domain_Model_Person $photographer) {
		$this->photographer = $photographer;
	}

	/**
	 * Getter for photographer
	 *
	 * @return Tx_Yagal_Domain_Model_Person
	 */
	public function getPhotographer() {
		return $this->photographer;
	}

	/**
	 * Sets the content for this album
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Getter for content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}


	/**
	 * Sets the filepath for this album
	 *
	 * @param string $filepatht
	 * @return void
	 */
	public function setFilepath($filepath) {
		$this->filepath = $filepath;
	}

	/**
	 * Getter for filepath
	 *
	 * @return string
	 */
	public function getFilepath() {
		return $this->filepath;
	}

	/**
	 * Getter for highlight
	 *
	 * @return string
	 */
	public function getHighlight() {
		return $this->highlight;
	}

	/**
	 * Sets the highlight for this album
	 *
	 * @param string $highlight
	 * @return void
	 */
	public function setHighlight($highlight) {
		$this->highlight = $highlight;
	}

	/**
	 * Getter for resize
	 *
	 * @return int
	 */
	public function getResize() {
		return $this->resize;
	}

	/**
	 * Sets the resize for this album
	 *
	 * @param string $resize
	 * @return void
	 */
	public function setResize($resize) {
		$this->resize = $resize;
	}
	
	/**
	 * Setter for the comments to this album
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage $comments An Object Storage of related Comment instances
	 * @return void
	 */
	public function setComments(Tx_Extbase_Persistence_ObjectStorage $comments) {
		$this->comments = $comments;
	}

	/**
	 * Adds a comment to this album
	 *
	 * @param Tx_Yagal_Domain_Model_Comment $comment
	 * @return void
	 */
	public function addComment(Tx_Yagal_Domain_Model_Comment $comment) {
		$this->comments->attach($comment);
	}

	/**
	 * Removes Comment from this album
	 *
	 * @param Tx_Yagal_Domain_Model_Comment $commentToDelete
	 * @return void
	 */
	public function removeComment(Tx_Yagal_Domain_Model_Comment $commentToDelete) {
		$this->comments->detach($commentToDelete);
	}

	/**
	 * Remove all comments from this album
	 *
	 * @return void
	 */
	public function removeAllComments() {
		$this->comments = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the comments to this album
	 *
	 * @return An Tx_Extbase_Persistence_ObjectStorage holding instances of Tx_Yagal_Domain_Model_Comment
	 */
	public function getComments() {
		return clone $this->comments;
	}

	/**
	 * Setter for the related albums
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage $relatedAlbums An Object Storage containing related Albums instances
	 * @return void
	 */
	public function setRelatedAlbums(Tx_Extbase_Persistence_ObjectStorage $relatedAlbums) {
		$this->relatedAlbums = $relatedAlbums;
	}

	/**
	 * Adds a related album
	 *
	 * @param Tx_Yagal_Domain_Model_Album $comment
	 * @return void
	 */
	public function addRelatedAlbum(Tx_Yagal_Domain_Model_Album $album) {
		$this->relatedAlbums->attach($album);
	}

	/**
	 * Remove all related albums
	 *
	 * @return void
	 */
	public function removeAllRelatedAlbums() {
		$this->relatedAlbums = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the related albums
	 *
	 * @return An Tx_Extbase_Persistence_ObjectStorage holding instances of Tx_Yagal_Domain_Model_Album
	 */
	public function getRelatedAlbums() {
		return clone $this->relatedAlbums;
	}

	/**
	 * Returns this album as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->title . chr(10) .
			' written on ' . $this->date->format('Y-m-d') . chr(10) .
			' by ' . $this->photographer->getFullName() . chr(10) .
		wordwrap($this->content, 70, chr(10)) . chr(10) .
		implode(', ', $this->tags->toArray());
	}
}
?>