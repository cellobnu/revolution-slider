<?php
/**
 * @category    MT
 * @package     MT_RevSlider
 * @copyright   Copyright (C) 2008-2014 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */

class MT_RevSlider_Block_Adminhtml_Widget_Form_Cinanimation
    extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface{

    protected $_element;

    public function __construct(){
        parent::__construct();
        $this->setTemplate('mt/revslider/widget/form/cinanimation.phtml');
    }

    public function getElement(){
        return $this->_element;
    }

    public function setElement(Varien_Data_Form_Element_Abstract $element){
        return $this->_element = $element;
    }

    public function render(Varien_Data_Form_Element_Abstract $element){
        $this->setElement($element);
        return $this->toHtml();
    }

    protected function _prepareLayout(){
        $this->setChild('edit', $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
            'label'     => Mage::helper('revslider')->__('Custom Animation'),
            'type'      => 'button',
            'id'        => 'cInAnimation',
            'onclick'   => sprintf('revLayer.openAnimationDialog(\'%s\', \'editAnimationWindow\', \'%s\', \'in\')',
                $this->getUrl('adminhtml/slider/animation'),
                Mage::helper('revslider')->__('Edit Animation')
            )
        )));
        $this->setChild('new', $this->getLayout()->createBlock('adminhtml/widget_button', '', array(
            'label'     => Mage::helper('revslider')->__('New Animation'),
            'type'      => 'button',
            'id'        => 'cNewInAnimation',
            'onclick'   => sprintf('revLayer.openAnimationDialog(\'%s\', \'editAnimationWindow\', \'%s\', \'in\')',
                $this->getUrl('adminhtml/slider/animation'),
                Mage::helper('revslider')->__('New Animation')
            )
        )));

        return parent::_prepareLayout();
    }
}
