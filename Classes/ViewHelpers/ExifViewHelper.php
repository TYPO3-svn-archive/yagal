<?php
/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * View helper for rendering gravatar images.
 * See http://www.gravatar.com
 *
 * = Examples =
 *
 * <code>
 * <gallery:gravatar emailAddress="foo@bar.com" size="40" defaultImageUri="someDefaultImage" />
 * </code>
 *
 * <output>
 * <img src="http://www.gravatar.com/avatar/4a28b782cade3dbcd6e306fa4757849d?d=someDefaultImage&s=40" />
 * </output>
 *
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Yagal_ViewHelpers_ExifViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {


/**
 * Initialize arguments
 *
 * @return void
 */
    public function initializeArguments() {
        parent::initializeArguments();

    }

    /**
     * Render the gravatar image
     *
     * @param string $emailAddress Gravataer email address
     * @param integer $size Size of the gravatar image
     * @param string $defaultImageUri absolute URI of the image to be shown if no gravatar was found
     * @return string The rendered image tag
     */
    public function render($url) {
        $exif = $this->readEXIF($url);
        return var_export($exif, true);
    }

        // Function readEXIF() reads EXIF information of a given picture ($file could be 'fileadmin/pic.jpg')
        // thanks to wt_gallery
    function readEXIF($file) {
        if(file_exists($file) && function_exists('exif_read_data')) { // if file exists AND EXIF function exists
            $info = exif_read_data($file); // get exif of image
            //$info = exif_read_data($file, 'EXIF', 1, 0); // get exif of image

            // make EXIF array
            if ($info['Comments'] || $info['WINXP']['Comments']) $array['comment'] = ($info['Comments'] ? $info['Comments'] : $info['WINXP']['Comments']); // comments
            if ($info['Title'] || $info['WINXP']['Title']) $array[title] = ($info['Title'] ? $info['Title'] : $info['WINXP']['Title']); // title
            if ($info['Subject'] || $info['WINXP']['Subject']) $array['subject'] = ($info['Subject'] ? $info['Subject'] : $info['WINXP']['Subject']); // subject
            if ($info['Author'] || $info['WINXP']['Author']) $array['author'] = ($info['Author'] ? $info['Author'] : $info['WINXP']['Author']); // author
            if ($info['EXIF']['DateTimeOriginal']) $array['datetime'] = $info['EXIF']['DateTimeOriginal']; // recordtime original
            if ($info['IFD0']['Make']) $array['make'] = $info['IFD0']['Make']; // camera brand
            if ($info['IFD0']['Model']) $array['model'] = $info['IFD0']['Model']; // camera model

            if (!empty($array)) return $array;

        }
    }

}


?>