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


class SimpleSyncService extends AbstractSyncService
{

    protected $model;

    protected $tablename;

    public function sync($data) {
        foreach ($itemInAllLanguages as $language => $item) {
            $shopItem = new ShopItem();
            $shopItem->setName($item['name']);
            $shopItem->setUrl(str_replace('https://', 'http://', $item['url']));
            $shopItem->setDescription($item['articledescription']);
            // TODO: Set category
            //$shopItem->setCategory($item['name']);

            $productInformationFromWebScraper = $this->fetchProductInformationByDetailUrl($shopItem->getUrl());

            if ($language == $this->defaultLanguage) {
                $this->shopItemRepository->add($shopItem);
                $this->persistenceManager->persistAll();
                $shopItemL10nParent = $shopItem;
            } else {
                $shopItem->setL10nParent($shopItemL10nParent);
                $shopItem->_setProperty('_languageUid', $this->languages[$language]);
                $this->shopItemRepository->add($shopItem);
                $this->persistenceManager->persistAll();
            }

            $resourcesToImport = array();

            if (!is_array($productInformationFromWebScraper) || !is_array($productInformationFromWebScraper['images'])) {
                continue;
            }

            foreach ($productInformationFromWebScraper['images'] as $image) {
                $resourceToImport = new Resource();
                $resourceToImport->setSource($image);
                $resourceToImport->setFilename($this->imageFolder . basename($image));

                $resourcesToImport[] = $resourceToImport;
            }

            $this->resourceImportService->importResourcesToEntity($resourcesToImport, $shopItem, 'tx_smartimport_domain_model_shopitem', 'image');

        }
    }

}