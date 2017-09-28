<?php

namespace Prymag\ReviewsImporter\Controller\Adminhtml\Import;

class Upload extends \Magento\Backend\App\Action {
    /**
        * @var \Magento\Framework\View\Result\PageFactory
        */
        protected $resultPageFactory;

        /**
         * Constructor
         *
         * @param \Magento\Backend\App\Action\Context $context
         * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
         */
        public function __construct(
            \Magento\Backend\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory
        ) {
            parent::__construct($context);
            $this->resultPageFactory = $resultPageFactory;
        }

        /**
         * @return \Magento\Framework\View\Result\Page
         */
        public function execute()
        {
            $data = $this->getRequest()->getPostValue();
            return  $resultPage = $this->resultPageFactory->create();
        }
}