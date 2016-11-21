<?php
namespace Sinso\Smartimport\Domain\Model;

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

/**
 * Maping
 */
class ImportedEntity extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * sourceUniqueIdentifier
	 *
	 * @var string
	 */
	protected $sourceUniqueIdentifier;

	/**
	 * sourceFieldHashes
	 *
	 * @var array
	 */
	protected $sourceFieldHashes = array();

	/**
	 * internalUid
	 *
	 * @var int
	 */
	protected $internalUid = '';

	/**
	 * internalPid
	 *
	 * @var pid
	 */
	protected $internalPid = '';

	protected $internalLanguage = 0;

	/**
	 * internalEntityClassName
	 *
	 * @var string
	 */
	protected $internalEntityClassname = '';

	/**
	 * @return string
	 */
	public function getSourceUniqueIdentifier()
	{
		return $this->sourceUniqueIdentifier;
	}

	/**
	 * @param string $sourceUniqueIdentifier
	 */
	public function setSourceUniqueIdentifier($sourceUniqueIdentifier)
	{
		$this->sourceUniqueIdentifier = $sourceUniqueIdentifier;
	}

	/**
	 * @return array
	 */
	public function getSourceFieldHashes()
	{
		return $this->sourceFieldHashes;
	}

	/**
	 * @param array $sourceFieldHashes
	 */
	public function setSourceFieldHashes($sourceFieldHashes)
	{
		$this->sourceFieldHashes = $sourceFieldHashes;
	}

	/**
	 * @return int
	 */
	public function getInternalUid()
	{
		return $this->internalUid;
	}

	/**
	 * @param int $internalUid
	 */
	public function setInternalUid($internalUid)
	{
		$this->internalUid = $internalUid;
	}

	/**
	 * @return pid
	 */
	public function getInternalPid()
	{
		return $this->internalPid;
	}

	/**
	 * @param pid $internalPid
	 */
	public function setInternalPid($internalPid)
	{
		$this->internalPid = $internalPid;
	}

	/**
	 * @return string
	 */
	public function getInternalEntityClassname()
	{
		return $this->internalEntityClassname;
	}

	/**
	 * @param string $internalEntityClassName
	 */
	public function setInternalEntityClassName($internalEntityClassname)
	{
		$this->internalEntityClassname = $internalEntityClassname;
	}

	/**
	 * @return int
	 */
	public function getInternalLanguage()
	{
		return $this->internalLanguage;
	}

	/**
	 * @param int $language
	 */
	public function setInternalLanguage($internalLanguage)
	{
		$this->internalLanguage = $internalLanguage;
	}

}
