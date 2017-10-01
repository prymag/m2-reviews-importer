<?php

namespace Prymag\ReviewsImporter\Controller\Adminhtml\Import;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;

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
            try{
                $uploader = $this->uploaderFactory->create(['fileId' => 'reviews_import_file']);
                $uploader->checkAllowedExtension('csv');
                $uploader->skipDbProcessing(true);
                $result = $uploader->save($this->getWorkingDir());

                $this->validateIfHasExtension($result);
            }
            catch( \Exception $e) {
                $this->messageManager->addError( __( $e->getMessage() ) );
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setPath('prymag_importer/import/index');
                return $resultRedirect;
            }



            return  $resultPage = $this->resultPageFactory->create();
        }

        public function validateIfHasExtension($result){
            $extension = pathinfo($result['file'], PATHINFO_EXTENSION);
            
            $uploadedFile = $result['path'] . $result['file'];
            if (!$extension) {
                $this->varDirectory->delete($uploadedFile);
                throw new \Exception(__('The file you uploaded has no extension.'));
            }
        }

        public function getWorkingDir()
        {
            return $this->varDirectory->getAbsolutePath('importexport/');
        }
}