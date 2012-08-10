<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Dariah.' . $_EXTKEY,
	'Twitter',
	array(
		'Tweet' => 'list',

	),
	// non-cacheable actions
	array(
		'Tweet' => '',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Dariah.' . $_EXTKEY,
	'Pipes',
	array(
		'Pipes' => 'list',

	),
	// non-cacheable actions
	array(
		'Pipes' => '',
	)
);

	// caching
if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['dhfeeds_twitter'])) {
	$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['dhfeeds_twitter'] = array();
}

?>