<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(
    function () {
        if (TYPO3_MODE === 'BE') {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1619622485] = [
                'nodeName' => 'variableTextControl',
                'priority' => 90,
                'class'    => \BPN\BpnVariableText\Backend\UserFunction\VariableText::class,
            ];
        }
    }
);