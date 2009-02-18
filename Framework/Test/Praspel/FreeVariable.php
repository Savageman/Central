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
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Praspel_FreeVariable
 *
 */

/**
 * Hoa_Framework
 */
require_once 'Framework.php';

/**
 * Hoa_Test_Praspel_Exception
 */
import('Test.Praspel.Exception');

/**
 * Hoa_Test_Praspel_Type
 */
import('Test.Praspel.Type');

/**
 * Hoa_Test_Urg
 */
import('Test.Urg.~');

/**
 * Class Hoa_Test_Praspel_FreeVariable.
 *
 * .
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2008 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Praspel_FreeVariable
 */

class Hoa_Test_Praspel_FreeVariable {

    /**
     * Free variable name.
     *
     * @var Hoa_Test_Praspel_FreeVariable string
     */
    protected $_name  = null;

    /**
     * Collection of types.
     *
     * @var Hoa_Test_Praspel_FreeVariable array
     */
    protected $_types = array();



    /**
     * Set the free variable name.
     *
     * @access  public
     * @param   string  $name    Free variable name.
     * @return  void
     */
    public function __construct ( $name ) {

        $this->setName($name);

        return;
    }

    /**
     * Set the free variable name.
     *
     * @access  public
     * @param   string  $name    Free variable name.
     * @return  string
     */
    protected function setName ( $name ) {

        $old         = $this->_name;
        $this->_name = $name;

        return $old;
    }

    /**
     * Type the free variable.
     *
     * @access  public
     * @param   string  $name    Type name.
     * @return  Hoa_Test_Urg_Type_Interface_Type
     */
    public function hasType ( $name ) {

        return $this->_types[] = new Hoa_Test_Praspel_Type($name);
    }

    /**
     * Choose one type.
     *
     * @access  public
     * @return  Hoa_Test_Urg_Type_Interface_Type
     */
    public function chooseOneType ( ) {

        return $this->_types[Hoa_Test_Urg::Ud(0, count($this->_types) - 1];
    }
}
