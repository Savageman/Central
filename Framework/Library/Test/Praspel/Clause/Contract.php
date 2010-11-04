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
 * Copyright (c) 2007, 2010 Ivan ENDERLIN. All rights reserved.
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
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Praspel_Clause_Contract
 *
 */

/**
 * Hoa_Core
 */
require_once 'Core.php';

/**
 * Hoa_Test_Praspel_Exception
 */
import('Test.Praspel.Exception');

/**
 * Hoa_Test_Praspel_Clause
 */
import('Test.Praspel.Clause') and load();

/**
 * Hoa_Test_Praspel_Variable
 */
import('Test.Praspel.Variable');

/**
 * Hoa_Test_Praspel_Constructor_Old
 */
import('Test.Praspel.Constructor.Old');

/**
 * Hoa_Test_Praspel_Constructor_Result
 */
import('Test.Praspel.Constructor.Result');

/**
 * Class Hoa_Test_Praspel_Clause_Contract.
 *
 * .
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Praspel_Clause_Contract
 */

abstract class Hoa_Test_Praspel_Clause_Contract implements Hoa_Test_Praspel_Clause {

    /**
     * Parent (here: the root).
     *
     * @var Hoa_Test_Praspel_Contract object
     */
    protected $_parent    = null;

    /**
     * Collection of variables.
     *
     * @var Hoa_Test_Praspel_Clause_Contract array
     */
    protected $_variables = array();



    /**
     * Constructor.
     *
     * @access  public
     * @param   Hoa_Test_Praspel_Contract  $parent    Parent (here: the root).
     * @return  void
     */
    public function __construct ( Hoa_Test_Praspel_Contract $parent ) {

        $this->setParent($parent);

        return;
    }

    /**
     * Declare a variable, or get it.
     *
     * @access  public
     * @param   string  $name    Variable name.
     * @return  Hoa_Test_Praspel_Variable
     */
    public function variable ( $name ) {

        if(true === $this->variableExists($name))
            return $this->_variables[$name];

        if(0 !== preg_match('#\\\old\(\s*(\w+)\s*\)#i', $name, $matches))
            return $this->_variables[$name] = new Hoa_Test_Praspel_Constructor_Old(
                $this,
                $matches[1]
            );
        elseif($name == '\result')
            return $this->_variables[$name] = new Hoa_Test_Praspel_Constructor_Result(
                $this,
                $name
            );

        return $this->_variables[$name] = new Hoa_Test_Praspel_Variable(
            $this,
            $name
        );
    }

    /**
     * Check if a variable already exists or not.
     *
     * @access  public
     * @param   string  $name    Variable name.
     * @return  Hoa_Test_Praspel_Variable
     */
    public function variableExists ( $name ) {

        return true === array_key_exists($name, $this->getVariables());
    }

    /**
     * Get a specific variable.
     *
     * @access  public
     * @param   string  $name    Variable name.
     * @return  Hoa_Test_Praspel_Variable
     * @throw   Hoa_Test_Praspel_Exception
     */
    public function getVariable ( $name ) {

        if(false === $this->variableExists($name))
            throw new Hoa_Test_Praspel_Exception(
                'Variable %s is not found.', 0, $name);

        return $this->_variables[$name];
    }

    /**
     * Get all variables.
     *
     * @access  public
     * @return  array
     */
    public function getVariables ( ) {

        return $this->_variables;
    }

    /**
     * Set the parent (here: the root).
     *
     * @access  protected
     * @param   Hoa_Test_Praspel_Contract  $parent    Parent (here: the root).
     * @return  Hoa_Test_Praspel_Contract
     */
    protected function setParent ( Hoa_Test_Praspel_Contract $parent ) {

        $old           = $this->_parent;
        $this->_parent = $parent;

        return $old;
    }

    /**
     * Get the parent (here: the root).
     *
     * @access  public
     * @return  Hoa_Test_Praspel_Contract
     */
    public function getParent ( ) {

        return $this->_parent;
    }

    /**
     * Transform this object model into Praspel.
     *
     * @access  public
     * @return  string
     */
    public function __toPraspel ( ) {

        $gc     = get_class($this);
        $out    = sprintf(
                      '%-11s',
                      '@' . strtolower(substr($gc, strrpos($gc, '_') + 1))
                  );
        $handle = array();

        foreach($this->getVariables() as $i => $variable)
            $handle[] = $variable->__toPraspel();

        return $out . implode("\n" . '       and ', $handle) . ";\n";
    }

    /**
     * Transform this object model into a string.
     *
     * @access  public
     * @return  string
     */
    public function __toString ( ) {

        $gc     = get_class($this);
        $out    = '$contract' . "\n" .
                  '    ->clause(\'' .
                       strtolower(substr($gc, strrpos($gc, '_') + 1)) .
                      '\')' . "\n";
        $handle = array();

        foreach($this->getVariables() as $i => $variable)
            $handle[] = $variable->__toString();

        return $out . implode('    ->_and' . "\n", $handle) . ';';
    }
}
