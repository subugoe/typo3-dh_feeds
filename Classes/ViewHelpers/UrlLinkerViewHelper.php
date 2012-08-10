<?php
namespace Dariah\DhFeeds\ViewHelpers;
/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>
 *      Goettingen State Library
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
 * ************************************************************* */

/**
 * ViewHelper to parse twitter links (t.co) and twitter usernames
 */
class UrlLinkerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param string $text
	 * @return string
	 */
	public function render($text) {
		$pattern = '|(http:\/\/t\.co\/[a-z0-9]+)|si';
		$linkedText = preg_replace($pattern, '<a href="$1">$1</a>', $text);

		$userNamePattern = '|(@([a-z0-9]+))|si';
		$linkedText = preg_replace($userNamePattern, '<a href="https://twitter.com/$2">$1</a>', $linkedText);

		return $linkedText;
	}
}