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
class NeoTheme_Blog_Block_Post_Latest extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface {

    function _construct() {
        $this->setTemplate('neotheme/blog/post/latest/list.phtml');
        $this->setSummaryBlockType('neotheme_blog/post_summary');
        $this->setSummaryTemplate('neotheme/blog/post/latest/summary.phtml');

    }


    private $_collection;

    function getUseCustomerPreferences() {
        return filter_var($this->getData('use_customer_preferences'), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Prepare the post collection for list display
     * @return type
     */
    function _prepareCollection() {

        $this->_collection = Mage::getModel('neotheme_blog/post')
            ->getCollection()
            ->addStoreFilter()
            ->addStatusFilter(NeoTheme_Blog_Model_Post::STATUS_ACTIVE)
            ->addPublishFilter()
            ->setPageSize(1)
            ->setCurPage(1)
            ->setPostOrder();

        return $this->_collection;
    }

    function _showDrafts() {
        return Mage::helper('neotheme_blog')->isIpPermitted();
    }

    function getCollection() {
        if ($this->_collection == null) {
            $this->_prepareCollection();
        }
        return $this->_collection;
    }

    function _prepareLayout() {

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5 => 5, 10 => 10, 20 => 20, 'all' => 'all'));

        $this->setChild('pager', $pager);
        parent::_prepareLayout();
    }

    function _toHtml() {
        $this->getChild('pager')->setCollection($this->getCollection());
        return parent::_toHtml();
    }

    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }

    public function getCategory(){
        if (!Mage::registry('current_blog_category')){
            $this->_initCategory($this->getCategoryId());
        }
        return Mage::registry('current_blog_category');
    }

    protected function _initCategory($id = NULL){
        if ($id == NULL){
            $data = $this->getRequest()->getParams();
            $id = $data['id'];
        }
        $category = Mage::getModel('neotheme_blog/category');
        if ($id != NULL){
            $category->load($id);
            Mage::register('current_blog_category', $category);
        }
        return $category;
    }

    function getSummaryBlock($post) {

        if (!$this->getLayout()->getBlock('post_summary_' . $post->getId())) {

            $post->setCurrentCategoryId($this->getCategoryId());
            $post_summary = $this->getLayout()->createBlock($this->getSummaryBlockType(), 'post_summary_' . $post->getId())
                ->setTemplate($this->getSummaryTemplate())
                ->setPost($post);
           return $this->getLayout()->getBlock('post_summary_' . $post->getId());
        }


        return $this->getLayout()->getBlock('post_summary_' . $post->getId());
    }

}