<?php

namespace Prymag\ReviewsImporter\Block\Adminhtml\Edit;

use Magento\Framework\App\Filesystem\DirectoryList;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {
    
    protected $appDir;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        
        $this->appDir = $context->getFilesystem()->getDirectoryRead(DirectoryList::APP)->getAbsolutePath();
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
        
        $fieldsets['base']->addField(
            'reviews_importer_note',
            'link',
            [
                'title' => 'Download Sample File',
                'value' => 'Download sample csv format',
                'href' => $this->getUrl('prymag_importer/*/index/', array('download_sample' => 'yes')),
                'label' => 'CSV Sample'
            ]
        );
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


    public function getSampleCSV(){
        return $this->appDir . 'code/Prymag/ReviewsImporter/sample.csv';
    }
}