<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_yagal_domain_model_gallery'] = array(
	'ctrl' => $TCA['tx_yagal_domain_model_gallery']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'uid, hidden, title, description, highlight, albums, administrator'
	),
	'columns' => array(
		'sys_language_uid' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tt_news',
				'foreign_table_where' => 'AND tt_news.uid=###REC_FIELD_l18n_parent### AND tt_news.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => Array (
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => Array (
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_gallery.title',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'description' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_gallery.description',
			'config'  => array(
				'type' => 'text',
				'eval' => 'required',
				'rows' => 30,
				'cols' => 80,
			),
			'defaultExtras' => 'richtext[*]'

		),
		'highlight' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_gallery.highlight',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'show_thumbs'   => 1,
				'size'          => 1,
				'maxitems'      => 1,
				'minitems'      => 0
			)
		),
		'albums' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_gallery.albums',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_yagal_domain_model_album',
				'foreign_field' => 'gallery',
				'foreign_sortby' => 'sorting',
				'maxitems'      => 999999,
				'appearance' => array(
					'newRecordLinkPosition' => 'bottom',
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'administrator' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_gallery.administrator',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'maxitems' => 1,
				'wizards' => Array(
		             '_PADDING' => 1,
		             '_VERTICAL' => 1,
		             'edit' => Array(
		                 'type' => 'popup',
		                 'title' => 'Edit',
		                 'script' => 'wizard_edit.php',
		                 'icon' => 'edit2.gif',
		                 'popup_onlyOpenIfSelected' => 1,
		                 'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
		             ),
		             'add' => Array(
		                 'type' => 'script',
		                 'title' => 'Create new',
		                 'icon' => 'add.gif',
		                 'params' => Array(
		                     'table'=>'fe_users',
		                     'pid' => '###CURRENT_PID###',
		                     'setValue' => 'prepend'
		                 ),
		                 'script' => 'wizard_add.php',
		             ),
		         )
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, title, description, highlight, albums, administrator')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_yagal_domain_model_album'] = array(
	'ctrl' => $TCA['tx_yagal_domain_model_album']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, title, date, photographer, filepath, highlight, resize, content, tags, comments, related_albums'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'gallery' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.gallery',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_yagal_domain_model_gallery',
				'maxitems' => 1,
			)
		),
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.title',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'date' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.date',
			'config'  => array(
				'type'    => 'input',
				'size' => 12,
				'checkbox' => 1,
				'eval' => 'datetime, required',
				'default' => time()
			)
		),
		'photographer' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.photographer',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_yagal_domain_model_person',
				'maxitems' => 1,
				'wizards' => Array(
		             '_PADDING' => 1,
		             '_VERTICAL' => 1,
		             'edit' => Array(
		                 'type' => 'popup',
		                 'title' => 'Edit',
		                 'script' => 'wizard_edit.php',
		                 'icon' => 'edit2.gif',
		                 'popup_onlyOpenIfSelected' => 1,
		                 'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
		             ),
		             'add' => Array(
		                 'type' => 'script',
		                 'title' => 'Create new',
		                 'icon' => 'add.gif',
		                 'params' => Array(
		                     'table'=>'tx_yagal_domain_model_person',
		                     'pid' => '###CURRENT_PID###',
		                     'setValue' => 'prepend'
		                 ),
		                 'script' => 'wizard_add.php',
		             ),
		         )
			)
		),
		'filepath' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.filepath',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'folder',
				'max_size'      => 3000,
				'size'          => 1,
				'maxitems'      => 1,
				'minitems'      => 0
			)
		),
		'highlight' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.highlight',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'show_thumbs'   => 1,
				'size'          => 1,
				'maxitems'      => 1,
				'minitems'      => 0
			)
		),
		'resize' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.resize',
			'config'  => array(
				'type'          => 'check',
			)
		),

		'content' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.content',
			'config'  => array(
				'type' => 'text',
				'rows' => 30,
				'cols' => 80
			),
			 'defaultExtras' => 'richtext[*]'
		),
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.tags',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 0,
				'foreign_table' => 'tx_yagal_domain_model_tag',
				'MM' => 'tx_yagal_album_tag_mm',
				'wizards' => Array(
		             '_PADDING' => 1,
		             '_VERTICAL' => 1,
		             'edit' => Array(
		                 'type' => 'popup',
		                 'title' => 'Edit',
		                 'script' => 'wizard_edit.php',
		                 'icon' => 'edit2.gif',
		                 'popup_onlyOpenIfSelected' => 1,
		                 'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
		             ),
		             'add' => Array(
		                 'type' => 'script',
		                 'title' => 'Create new',
		                 'icon' => 'add.gif',
		                 'params' => Array(
		                     'table'=>'tx_yagal_domain_model_tag',
		                     'pid' => '###CURRENT_PID###',
		                     'setValue' => 'prepend'
		                 ),
		                 'script' => 'wizard_add.php',
		             ),
		         )
			)
		),
		'comments' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.comments',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_yagal_domain_model_comment',
				'foreign_field' => 'album',
				'appearance' => array(
					'newRecordLinkPosition' => 'bottom',
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			)
		),
		'related_albums' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_album.related',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 0,
				'foreign_table' => 'tx_yagal_domain_model_album',
				'foreign_table_where' => 'AND ###THIS_UID### != tx_yagal_domain_model_album.uid',
				'MM' => 'tx_yagal_album_album_mm',
				'MM_opposite_field' => 'related_albums',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, gallery, title, date, photographer, filepath, highlight, resize, content, tags, comments, related_albums')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_yagal_domain_model_comment'] = array(
	'ctrl' => $TCA['tx_yagal_domain_model_comment']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, date, author, email, content'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'date' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_comment.date',
			'config'  => array(
				'type'    => 'input',
				'size' => 12,
				'checkbox' => 1,
				'eval' => 'datetime, required',
				'default' => time()
			)
		),
		'author' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_comment.author',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'email' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_comment.email',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'content' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_comment.content',
			'config'  => array(
				'type' => 'text',
				'rows' => 30,
				'cols' => 80
			)
		),
		'filepath' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_comment.filepath',
			'config'  => array(
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'album' => array(
			'config' => array(
				'type' => 'passthrough',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, date, author, email, content')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_yagal_domain_model_person'] = array(
	'ctrl' => $TCA['tx_yagal_domain_model_person']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'firstname, lastname, email, avatar'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'firstname' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_person.firstname',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'lastname' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_person.lastname',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'email' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_person.email',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		)
	),
	'types' => array(
		'1' => array('showitem' => 'firstname, lastname, email, avatar')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_yagal_domain_model_tag'] = array(
	'ctrl' => $TCA['tx_yagal_domain_model_tag']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, name, albums'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_tag.name',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim, required',
				'max'  => 256
			)
		),
		'albums' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:yagal/Resources/Private/Language/locallang_db.xml:tx_yagal_domain_model_tag.albums',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 0,
				'foreign_table' => 'tx_yagal_domain_model_album',
				'MM' => 'tx_yagal_album_tag_mm',
				'MM_opposite_field' => 'tags',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, name, albums')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>