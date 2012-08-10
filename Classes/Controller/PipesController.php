<?php
namespace Dariah\DhFeeds\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Ingo Pfennigstorf <i.pfennigstorf@gmail.com>, SUB Goettingen
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

require \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dh_feeds') . 'vendor/autoload.php';

/**
 * Controller for Pipes
 */
class PipesController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\AbstractFrontend
	 */
	protected $cacheInstance;

	/**
	 * @var \SimplePie
	 * @inject
	 */
	protected $parser;

	/**
	 * @var int
	 */
	protected $maxItems;

	/**
	 * feeds to be parsed and shown
	 *
	 * @var array
	 */
	protected $feeds = array();

	/**
	 * Initializes some defaults
	 */
	public function initializeAction() {
		// get cache instance of feeds
		$this->cacheInstance = $GLOBALS['typo3CacheManager']->getCache('dhfeeds_twitter');

		// how many items to be shown?
		$this->maxItems = isset($this->settings['numberOfElements']) ? intval($this->settings['numberOfElements']) : 5;

		// iterate over Feed urls defined in TypoScript and add them to an array
		foreach ($this->settings['blogs']['feeds'] as $feed) {
			array_push($this->feeds, $feed);
		}
	}

	/**
	 * Processes RSS feeds and assigns them to the view
	 *
	 * @return void
	 */
	public function listAction() {

		// first check if we have something cached
		if ($this->cacheInstance->has('pipes')) {
			$pipes = $this->cacheInstance->get('pipes');
		} else {
			$pipes = array();

			foreach ($this->feeds as $key => $feed) {
				$this->parser->set_feed_url($feed);
				$this->parser->init();
				$this->parser->handle_content_type();
				foreach ($this->parser->get_items() as $item) {
					$pipe = new \Dariah\DhFeeds\Domain\Model\Pipes();
					$pipe->setContent($item->get_description());
					$pipe->setTime($item->get_title());
					$pipe->setUrl($item->get_permalink());

					$pipe->setTime(new \DateTime($item->get_date()));
					$pipe->setTitle($item->get_title());
					array_push($pipes, $pipe);
				}

			}
			// sort articles by date
			usort($pipes, array($this, 'dateCompare'));

			// reduce the amount of displayed articles to the desired minimum
			$pipes = array_slice($pipes, 0, $this->maxItems);
			$this->cacheInstance->set('pipes', $pipes);
		}
		$this->view->assign('pipes', $pipes);
	}

	/**
	 * Sorts the array according to their \DateTime properties
	 *
	 * @see http://stackoverflow.com/questions/8121241/sort-array-based-on-the-datetime-in-php
	 * @param \Dariah\DhFeeds\Domain\Model\Pipes $a
	 * @param \Dariah\DhFeeds\Domain\Model\Pipes $b
	 */
	protected function dateCompare($a, $b) {

		if ($a == $b) {
			return 0;
		}

		return $a < $b ? 1 : -1;

		return $b->getTime()->diff($a->getTime());
	}

}

?>