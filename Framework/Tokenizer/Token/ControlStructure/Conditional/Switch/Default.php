<?php

/**
 * Hoa Framework
 *
 *
 * @license
 *
 * GNU General Public License
 *
 * This file is part of Hoa Open Accessibility.
 * Copyright (c) 2007, 2008 Ivan ENDERLIN. All rights reserved.
 *
 * HOA Open Accessibility is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * HOA Open Accessibility is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HOA Open Accessibility; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *
 * @category    Framework
 * @package     Hoa_Tokenizer
 * @subpackage  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default
 *
 */

/**
 * Hoa_Framework
 */
require_once 'Framework.php';

/**
 * Hoa_Tokenizer_Token_Util_Exception
 */
import('Tokenizer.Token.Util.Exception');

/**
 * Hoa_Tokenizer_Token_Util_Interface_Tokenizable
 */
import('Tokenizer.Token.Util.Interface.Tokenizable');

/**
 * Hoa_Tokenizer
 */
import('Tokenizer.~');

/**
 * Hoa_Tokenizer_Token_Instruction_Block
 */
import('Tokenizer.Token.Instruction.Block');

/**
 * Class Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default.
 *
 * .
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2008 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Tokenizer
 * @subpackage  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default
 */

class          Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default
    extends    Hoa_Tokenizer_Token_Instruction_Block
    implements Hoa_Tokenizer_Token_Util_Interface_Tokenizable {

    /**
     * Constructor.
     *
     * @access  public
     * @param   mixed   $instructions    One or more instructions.
     * @return  void
     */
    public function __construct ( $instructions = array() ) {

        parent::setBracesMode(parent::SKIP_BRACES);
        parent::setEmptyMode(parent::NOTHING_EMPTY);

        return parent::__construct($instructions);
    }

    /**
     * Transform token to “tokenizer array”.
     *
     * @access  public
     * @return  array
     */
    public function tokenize ( ) {

        return array_merge(
            array(array(
                0 => Hoa_Tokenizer::_DEFAULT,
                1 => 'default',
                2 => -1
            )),
            array(array(
                0 => Hoa_Tokenizer::_COLON,,
                1 => ':',
                2 => -1
            )),
            parent::tokenize()
        );
    }
}
