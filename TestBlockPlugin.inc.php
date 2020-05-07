<?php

import('lib.pkp.classes.plugins.BlockPlugin');

class TestBlockPlugin extends BlockPlugin {

	function register($category, $path, $mainContextId = null) {
		if (parent::register($category, $path, $mainContextId)) {
			if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;

			if ($this->getEnabled($mainContextId)) {
				HookRegistry::register('TemplateManager::display', array($this, 'handleTemplateDisplay'));
				HookRegistry::register('LoadHandler', array($this, 'setupCallbackHandler'));
			}
			return true;
		}
		return false;
	}

	function handleTemplateDisplay($hookName, $args) {
		$templateMgr =& $args[0];
		$template =& $args[1];
		$request = PKPApplication::get()->getRequest();
		$templateMgr->addStyleSheet(
			'TestBlockPlugin',
			$request->getBaseUrl() . '/' . $this->getStyleSheet(),
			array(
				'contexts' => array('frontend')
			)
		);
		return false;
	}

	function setupCallbackHandler($hookName, $args) {
		// TODO: Do something
	}

	function getStyleSheet() {
		return $this->getPluginPath() . '/styles/teststyle.css';
	}
	function getDisplayName() {
		return 'Test Block Plugin';
	}
	function getDescription() {
		return 'Test Block Plugin Description';
	}
	function getContents($templateMgr, $request = null) {
		return parent::getContents($templateMgr);
	}
}
