<?php
namespace Sinso\Smartimport\Service;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Jonas Renggli <jonas.renggli@swisscom.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Sinso\Smartimport\Exception\EmptyContentException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class ResourceImportService
{


    /*
     *
     * If-Modified-Since is compared to the Last-Modified whereas If-None-Match is compared to ETag. Both Modified-Since and ETag can be used to identify a specific variant of a resource.
     */

    /**
     * persistenceManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * @var bool
     */
    protected $overwriteExistingFiles = false;

    /**
     * Import a single resource, download the file and store it locally
     *
     * @param \Sinso\Smartimport\Domain\Model\Resource $resource
     * @throws EmptyContentException
     */
    public function importResource(\Sinso\Smartimport\Domain\Model\Resource $resource)
    {
        $resourcePathAndFilename = GeneralUtility::getFileAbsFileName($resource->getFilename());

        if ($this->overwriteExistingFiles || !file_exists($resourcePathAndFilename)) {
            if (!$resource->getSourceData()) {
                if (!$resource->getSource()) {
                    throw new EmptyContentException('No source or sourceData set', 1551781475);
                }

                $resource->setSourceData(GeneralUtility::getUrl($resource->getSource()));
            }

            if (!$resource->getSourceData()) {
                throw new EmptyContentException('No sourceData set', 1551781549);
            }

            file_put_contents($resourcePathAndFilename, $resource->getSourceData());
        }

        $fileObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->retrieveFileOrFolderObject($resourcePathAndFilename);
        $resource->setFileObject($fileObject);
    }


    /**
     * Import an array of resources (\Sinso\Smartimport\Domain\Model\Resource)
     * to the field $fieldname in an $entity
     *
     * TODO: Currently autodetect tablename from $entity
     * TODO: Remove deleted/missing resources from entity
     *
     * @param array<\Sinso\Smartimport\Domain\Model\Resource> $resources
     * @param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $entity
     * @param string $tablename
     * @param string $fieldname
     */
    public function importResourcesToEntity(Array $resources, \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $entity, $tablename, $fieldname) {
        $datamap = array();
        foreach ($resources as $resource) {
            /** @var \Sinso\Smartimport\Domain\Model\Resource $resource */
            $this->importResource($resource);

            $fileObject = $resource->getFileObject();

            $datamap['sys_file_reference']['NEW' . uniqid(6)] = array(
                'uid_local' => $fileObject->getUid(),
                'table_local' => 'sys_file',
                'uid_foreign' => $entity->getUid(),
                'tablenames' => $tablename,
                'fieldname' => $fieldname,
                'pid' => $entity->getPid(),
            );
        }

        if (!$datamap) {
            return;
        }

        // BUGFIX: storing count of resources doesn't work
        // $datamap[$tablename][$entity->getUid()] = array(
        //     $fieldname => count($datamap['sys_file_reference'])
        // );
        // WORKAROUND: manual update in database
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($tablename, 'uid = ' . $entity->getUid(), [$fieldname => count($datamap['sys_file_reference'])]);

        /** @var \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler */
        $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\DataHandling\DataHandler');
        $dataHandler->start($datamap, array());
        $dataHandler->admin = TRUE;
        $dataHandler->process_datamap();

        if ($dataHandler->errorLog) {
            // TODO: create nice exceptions
            die('error while saving resource');
        }
    }

    /**
     * @return boolean
     */
    public function isOverwriteExistingFiles()
    {
        return $this->overwriteExistingFiles;
    }

    /**
     * @param boolean $overwriteExistingFiles
     */
    public function setOverwriteExistingFiles($overwriteExistingFiles)
    {
        $this->overwriteExistingFiles = $overwriteExistingFiles;
    }

}
