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
 * @subpackage  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch
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
 * Hoa_Tokenizer
 */
import('Tokenizer.~');

/**
 * Hoa_Tokenizer_Token_ControlStructure_Conditional
 */
import('Tokenizer.Token.ControlStructure.Conditional');

/**
 * Class Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch.
 *
 * .
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2008 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Tokenizer
 * @subpackage  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch
 */

class       Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch
    extends Hoa_Tokenizer_Token_ControlStructure_Conditional {

    /**
     * Expression to test.
     *
     * @var mixed object
     */
    protected $_expression = null;

    /**
     * Collection of cases.
     *
     * @var Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch array
     */
    protected $_cases      = array();

    /**
     * Default case.
     *
     * @var Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default object
     */
    protected $_default    = null;



    /**
     * Constructor.
     *
     * @access  public
     * @param   mixed   $expression    Expression.
     * @return  void
     */
    public function __construct ( $expression ) {

        $this->setExpression($expression);

        return;
    }

    /**
     * Set expression.
     *
     * @access  public
     * @param   mixed   $expression    Expression.
     * @return  mixed
     */
    public function setExpression ( $expression) {

        switch(get_class($expression)) {

            case 'Hoa_Tokenizer_Token_Array':
            case 'Hoa_Tokenizer_Token_Call':
            case 'Hoa_Tokenizer_Token_Cast':
            case 'Hoa_Tokenizer_Token_Clone':
            case 'Hoa_Tokenizer_Token_Comment':
            case 'Hoa_Tokenizer_Token_New':
            case 'Hoa_Tokenizer_Token_Number':
            case 'Hoa_Tokenizer_Token_Operation':
            case 'Hoa_Tokenizer_Token_String':
            case 'Hoa_Tokenizer_Token_Variable':
              break;

            default:
                throw new Hoa_Tokenizer_Token_Util_Exception(
                    'An expression cannot be constitued by a class that ' .
                    'is an instance of %s.', 0, get_class($expression));
        }

        $old               = $old;
        $this->_expression = $expression;

        return $old;
    }

    /**
     * Add many cases.
     *
     * @access  public
     * @param   array   $cases    Cases to add.
     * @return  array
     */
    public function addCases ( Array $cases = array() ) {

        foreach($cases as $i => $case)
            $this->addCase($case);

        return $this->_cases;
    }

    /**
     * Add a case.
     *
     * @access  public
     * @param   Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Case  $case    Case to add.
     * @return  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Case
     */
    public function addCase ( Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Case $case ) {

        return $this->_cases[] = $case;
    }

    /**
     * Remove all cases.
     *
     * @access  public
     * @return  array
     */
    public function removeCases ( ) {

        $old = $this->_cases;

        foreach($this->_cases as $i => $case)
            unset($this->_cases[$i]);

        return $old;
    }

    /**
     * Remove a case.
     *
     * @access  public
     * @param   int     $i    Case number.
     * @return  array
     */
    public function removeCase ( $i ) {

        unset($this->_cases[$i]);

        return $this->_cases;
    }

    /**
     * Set default.
     *
     * @access  public
     * @param   Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default  $default    Default case.
     * @return  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default
     */
    public function setDefault ( Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default  $default ) {

        $old            = $this->_default;
        $this->_default = $default;

        return $old;
    }

    /**
     * Remove default.
     *
     * @access  public
     * @return  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default
     */
    public function removeDefault ( ) {

        $old            = $this->_default;
        $this->_default = null;

        return $old;
    }

    /**
     * Get expression.
     *
     * @access  public
     * @return  mixed
     */
    public function getExpression ( ) {

        return $this->_expression;
    }

    /**
     * Get all cases.
     *
     * @access  public
     * @return  array
     */
    public function getCases ( ) {

        return $this->_cases;
    }

    /**
     * Get a case.
     *
     * @access  public
     * @param   int     $i    Case number.
     * @return  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Case
     * @throw   Hoa_Tokenizer_Token_Util_Exception
     */
    public function getCase ( $i ) {

        if(!isset($this->_cases[$i]))
            throw new Hoa_Tokenizer_Token_Util_Exception(
                'Case number %s does not exist.', 0, $i);

        return $this->_cases[$i];
    }

    /**
     * Check if somes cases are declared.
     *
     * @access  public
     * @return  bool
     */
    public function hasCase ( ) {

        return $this->_cases != array();
    }

    /**
     * Get default.
     *
     * @access  public
     * @return  Hoa_Tokenizer_Token_ControlStructure_Conditional_Switch_Default
     */
    public function getDefault ( ) {

        return $this->_default;
    }

    /**
     * Check if a default case exists.
     *
     * @access  public
     * @return  bool
     */
    public function hasDefault ( ) {

        return $this->_default !== null;
    }

    /**
     * Transform token to “tokenizer array”.
     *
     * @access  public
     * @return  array
     */
    public function tokenize ( ) {

        $expression  = $this->getExpression()->tokenize();
        $cases       = array();

        foreach($this->getCases() as $i => $case)
            $cases[] = $case->tokenize();

        $default     = true === $this->hasDefault()
                           ? $this->getDefault()->tokenize()
                           : array();

        return array_merge(
            array(array(
                0 => Hoa_Tokenizer::_SWITCH,
                1 => 'switch',
                2 => -1
            )),
            array(array(
                0 => Hoa_Tokenizer::_OPEN_PARENTHESES,
                1 => '(',
                2 => -1
            )),
            $expression,
            array(array(
                0 => Hoa_Tokenizer::_CLOSE_PARENTHESES,
                1 => ')',
                2 => -1
            )),
            array(array(
                0 => Hoa_Tokenizer::_OPEN_BRACE,
                1 => '{',
                2 => -1
            )),
            $cases,
            $default,
            array(array(
                0 => Hoa_Tokenizer::_CLOSE_BRACE,
                1 => '}',
                2 => -1
            )),
        );
    }
}
