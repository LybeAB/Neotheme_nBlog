<?php

/**
 * NeoTheme (Neo Industries Pty Ltd)
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to Neo Industries Pty LTD Non-Distributable Software Modification License (NDSML)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.neotheme.com/legal/licenses/NDSM.html
 * If the license is not included with the package or for any other reason, 
 * you did not receive your licence please send an email to 
 * license@neotheme.com so we can send you a copy immediately.
 *
 * This software comes with no warrenty of any kind. By Using this software, the user agrees to hold 
 * Neo Industries Pty Ltd harmless of any damage it may cause.
 *
 * @category    modules
 * @module      NeoTheme_Blog
 * @copyright   Copyright (c) 2011 Neo Industries Pty Ltd (http://www.neotheme.com)
 * @license     http://www.neotheme.com/  Non-Distributable Software Modification License(NDSML 1.0)
 */
class NeoTheme_Blog_Block_Adminhtml_Comment extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_comment';
        $this->_blockGroup = 'neotheme_blog';
        $this->_headerText = Mage::helper('neotheme_blog')->__('Comment Manager');
        $this->_addButtonLabel = Mage::helper('neotheme_blog')->__('Add Comment');
        parent::__construct();
		$this->_removeButton('add');
        $this->setTemplate('neotheme/blog/comment.phtml');
    }
    
    public function isSingleStoreMode() {
        if (!Mage::app()->isSingleStoreMode()) {
            return false;
        }
        return true;
    }
}