<?php

namespace Sinso\Smartimport\Service;

/*
 * Credits: Artus Kolanowski (https://forge.typo3.org/issues/61722)
 *
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;

/**
 * Provides services to translate domain objects
 */
class DomainObjectTranslationService implements SingletonInterface
{
    protected \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper $dataMapper;

    /**
     * Translates a domain object
     */
    public function translate(DomainObjectInterface $origin, DomainObjectInterface $translation, int $language)
    {
        if (get_class($origin) !== get_class($translation)) {
            throw new \Exception('Origin and translation must be the same type.', 1432499926);
        }

        $dataMap = $this->dataMapper->getDataMap(get_class($origin));

        if (!$dataMap->getTranslationOriginColumnName()) {
            throw new \Exception('The type is not translatable.', 1432500079);
        }

        $propertyName = GeneralUtility::underscoredToLowerCamelCase($dataMap->getTranslationOriginColumnName());
        if ($translation->_setProperty($propertyName, $origin) === false) {
            $columnMap = $dataMap->getColumnMap($propertyName);
            $columnMap->setTypeOfRelation(ColumnMap::RELATION_HAS_ONE);
            $columnMap->setType($dataMap->getClassName());
            $columnMap->setChildTableName($dataMap->getTableName());

            $translation->{$propertyName} = $origin;
        }

        $translation->_setProperty('_languageUid', $language);
    }

    public function injectDataMapper(DataMapper $dataMapper): void
    {
        $this->dataMapper = $dataMapper;
    }
}
