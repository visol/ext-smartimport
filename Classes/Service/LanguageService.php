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


class LanguageService
{
    public function getLanguages() {
        $languages = Array();
        $languages['default'] = 0;

        $languageRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid, language_isocode', 'sys_language', '');

        foreach($languageRows as $row) {
            $languages[$row['language_isocode']] = $row['uid'];
        }

        return $languages;
    }

}