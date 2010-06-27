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
 * @subpackage  Hoa_Test_Urg_Type_Null
 *
 */

/**
 * Hoa_Core
 */
require_once 'Core.php';

/**
 * Hoa_Test_Urg_Type_Exception
 */
import('Test.Urg.Type.Exception');

/**
 * Hoa_Test_Urg_Undefined
 */
import('Test.Urg.Type.Undefined');

/**
 * Hoa_Test_Urg
 */
import('Test.Urg.~');

/**
 * Class Hoa_Test_Urg_Type_Null.
 *
 * Represent a null value.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Urg_Type_Null
 */

class Hoa_Test_Urg_Type_Null extends Hoa_Test_Urg_Type_Undefined {

    /**
     * Name of type.
     *
     * @var Hoa_Test_Urg_Type_Interface_Type string
     */
    protected $_name  = 'null';

    /**
     * Random value.
     *
     * @var Hoa_Test_Urg_Type_Null null
     */
    protected $_value = null;



    /**
     * Constructor.
     *
     * @access  public
     * @return  void
     */
    public function __construct ( ) {

        return;
    }

    /**
     * A predicate.
     *
     * @access  public
     * @param   mixed   $q    Q-value.
     * @return  bool
     */
    public function predicate ( $q = null ) {

        return null === $q;
    }

    /**
     * Choose a random value.
     *
     * @access  public
     * @return  void
     */
    public function randomize ( ) {

        return;
    }

    /**
     * Get the random value.
     *
     * @access  protected
     * @return  null
     */
    public function getValue ( ) {

        return null;
    }
}
