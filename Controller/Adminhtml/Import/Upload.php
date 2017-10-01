<?php

namespace Prymag\ReviewsImporter\Controller\Adminhtml\Import;

use Magento\Framework\App\Filesystem\DirectoryList;

class Upload extends \Magento\Backend\App\Action {
        /**
        * @var \Magento\Framework\View\Result\PageFactory
        */
        protected $resultPageFactory;

        protected $httpFactory;

        protected $uploaderFactory;

        protected $varDirectory;

        public function __construct(
            \Magento\Backend\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory,
            \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,
            \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
            \Magento\Framework\Filesystem $filesystem
        ) {
            parent::__construct($context);
            $this->resultPageFactory = $resultPageFactory;
            $this->httpFactory = $httpFactory;
            $this->uploaderFactory = $uploaderFactory;
            $this->varDirectory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        }

        public function execute()
        {
            
            /**
             * fileId field must be the same name as the upload_field name from the form block
             * see Prymag\ReviewsImporter\Block\Adminhtml\Edit\Form
             */
            $uploader = $this->uploaderFactory->create(['fileId' => 'reviews_import_file']);
            $uploader->skipDbProcessing(true);
            $result = $uploader->save($this->getWorkingDir());

            return  $resultPage = $this->resultPageFactory->create();
        }

        public function getWorkingDir()
        {
            return $this->varDirectory->getAbsolutePath('importexport/');
        }
}