<?php
namespace Sinso\Smartimport\Service\Loader;

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


class DatahandlerLoader extends AbstractLoader
{

    const PREFIX = '-----';

    protected $datamap = Array();

    protected $cmdmap = Array();

    protected $falFields = Array();


    public function load($transformedData)
    {

        foreach ($transformedData as $item) {

        }
    }

    public function process() {
        /** @var \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler */
        $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\DataHandling\DataHandler');
        $dataHandler->start($this->datamap, array());
        $dataHandler->process_datamap();

        if ($dataHandler->errorLog) {
            var_dump($dataHandler->errorLog);
            throw new \Exception('error while processing datamap');
        }

        unset($dataHandler);

        $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\DataHandling\DataHandler');
        $dataHandler->admin = TRUE;
        $dataHandler->start($this->cmdmap, array());
        $dataHandler->process_cmdmap();

        if ($dataHandler->errorLog) {
            throw new \Exception('error while processing cmdmap');
        }

    }

}