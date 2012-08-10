<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Twitter',
	'Twitter'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'feeds',	// Submodule key
		'',						// Position
		array(
			'Tweet' => 'list',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_feeds.xml',
		)
	);

}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Web 2.0 Feeds');

t3lib_extMgm::addLLrefForTCAdescr('tx_dhfeeds_domain_model_tweet', 'EXT:dh_feeds/Resources/Private/Language/locallang_csh_tx_dhfeeds_domain_model_tweet.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_dhfeeds_domain_model_tweet');
$TCA['tx_dhfeeds_domain_model_tweet'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dh_feeds/Resources/Private/Language/locallang_db.xml:tx_dhfeeds_domain_model_tweet',
		'label' => 'username',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'username,time,content,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Tweet.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dhfeeds_domain_model_tweet.gif'
	),
);

?>