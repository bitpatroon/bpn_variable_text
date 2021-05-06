<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans van der Veen
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

namespace BPN\BpnVariableText\ViewHelpers;

use BPN\BpnVariableText\Service\TextService;
use BPN\BpnVariableText\ViewHelpers\VariableText\MarkerViewHelper;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\EscapingNode;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ViewHelperNode;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Usage:
 * <code title="Variable Text View Helper">
 *    <sl:variableText labelName="label_example" markers="{training_title: 'test'}">
 *        <sl:variableText.marker name="training_personal_information">content 1</sl:variableText.marker>
 *    </sl:variableText>
 * </code>
 * <output>
 *  Will replace ###TRAINING_TITLE### to 'test' and ###TRAINING_PERSONAL_INFORMATION### into 'content 1' in the
 *  label_example record and return the output
 * </output>
 */
class VariableTextViewHelper extends AbstractViewHelper
{
    /**
     * Specifies whether the escaping interceptors should be disabled or enabled for the render-result of this
     * ViewHelper
     *
     * @see isOutputEscapingEnabled()
     *
     * @var boolean
     * @api
     */
    protected $escapeOutput = false;

    /**
     * Constructor
     *
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('labelName', 'string', 'Label name');
        $this->registerArgument(
            'markers',
            'arraw',
            'associative array of marker values, which will be replaced in the given text'
        );
        $this->registerArgument('parseFuncTSPath', 'string', '(parseFunc for RTE texts)');
        $this->registerArgument(
            'blockCommentWrap',
            'string',
            'the construct which will contain the name of the label, for maintenance purposes. Comment will be placed on the \'|\''
        );
    }

    /**
     * Gets variable text by given label
     *
     * @return string
     */
    public function render() : string
    {
        $commentBegin = '';
        $commentEnd = '';
        if (!empty($this->arguments['blockCommentWrap'])) {
            $commentBegin = str_replace(
                '|',
                'variable-text-begin:' . $this->arguments['labelName'],
                $this->arguments['blockCommentWrap']
            );
            $commentEnd = str_replace(
                '|',
                'variable-text-end:' . $this->arguments['labelName'],
                $this->arguments['blockCommentWrap']
            );
        }
        if (count($this->childNodes) > 0) {
            foreach ($this->childNodes as $childNode) {
                if ($this->isMarkerNode($childNode)) {
                    [$markerName, $markerContent] = $childNode->evaluate($this->renderingContext);
                    if (!empty($markerName)) {
                        $this->arguments['markers'][$markerName] = $markerContent;
                    }
                }
            }
        }
        $result = $commentBegin . TextService::getTextByLabel(
                $this->arguments['labelName'],
                $this->arguments['markers'],
                $this->arguments['parseFuncTSPath']
            ) . $commentEnd;

        return $result;
    }

    /**
     * Checks if given node is AccessViewHelper type
     *
     * @param object $childNode
     *
     * @return bool
     */
    protected function isMarkerNode($childNode)
    {
        $result = false;
        if ($childNode instanceof ViewHelperNode) {
            $result = is_a($childNode->getViewHelperClassName(), MarkerViewHelper::class, true);
        } elseif ($childNode instanceof EscapingNode) {
            $result = is_a($childNode->getNode()->getViewHelperClassName(), MarkerViewHelper::class, true);
        }

        return $result;
    }
}
