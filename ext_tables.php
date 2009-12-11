<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

/**
 * Registers a Plugin to be listed in the Backend. You also have to configure the Dispatcher in ext_localconf.php.
 */
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'Pi1',				// A unique name of the plugin in UpperCamelCase
	'A Yet another Gallery'	// A title shown in the backend dropdown field
);

if (TYPO3_MODE === 'BE')	{
	/**
	* Registers a Backend Module
	*/
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',					// Make module a submodule of 'web'
		'tx_yagal_m1',	// Submodule key
		'',						// Position
		array(																			// An array holding the controller-action-combinations that are accessible
			'GalleryAdmin' => 'index,show,new,create,delete,deleteAll,edit,update,populate',	// The first controller and its first action will be the default
			'AlbumAdmin' => 'index,list,show,new,create,delete,deletefile,edit,update',
			),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:yagal/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
		)
	);

	/**
	 * Add labels for context sensitive help (CSH)
	 */
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_YagalTxYagalM1', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh.xml');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Yet another Gallery');



t3lib_extMgm::allowTableOnStandardPages('tx_yagal_domain_model_gallery');
$TCA['tx_yagal_domain_model_gallery'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_gallery',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yagal_domain_model_gallery.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_yagal_domain_model_album');
$TCA['tx_yagal_domain_model_album'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album',
		'label'				=> 'title',
		'label_alt'			=> 'gallery',
		'label_alt_force'	=> TRUE,
		'tstamp'            => 'tstamp',
		'crdate'            => 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'prependAtCopy' 	=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields' 		=> 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		'delete'            => 'deleted',
		'enablecolumns'     => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yagal_domain_model_album.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_yagal_domain_model_person');
$TCA['tx_yagal_domain_model_person'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_person',
		'label' 			=> 'lastname',
		'label_alt'			=> 'firstname',
		'label_alt_force'	=> TRUE,
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'prependAtCopy' 	=> 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yagal_domain_model_person.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_yagal_domain_model_tag');
$TCA['tx_yagal_domain_model_tag'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_tag',
		'label'				=> 'name',
		'tstamp'            => 'tstamp',
		'crdate'            => 'crdate',
		'delete'            => 'deleted',
		'enablecolumns'     => array (
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yagal_domain_model_tag.gif'
	)
);

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

?>
