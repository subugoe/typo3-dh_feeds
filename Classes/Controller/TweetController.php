<?php
namespace Dariah\DhFeeds\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Ingo Pfennigstorf <i.pfennigstorf@gmail.com>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dh_feeds') . 'Classes/Contrib/OAuth/twitteroauth/twitteroauth.php');

/**
 *
 *
 */
class TweetController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var string
	 */
	protected $consumerKey;

	/**
	 * @var string
	 */
	protected $consumerSecret;

	/**
	 * @var string
	 */
	protected $oauthToken;

	/**
	 * @var string
	 */
	protected $oauthTokenSecret;

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\AbstractFrontend
  	 */
	protected $cacheInstance;

	/**
	 * tweetRepository
	 *
	 * @var \Dariah\DhFeeds\Domain\Repository\TweetRepository
	 * @inject
	 */
	protected $tweetRepository;

	/**
	 * Username of the twitter user whoms timeline should be shown
	 *
	 * @var string
	 */
	protected $user;

	/**
	 * Iniitializes some defaults
	 */
	public function initializeAction() {
		$this->cacheInstance = $GLOBALS['typo3CacheManager']->getCache('dhfeeds_twitter');

		// simplify access to twitter auth settings
		$twitterSettings = $this->settings['twitter'];
		$this->consumerSecret = $twitterSettings['auth']['consumerSecret'];
		$this->consumerKey = $twitterSettings['auth']['consumerKey'];
		$this->oauthToken = $twitterSettings['auth']['oauthToken'];
		$this->oauthTokenSecret = $twitterSettings['auth']['oauthTokenSecret'];

		$this->user = $twitterSettings['user'];
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {

		$maxItems = isset($this->settings['numberOfElements']) ? intval($this->settings['numberOfElements']) : 5;

		// first check if we have something cached
		if ($this->cacheInstance->has('tweets')) {
			$tweets = $this->cacheInstance->get('tweets');
		} else {

			// authenticate on twitter
			$oAuth = new \TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->oauthToken, $this->oauthTokenSecret);

			// get desired statuses
			$statuses = $oAuth->get('/statuses/user_timeline', array('screen_name' => $this->user));
			$tweets = array();
			foreach ($statuses as $status) {
				if ($status->user->protected === FALSE) {
					$tweet = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Dariah\\DhFeeds\\Domain\\Model\\Tweet');
					$tweet->setUsername($status->user->screen_name);
					$tweet->setRealName($status->user->name);
					$tweet->setTime($status->created_at);
					$tweet->setImage($status->user->profile_image_url);
					$tweet->setContent($status->text);
				}
				array_push($tweets, $tweet);
			}

			$this->cacheInstance->set('tweets', $tweets);
		}
		$this->view->assign('tweets', $tweets);
		$this->view->assign('maxItems', $maxItems);
	}

}
?>