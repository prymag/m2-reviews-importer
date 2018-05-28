<?php

namespace Prymag\ReviewsImporter\Controller\Adminhtml\Import;

use Magento\Backend\App\Response\Http\FileFactory;
use Magento\Framework\Filesystem\DirectoryList;

class Index extends \Magento\Backend\App\Action {
    /**
        * @var \Magento\Framework\View\Result\PageFactory
        */
        protected $resultPageFactory;

        protected $downloader;

        protected $directory;

        /**
         * Constructor
         *
         * @param \Magento\Backend\App\Action\Context $context
         * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
         */
        public function __construct(
            \Magento\Backend\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory,
            FileFactory $fileFactory,
    DirectoryList $directory
        ) {
            parent::__construct($context);
            $this->resultPageFactory = $resultPageFactory;

            $this->downloader = $fileFactory;
            $this->directory = $directory;
        }

        /**
         * @return \Magento\Framework\View\Result\Page
         */
        public function execute()
        {

            if( isset($this->getRequest()->getParams()['download_sample']) ){
                $heading = array(
                    'ID',
                    'PRODUCT',
                    'SKU',
                    'EMAIL',
                    'NICKNAME',
                    'RATING',
                    'TITLE',
                    'DETAIL',
                    'DATE',
                    'STATUS'
                );
                
                $filename = 'review_importer_sample.csv';
                $handle = fopen( $filename , 'w');
                fputcsv($handle, $heading);

                $data = $this->getSampleData();
                foreach($data as $d){
                    fputcsv($handle, $d);
                }

                $this->downloadCsv( $filename );
            }
            
            $this->messageManager->addNotice( 'Date format on the sample CSV file is MM/DD/YYYY, For status column use {1 = Approved, 2 = Pending, 3 = Not Approved} <br/> Please report issues to <a href="https://github.com/perrymarkg/m2-reviews-importer/issues">here</a>' );

            return  $resultPage = $this->resultPageFactory->create();
        }

        public function downloadCsv( $filename ){
            if (file_exists($filename)) {
                $filePath = $this->directory->getPath("pub") . DIRECTORY_SEPARATOR . $filename;

                return $this->downloader->create($filename, @file_get_contents($filePath));
            }
        }

        public function getSampleData(){
            $data = array(
                array(
                    '1',
                    '13',
                    'F456',
                    'hasemail@mail.com',
                    'Emily',
                    '2',
                    'Not Good Enough!',
                    'Missing something',
                    '08/13/2016',
                    '1'
                ),
                array(
                    '2',
                    '',
                    'T567',
                    'roni_cost@example.com',
                    'Roni',
                    '5',
                    'Amazing!',
                    'Excellent product',
                    '12/13/2017',
                    '2'
                ),
                array(
                    '3',
                    '243',
                    '',
                    '',
                    'Jamie',
                    '3',
                    'Almost!',
                    'Would have given it 5 stars if not for the damage',
                    '12/25/2017',
                    '3'
                ),
            );
            return $data;
        }
}