<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2014 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */

class MT_RevSlider_Block_Adminhtml_Slide_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct(){
        $this->_blockGroup      = 'revslider';
        $this->_controller      = 'adminhtml_slide';
        $this->_form            = 'edit';
        $slide                  = Mage::registry('revslide');
        $slider                 = Mage::registry('revslider');
        $mediaUrl               = Mage::getBaseUrl('media');
        $cssUrl                 = Mage::helper('revslider')->getFrontendUrl('revslider/index/getCssCaptions', array('id' => $slider->getId()));
        $cssDelUrl              = $this->getUrl('adminhtml/slider/deleteCss');
        $cssSaveUrl             = $this->getUrl('adminhtml/slider/saveCss');
        $animUrl                = $this->getUrl('adminhtml/slider/saveAnimation');
        $animDelUrl             = $this->getUrl('adminhtml/slider/deleteAnimation');
        $anims                  = $this->_getAnims();
        $this->_formScripts[]   = "var cssEditor;";
        $this->_formScripts[]   = "var revLayer = new RevLayers(editForm, {$slider->getDelay()}, {
            css_save_url:   '{$cssSaveUrl}',
            css_delete_url: '{$cssDelUrl}',
            css_url:        '{$cssUrl}',
            media_url:      '{$mediaUrl}',
            anim_save_url:  '{$animUrl}',
            anim_delete_url: '{$animDelUrl}',
            anims: {$anims}
        });";
        if (is_array($slide->getLayers())){
            foreach ($slide->getLayers() as $layer){
                $this->_formScripts[] = "revLayer.addLayer(".Mage::helper('core')->jsonEncode($layer).");";
            }
        }
        parent::__construct();
    }

    protected function _getAnims(){
        $anims = array();
        $collection = Mage::getModel('revslider/animation')->getCollection();
        foreach ($collection as $item){
            $anims[] = array('id' => $item->getId(), 'name' => $item->getName(), 'params' => Mage::helper('core')->jsonDecode($item->getParams()));
        }
        return Mage::helper('core')->jsonEncode($anims);
    }

    public function getHeaderText(){
        $slide = Mage::registry('revslide');
        return Mage::helper('revslider')->__($slide->getId() ? "Edit Slide '{$slide->getTitle()}'" : 'New Slide');
    }

    public function _prepareLayout(){
        parent::_prepareLayout();

        $head   = $this->getLayout()->getBlock('head');
        $slider = Mage::registry('revslider');
        $slide  = Mage::registry('revslide');

        $backUrl = $this->getUrl('*/*/edit', array(
            'id'        => $slider->getId(),
            'activeTab' => 'slide_section'
        ));
        $deleteUrl = $this->getUrl('*/*/deleteSlide', array(
            'id'        => $slide->getId(),
            'sid'       => $slider->getId()
        ));

        $this->updateButton('delete', 'onclick', "confirmSetLocation('{$this->__('Do you want to remove this slide?')}', '{$deleteUrl}');");
        $this->updateButton('save', 'onclick', 'revLayer.save();');
        $this->updateButton('back', 'onclick', 'setLocation(\''.$backUrl.'\');');

        $this->_addButton('sac', array(
            'label'     => Mage::helper('revslider')->__('Save & Continue Edit'),
            'class'     => 'save',
            'onclick'   => "revLayer.save(true);"
        ));

        if (version_compare(Mage::getVersion(), '1.7.0.0') < 0){
            $head->addJs('mt/extensions/prototype/dragdrop.js');
        }

        if ($slider->getId()){
            if ($slider->getData('load_googlefont') == 'true'){
                $fonts = $slider->getData('google_font');
                if (is_array($fonts)){
                    foreach ($fonts as $font){
                        $href = Mage::helper('revslider')->getCssHref($font, true);
                        if ($href) $head->addLinkRel('stylesheet', $href);
                    }
                }
            }
        }

        return $this;
    }
}
