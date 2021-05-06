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

namespace BPN\BpnVariableText\ViewHelpers\VariableText;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class MarkerViewHelper extends AbstractViewHelper
{
    /**
     * Constructor.
     *
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'Marker name');
    }

    /**
     * Renders the output.
     */
    public function render(): array
    {
        return [$this->arguments['name'], $this->renderChildren()];
    }
}
