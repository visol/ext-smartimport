<?php
namespace Sinso\Smartimport\Domain\Model;

    /**
     * Credits:
     *   * EXT:news / Georg Ringer
     *   * https://gist.github.com/helhum/9a274ac1c29b50eedd71
     */

    /**
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

/**
 * File Reference
 *
 */
class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference
{

    /**
     * Obsolete when foreign_selector is supported by ExtBase persistence layer
     *
     * @var int
     */
    protected $uidLocal;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $alternative;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var bool
     */
    protected $showinpreview;

    /**
     * Uid of a sys_file
     *
     * @var integer
     */
    protected $originalFileIdentifier;

    /**
     * Set File uid
     *
     * @param int $fileUid
     */
    public function setFileUid($fileUid): void
    {
        $this->uidLocal = $fileUid;
    }

    /**
     * Get File UID
     *
     * @return int
     */
    public function getFileUid()
    {
        return $this->uidLocal;
    }

    /**
     * Set alternative
     *
     * @param string $alternative
     */
    public function setAlternative($alternative): void
    {
        $this->alternative = $alternative;
    }

    /**
     * Get alternative
     *
     * @return string
     */
    public function getAlternative()
    {
        return $this->alternative !== null ? $this->alternative : $this->getOriginalResource()->getAlternative();
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description !== null ? $this->description : $this->getOriginalResource()->getDescription();
    }

    /**
     * Set link
     *
     * @param string $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * Get link
     *
     * @return mixed
     * @return void
     */
    public function getLink()
    {
        return $this->link !== null ? $this->link : $this->getOriginalResource()->getLink();
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title !== null ? $this->title : $this->getOriginalResource()->getTitle();
    }

    /**
     * Set showinpreview
     *
     * @param bool $showinpreview
     */
    public function setShowinpreview($showinpreview): void
    {
        $this->showinpreview = $showinpreview;
    }

    /**
     * Get showinpreview
     *
     * @return bool
     */
    public function getShowinpreview()
    {
        return $this->showinpreview;
    }

    public function setOriginalResource(\TYPO3\CMS\Core\Resource\ResourceInterface $originalResource): void {
        $this->originalResource = $originalResource;
        $this->originalFileIdentifier = (int)$originalResource->getOriginalFile()->getUid();
    }

    public function setFile(\TYPO3\CMS\Core\Resource\File $falFile): void {
        $this->originalFileIdentifier = (int)$falFile->getUid();
    }

}