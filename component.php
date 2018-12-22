<?php
/**
 * @package    simple
 *
 * @author     Artem Vasilev <kern.usr@gmail.com>
 * @copyright  Copyright (C) 2018 Artem Vasilev. All rights reserved.
 * @license    GNU General Public License version 3 or later; see LICENSE.txt
 * @link       https://awesomio.org
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;

require_once JPATH_THEMES . '/' . $this->template . '/helper.php';

// Output as HTML5
$doc->setHtml5(true);

tplSimpleHelper::loadCss();

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<jdoc:include type="head" />
</head>
<body class="contentpane modal">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</body>
</html>
