Feeds
=====

What does it do?
****************

This TYPO3 Extension provides the possibility to display Tweets from a certain list and also data from rss feeds, such as blogs, news sites.

The Extension contains a plugin for each of the purposes mentioned above.

Installation
************

Note: This extension only works in TYPO3 Version with PSR-0 namespaces. So be sure to use it in versions >= 6.0.

Get the Extension from github or maybe later TER and put it into your typo3conf/ext directory.

Insert the TypoScript into your template and proceed with the configuration.

Configuration
*************

The configuration splits into two sections - Twitter and Feeds.

For Twitter add your credentials to the corresponding TypoScript constants. Also provide the list id from twitter that you want to follow.

The blog / feed configuration is quite straigt forward. Add your RSS feed urls into your TypoScript template with a unique identifier.

Example:

`plugin.tx_dhfeeds.settings.blogs.feeds.1 = http://www.dancohen.org/feed/`

`plugin.tx_dhfeeds.settings.blogs.feeds.2 = http://www.example.com/rss.xml/`

Usage
*****

Insert the plugins as page content element.

Notes and Todo
**************

This repository contains a squashed commit - I had to merge some commits to remove sensitive test data.
The commit messages of the squashed commit can be found in `0038a34079 <https://github.com/subugoe/typo3-dh_feeds/commit/0038a34079bce6757bbf2a3b026dcde4603bbd84>`_.