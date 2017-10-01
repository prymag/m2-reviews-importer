<?php

namespace Prymag\ReviewsImporter\Block\Adminhtml\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('reviews_importer_form');
        $this->setTitle(__('Reviews Form'));
    }

    /**
     * Build the form elements
     *
     * see \Magento\ImportExport\Block\Adminhtml\Import\Edit::_prepareForm();
     * 
     * @return void
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('prymag_importer/import/upload'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
        );

        $fieldsets['base'] = $form->addFieldset('base_fieldset', ['legend' => __('Import CSV File')]);
        /*$fieldsets['base']->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Department Name'), 'title' => __('Department Name'), 'required' => true]
        );*/
        $fieldsets['base']->addField(
            'reviews_import_file',
            'file',
            [
                'name' => 'reviews_import_file',
                'label' => __('Select File to Import'),
                'title' => __('Select File to Import'),
                'required' => true,
                'class' => 'input-file'
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}