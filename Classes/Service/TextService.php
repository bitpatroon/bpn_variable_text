<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Sjoerd Zonneveld  <code@bitpatroon.nl>
 *  Date: 6-5-2021 21:38
 *
 *  All rights reserved
 *
 *  This script is part of a Bitpatroon project. The project is
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

namespace BPN\BpnVariableText\Service;

use BPN\BpnVariableText\Domain\Model\VariableText;
use BPN\BpnVariableText\Domain\Repository\VariableTextRepository;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Class \BPN\BpnVariableText\Service\TextService
 * Usage call \BPN\BpnVariableText\Service\TextService::getTextByLabelName(). Will self-instantiate.
 */
class TextService implements SingletonInterface
{
    const PARSEFUNC_PATH = 'lib.variableText_parseFunc_RTE';

    /**
     * @var VariableTextRepository
     */
    protected $variableTextRepository;

    /**
     * @var ContentObjectRenderer
     */
    protected $contentObject;

    /**
     * @var TextService
     */
    protected static $instance;

    /**
     * Object initialization.
     */
    public function initializeObject()
    {
        $this->contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $this->contentObject->start([]);
        // texts can be anywhere on the site, we don't bother. LabelName field is unique anyway...
        $querySettings = new \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings();
        $querySettings->setRespectStoragePage(false);

        /* @var VariableTextRepository $variableTextRepository */
        $this->variableTextRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(VariableTextRepository::class);
        $this->variableTextRepository->setDefaultQuerySettings($querySettings);
    }

    /**
     * Gets variable text by given label. The given markers will be replaced.
     *
     * @param string $labelName
     * @param array  $replaceMarkers
     * @param string $parseFuncTSPath
     *
     * @return string
     */
    protected function getTextByLabelInternal($labelName, $replaceMarkers = [], $parseFuncTSPath = self::PARSEFUNC_PATH)
    {
        /** @var VariableText $variableText */
        $variableText = $this->variableTextRepository->findOneByLabelName($labelName);
        if (!$variableText) {
            throw new \RuntimeException(
                sprintf('Label "%s" not found, add variable text record in database', $labelName), 1619717658
            );
        }

        $contents = $variableText->getContents();
        if (VariableText::FORMATTING_HTML === $variableText->getTextFormatting()) {
            $contents = $this->contentObject->parseFunc($contents, [], '< ' . $parseFuncTSPath);
        }
        $markers = $variableText->getAvailableMarkers() ?? [];
        if (0 == count($markers)) {
            return $contents;
        }
        foreach ($markers as $marker) {
            $markerField = strtolower($marker);
            if (isset($replaceMarkers[$markerField])) {
                $contents = str_replace(
                    sprintf('###%s###', $marker),
                    $replaceMarkers[$markerField],
                    $contents
                );
            } else {
                $contents = str_replace(
                    sprintf('###%s###', $marker),
                    sprintf("[%s]", $markerField),
                    $contents
                );
            }
        }

        return $contents;
    }

    /**
     * Gets variable text by given label. The markers will be replaced.
     *
     * @param string $labelName
     * @param array  $replaceMarkers the markers that will be replaced
     * @param string $parseFuncTSPath
     *
     * @return string
     */
    public static function getTextByLabel($labelName, $replaceMarkers = [], $parseFuncTSPath = self::PARSEFUNC_PATH)
    {
        return self::getInstance()->getTextByLabelInternal($labelName, $replaceMarkers, $parseFuncTSPath);
    }

    /**
     * Gets instance of the text service.
     *
     * @return TextService
     */
    protected static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = GeneralUtility::makeInstance(ObjectManager::class)->get(__CLASS__);
        }

        return self::$instance;
    }
}
