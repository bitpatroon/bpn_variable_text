<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans van der Veen, SPL
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

namespace BPN\BpnVariableText\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class VariableText extends AbstractEntity
{
    const FORMATTING_PLAIN = '1';
    const FORMATTING_HTML = '2';

    /**
     * @var string
     */
    protected $textFormatting;

    /**
     * @var string
     */
    protected $html;
    /**
     * @var string
     */
    protected $plaintext;

    /**
     * @var string
     */
    protected $markers;

    /**
     * @var string
     */
    protected $labelName;

    /**
     * Setter for the pid.
     */
    public function setPid(int $pid) : void
    {
        parent::setPid($pid);
    }

    /**
     * Gets the labelName property.
     *
     * @return string
     */
    public function getLabelName()
    {
        return $this->labelName;
    }

    /**
     * Sets the labelName property.
     *
     * @param string $labelName
     *
     * @return $this
     */
    public function setLabelName($labelName)
    {
        $this->labelName = $labelName;

        return $this;
    }

    /**
     * Gets the textType property.
     *
     * @return string
     */
    public function getTextFormatting()
    {
        return $this->textFormatting;
    }

    /**
     * Sets the textType property.
     *
     * @param string $textFormatting
     *
     * @return $this
     */
    public function setTextFormatting($textFormatting)
    {
        $this->textFormatting = $textFormatting;

        return $this;
    }

    /**
     * Gets the markers property.
     *
     * @return string
     */
    public function getMarkers() : string
    {
        return $this->markers ?? '';
    }

    /**
     * Sets the markers property.
     *
     * @param string $markers
     *
     * @return $this
     */
    public function setMarkers($markers)
    {
        $this->markers = $markers;

        return $this;
    }

    /**
     * Gets available markers in list.
     *
     * @return array
     */
    public function getAvailableMarkers()
    {
        $content = $this->getContents();
        return $this->getMarkersFromContent($content);
    }

    public function getHtml() : string
    {
        return $this->html;
    }

    /**
     * @return $this
     */
    public function setHtml(string $html) : VariableText
    {
        $this->html = $html;

        return $this;
    }

    public function getPlaintext() : string
    {
        return $this->plaintext;
    }

    /**
     * @return $this
     */
    public function setPlaintext(string $plaintext) : VariableText
    {
        $this->plaintext = $plaintext;

        return $this;
    }

    public function getContents()
    {
        switch ((int)$this->getTextFormatting()) {
            case self::FORMATTING_HTML:
                return $this->html;
            default:
                return $this->plaintext;
        }
    }

    private function getMarkersFromContent(string $contents)
    {
        if(!$contents){
            return [];
        }
        if (!preg_match_all('/###(.+?)###/', $contents, $matches)) {
            return [];
        }

        $markers = array_unique($matches[1]);
        asort($markers);

        return $markers;
    }

}
