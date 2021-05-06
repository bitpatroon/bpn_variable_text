<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Sjoerd Zonneveld  <code@bitpatroon.nl>
 *  Date: 29-4-2021 19:38
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

$translationFile = 'LLL:EXT:bpn_variable_text/Resources/Private/Language/locallang_backend.xlf';

return [
    'ctrl'      => [
        'title'         => $translationFile . ':tx_bpnvariabletext_domain_model_variabletext',
        'label'         => 'label_name',
        'tstamp'        => 'tstamp',
        'crdate'        => 'crdate',
        'delete'        => 'deleted',
        'type'          => 'text_formatting',
        'searchFields'  => 'description,label_name,contents,markers',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile'      => 'EXT:bpn_variable_text/ext_icon.png',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, label_name, description',
    ],
    'columns'   => [
        'hidden'          => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config'  => [
                'type' => 'check',
            ],
        ],
        'text_formatting' => [
            'exclude' => 0,
            'label'   => $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.text_formatting',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    [
                        $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.text_formatting.I.1',
                        '1',
                    ],
                    [
                        $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.text_formatting.I.2',
                        '2',
                    ],
                ]
            ],
        ],
        'description'     => [
            'exclude' => 1,
            'label'   => $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.description',
            'config'  => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 80
            ],
        ],
        'label_name'      => [
            'exclude' => 0,
            'label'   => $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.label_name',
            'config'  => [
                'type' => 'input',
                'size' => 80,
                'eval' => 'trim,required',
            ],
        ],
        'plaintext'       => [
            'exclude' => 1,
            'label'   => $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.plaintext',
            'config'  => [
                'type' => 'text',
                'rows' => 10,
                'cols' => 80,
                'eval' => 'trim',
            ],
        ],
        'html'            => [
            'exclude' => 1,
            'label'   => $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.html',
            'config'  => [
                'type'           => 'text',
                'rows'           => 10,
                'cols'           => 80,
                'eval'           => 'trim',
                'enableRichtext' => 1
            ],
        ],
        'markers'         => [
            'exclude' => 1,
            'label'   => $translationFile . ':tx_bpnvariabletext_domain_model_variabletext.markers',
            'config'  => [
                'type'       => 'user',
                'renderType' => 'variableTextControl'
            ],
        ],
    ],
    'types'     => [
        '1' => ['showitem' => 'hidden,text_formatting,label_name,description,plaintext,markers'],
        '2' => ['showitem' => 'hidden,text_formatting,label_name,description,html,markers'],
    ],
    'palettes'  => [
        '1' => ['showitem' => ''],
    ],
];
