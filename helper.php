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
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Uri\Uri;

/**
 * Simple template helper.
 *
 * @package  simple
 * @since    1.0
 */
class tplSimpleHelper
{
	static public function template()
	{
		return Factory::getApplication()->getTemplate();
	}

    /**
     * Method to get current Page Option
     *
     * @access public
     *
     * @return mixed
     * @throws Exception
     * @since 1.0
     */
	static public function getPageOption()
	{
		return Factory::getApplication()->input->getCmd('option', '');
	}

    /**
     * Method to get current Page View
     *
     * @access public
     *
     * @return mixed
     * @throws Exception
     * @since 1.0
     */
	static public function getPageView()
	{
		return Factory::getApplication()->input->getCmd('view', '');
	}

    /**
     * Method to get current Page Layout
     *
     * @access public
     *
     * @return mixed
     * @throws Exception
     * @since version
     */
	static public function getPageLayout()
	{
		return Factory::getApplication()->input->getCmd('layout', '');
	}

    /**
     * Method to get current Page Task
     *
     * @access public
     *
     * @return mixed
     * @throws Exception
     * @since 1.0
     */
	static public function getPageTask()
	{
		return Factory::getApplication()->input->getCmd('task', '');
	}

    /**
     * Method to get the current Menu Item ID
     *
     * @access public
     *
     * @return int
     * @throws Exception
     * @since 1.0
     */
	static public function getItemId()
	{
		return Factory::getApplication()->input->getInt('Itemid');
	}

    /**
     * Method to get PageClass set with Menu Item
     *
     * @return mixed
     * @throws Exception
     * @since  1.0
     */
	static public function getPageClass()
	{
		$activeMenu = Factory::getApplication()->getMenu()->getActive();
		$pageclass  = ($activeMenu) ? $activeMenu->params->get('pageclass_sfx', '') : '';

		return $pageclass;
	}

    /**
     * Method to determine whether the current page is the Joomla! homepage
     *
     * @access public
     *
     * @return bool
     * @throws Exception
     * @since  1.0
     */
	static public function isHome()
	{
		// Fetch the active menu-item
		$activeMenu = Factory::getApplication()->getMenu()->getActive();

		// Return whether this active menu-item is home or not
		return (boolean) ($activeMenu) ? $activeMenu->home : false;
	}

	/**
	 * Method to fetch the current path
	 *
	 * @access public
	 *
	 * @param string $output Output type
	 *
	 * @return mixed
	 * @since  1.0
	 */
	static public function getPath($output = 'array')
	{
		$path = Uri::getInstance()->getPath();
		$path = preg_replace('/^\//', '', $path);
		if ($output == 'array')
		{
			$path = explode('/', $path);

			return $path;
		}

		return $path;
	}

    /**
     * Generate a list of useful CSS classes for the body
     *
     * @access public
     *
     * @return bool
     * @throws Exception
     * @since  1.0
     */
	static public function setBodySuffix()
	{
		$classes   = array();
		$classes[] = 'option-' . self::getPageOption();
		$classes[] = 'view-' . self::getPageView();
		$classes[] = self::getPageLayout() ? 'layout-' . self::getPageLayout() : 'no-layout';
		$classes[] = self::getPageTask() ? 'task-' . self::getPageTask() : 'no-task';
		$classes[] = 'itemid-' . self::getItemId();
		$classes[] = self::getPageClass();
		$classes[] = self::isHome() ? 'path-home' : 'path-' . implode('-', self::getPath('array'));

		return implode(' ', $classes);
	}

	/**
	 * Method to manually override the META-generator
	 *
	 * @access public
	 *
	 * @param string $generator
	 *
	 * @return null
	 *
	 * @since  1.0
	 */
	static public function setGenerator($generator)
	{
		Factory::getDocument()->setGenerator($generator);
	}

	/**
	 * Method to get the current sitename
	 *
	 * @access public
	 *
	 * @param null
	 *
	 * @return string
	 * @since  1.0
	 */
	static public function getSitename()
	{
		return Factory::getConfig()->get('sitename');
	}

	/**
     * Method to set some Meta data
     *
	 * @access public
	 *
	 * @param null
	 *
	 * @return null
	 * @since  1.0
    */
	static public function setMetadata()
	{
		$doc    = Factory::getDocument();

		$doc->setHtml5(true);
		$doc->setMetaData('X-UA-Compatible', 'IE=edge', true);
		$doc->setMetaData('viewport', 'width=device-width, initial-scale=1.0');
		//self::setGenerator(self::getSitename());
	}

	/**
	 * Method to load CSS
	 *
	 * @access public
	 *
	 * @param null
	 *
	 * @since  1.0
	 */
	static public function loadCss()
	{
        HTMLHelper::_('stylesheet', 'normalize.css', ['version' => 'auto', 'relative' => true]);
		HTMLHelper::_('stylesheet', 'template.css', ['version' => 'auto', 'relative' => true]);

		// Check for a custom CSS file
		$userCss = JPATH_SITE . '/templates/' . self::template() . '/css/user.css';

		if (file_exists($userCss) && filesize($userCss) > 0)
		{
			HTMLHelper::_('stylesheet', 'user.css', ['version' => 'auto', 'relative' => true]);
		}

        HTMLHelper::_('stylesheet', 'custom.css', ['version' => 'auto', 'relative' => true]);
	}

	/**
	 * Method to load JS
	 *
	 * @access public
	 *
	 * @param null
	 *
	 * @since  1.0
	 */
	static public function loadJs()
	{
		HTMLHelper::_('script', 'libs.min.js', ['version' => 'auto', 'relative' => true]);
		HTMLHelper::_('script', 'template.js', ['version' => 'auto', 'relative' => true]);
	}

}
