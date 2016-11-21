<?php
namespace Sinso\Smartimport\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
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
class Resource extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {

	/**
	 * source
	 *
	 * @var string
	 */
	protected $source;

	/**
	 * sourceData
	 *
	 * @var string
	 */
	protected $sourceData;

	/**
	 * filename
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * @var \TYPO3\CMS\Core\Resource\File
	 */
	protected $fileObject;

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * @return string
	 */
	public function getSource()
	{

		return str_replace('https://', 'http://', $this->source);
		//return $this->source;
	}

	/**
	 * @param string $source
	 */
	public function setSource($source)
	{
		$this->source = $source;
	}

	/**
	 * @return string
	 */
	public function getSourceData()
	{
		return $this->sourceData;
	}

	/**
	 * @param string $sourceData
	 */
	public function setSourceData($sourceData)
	{
		$this->sourceData = $sourceData;
	}

	/**
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * @param string $filename
	 */
	public function setFilename($filename)
	{
		$this->filename = $filename;
	}

	/**
	 * @return \TYPO3\CMS\Core\Resource\File
	 */
	public function getFileObject()
	{
		return $this->fileObject;
	}

	/**
	 * @param \TYPO3\CMS\Core\Resource\File $fileObject
	 */
	public function setFileObject($fileObject)
	{
		$this->fileObject = $fileObject;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

}
