<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Sjoerd Zonneveld  <code@bitpatroon.nl>
 *  Date: 29-4-2021 19:39
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

namespace BPN\BpnVariableText\Backend\UserFunction;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class VariableText extends AbstractFormElement
{
    public function render() : array
    {
        $row = $this->data['databaseRow'];

        $formatting = $row['text_formatting'];
        if(is_array($formatting)){
            $formatting = current($formatting);
        }

        switch ((int)$formatting) {
            case 1:
                $content = $row['plaintext'];
                break;
            case 2:
                $content = $row['html'];
                break;
            default:
                $content = '';
                break;
        }

        if (!$content) {
            return [];
        }

        $markers = $this->getMarkers($content);

        $this->data['databaseRow']['markers'] = implode(',', $markers);

        $markerText = 'Geen markers gevonden';
        if ($markers) {
            $markerText = sprintf('<li>%s</li>', implode('</li><li>', $markers));
        }

        $result = $this->initializeResultArray();
        $result['html'] = $markerText;

        return $result;
    }

    private function getMarkers(string $contents)
    {
        if (!preg_match_all('/###(.+?)###/', $contents, $matches)) {
            return [];
        }

        $markers = array_unique($matches[1]);
        asort($markers);

        return $markers;
    }

}
