<?php
namespace Dariah\DhFeeds\Domain\Model;


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

/**
 *
 *
 * @package dh_feeds
 */
class Pipes extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {

	/**
	 * time
	 *
	 * @var \DateTime
	 */
	protected $time;

	/**
	 * content
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Returns the time
	 *
	 * @return \DateTime $time
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * Sets the time
	 *
	 * @param \DateTime $time
	 * @return void
	 */
	public function setTime($time) {
		$this->time = $time;
	}

	/**
	 * Returns the content
	 *
	 * @return string $content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets the content
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

}
?>