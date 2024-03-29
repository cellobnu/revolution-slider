<?php
/**
 * @category    MT
 * @package     MT_Extensions
 * @copyright   Copyright (C) 2008-2014 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */

class MT_Extensions_Block_Adminhtml_Widget_Form_Element_Browser
    extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface{

    protected $_element;

    public function __construct(){
        parent::__construct();
        $this->setTemplate('mt/extensions/adminhtml/widget/form/element/browser.phtml');
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
        $this->setElement($this->getData('element'));

        $browserBtn = $this->getLayout()->createBlock('adminhtml/widget_button', 'button',  array(
            'label'     => '...',
            'title'     => Mage::helper('mtext')->__('Click to browser media'),
            'type'      => 'button',
            'onclick'   => sprintf('MT.MediabrowserUtility.openDialog(\'%s\')',
                Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index', array(
                    'static_urls_allowed'   => 1,
                    'target_element_id'     => $this->getElement()->getHtmlId()
                ))
            )
        ));
        $this->setChild('browserBtn', $browserBtn);
        $clearBtn = $this->getLayout()->createBlock('adminhtml/widget_button', 'button',  array(
            'label'     => 'x',
            'title'     => Mage::helper('mtext')->__('Click to clear value'),
            'type'      => 'button',
            'onclick'   => "on_{$this->getElement()->getHtmlId()}_clear_click();"
        ));
        $this->setChild('clearBtn', $clearBtn);

        return parent::_prepareLayout();
    }
}
