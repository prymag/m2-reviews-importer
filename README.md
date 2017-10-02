# Magento 2 Reviews Importer

A simple reviews importer module for magento 2.

Go to importer page
![alt text](https://image.ibb.co/kzzqTw/sc1.png "")

Download the sample csv format and add your content then import.
![alt text](https://preview.ibb.co/kAUeMG/sc2.png "")

### Installation

* Create the folders inside app/code directory
    * Prymag/ReviewsImporter
* Download zip file and extract contents of it inside the created directory or clone it inside the directory
    *   Folder structure should now look like this 
    *   ![alt text](https://image.ibb.co/kdK2ab/sc3.png "")
* Run the commands
~~~
$php bin/magento module:enable Prymag_ReviewsImporter
$php bin/magento cache:flush
~~~

##### Note

* Saving of CSV to the database after file upload for this module was based on the module-magento-sample-data
* Currently tested and working on version 2.2.
* This should work fine as well on version 1.6+ as it looks like there's not much change on the review module that would affect the code for this importer module.