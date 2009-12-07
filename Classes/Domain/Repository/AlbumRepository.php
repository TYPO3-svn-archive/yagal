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
 * A repository for Albums
 */
class Tx_Yagal_Domain_Repository_AlbumRepository extends Tx_Extbase_Persistence_Repository {

	public function remove($album) {
		$album->removeAllTags();
		parent::remove($album);
	}

	/**
	 * Finds all albums by the specified gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery the album must refer to
	 * @return array The albums
	 */
	public function findAllByGallery(Tx_Yagal_Domain_Model_Gallery $gallery) {
		$query = $this->createQuery();
		return $query->matching($query->equals('gallery', $gallery))
			->setOrderings(array('date' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->execute();
	}

	/**
	 * Finds albums by the specified gallery with limit
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery the album must refer to
	 * @param integer $limit The number of albums to return at max
	 * @return array The albums
	 */
	public function findByGallery(Tx_Yagal_Domain_Model_Gallery $gallery, $limit = 20) {
		$query = $this->createQuery();
		return $query->matching($query->equals('gallery', $gallery))
			->setOrderings(array('date' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->setLimit((integer)$limit)
			->execute();
	}

	/**
	 * Finds the previous of the given album
	 *
	 * @param Tx_Yagal_Domain_Model_Album $album The reference album
	 * @return Tx_Yagal_Domain_Model_Album
	 */
	public function findPrevious(Tx_Yagal_Domain_Model_Album $album) {
		$query = $this->createQuery();
		$albums = $query->matching($query->lessThan('date', $album->getDate()))
			->setOrderings(array('date' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->setLimit(1)
			->execute();
		return (count($albums) == 0) ? NULL : current($albums);
	}

	/**
	 * Finds the album next to the given album
	 *
	 * @param Tx_Yagal_Domain_Model_Album $album The reference album
	 * @return Tx_Yagal_Domain_Model_Album
	 */
	public function findNext(Tx_Yagal_Domain_Model_Album $album) {
		$query = $this->createQuery();
		$albums = $query->matching($query->greaterThan('date', $album->getDate()))
			->setOrderings(array('date' =>  Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->setLimit(1)
			->execute();
		return (count($albums) == 0) ? NULL : current($albums);
	}

	/**
	 * Finds most recent albums by the specified gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery the album must refer to
	 * @param integer $limit The number of albums to return at max
	 * @return array The albums
	 */
	public function findRecentByGallery(Tx_Yagal_Domain_Model_Gallery $gallery, $limit = 5) {
		$query = $this->createQuery();
		return $query->matching($query->equals('gallery', $gallery))
			->setOrderings(array('date' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->setLimit((integer)$limit)
			->execute();
	}

	/**
	 * Finds most recent albums by the specified gallery
	 *
	 * @param Tx_Yagal_Domain_Model_Gallery $gallery The gallery the album must refer to
	 * @param integer $limit The number of albums to return at max
	 * @return array The albums
	 */
	public function findAlbums($gallery, $tags, $limit = 5) {
		$query = $this->createQuery();
		$where = '1=1';
		$from = '';

		if ($tags) {
			if ($where != '') $where .= ' AND ';

			$tags = split(',', $tags);
			$tagWhere = '';
			foreach ($tags as $tag) {
				if ($tagWhere != '') $tagWhere .= ' OR ';
				$tagWhere .= 'tx_yagal_domain_model_tag.uid = '.$tag;
			}
			$from = 'inner join
				tx_yagal_album_tag_mm on tx_yagal_album_tag_mm.uid_local = tx_yagal_domain_model_album.uid inner join
				tx_yagal_domain_model_tag on tx_yagal_album_tag_mm.uid_foreign = tx_yagal_domain_model_tag.uid';
			$where .= '('.$tagWhere.')';

		}

		if ($gallery) {
			if ($where != '') $where .= ' AND ';
			$where .= 'tx_yagal_domain_model_album.gallery = '.$gallery;
		}

		$query->setOrderings(array('date' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING));
		$query->setLimit((integer)$limit);
		$statement = 'select distinct
				tx_yagal_domain_model_album.*
			from
				tx_yagal_domain_model_album '. $from . '
			where '.$where.'
			order by tx_yagal_domain_model_album.date';
		//echo $statement;
		$query->statement($statement);

		return $query->execute();
	}


}
?>