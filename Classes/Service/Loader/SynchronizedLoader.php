<?php
namespace Sinso\Smartimport\Service\Loader;

use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;

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


class SynchronizedLoader extends DatahandlerLoader
{

    const HASHSTRING_LENGTH = 10;

    const STATUS_NO_CHANGE = 0;
    const STATUS_EXTERNAL_CHANGE = 1;
    const STATUS_INTERNAL_CHANGE = 2;
    const STATUS_CONFLICTING_CHANGE = 3;
    const STATUS_MERGEABLE_CHANGE = 4;

    protected $importHashField = 'import_hash';
    protected $synchronizedFields = Array('name', 'url');



    public function load($transformedData)
    {
        foreach ($transformedData as $item) {
        }
    }

    protected function sync(DomainObjectInterface $domainObject, $uniqueIdentifier) {
        $tables = array_keys($this->datamap);
        foreach ($tables as $table) {
            foreach ($this->datamap[$table] as $id => $fieldArray) {
                if (!is_array($fieldArray)) {
                    continue;
                }
                $this->setImportHashInFieldArray($fieldArray);
            }
        }
    }

    protected function calculateHashFromValue($value) {
        return substr(md5($value), 0, self::HASHSTRING_LENGTH);
    }


    protected function setImportHashInFieldArray(&$fieldArray) {
        $importHash = array();

        foreach ($this->synchronizedFields as $field) {
            $value = $fieldArray[$field];
            $importHash[$field] = $this->calculateHashFromValue($value);
        }

        $fieldArray[$this->importHashField] = $importHash;
    }
}