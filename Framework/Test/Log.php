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
 * @subpackage  Hoa_Test_Log
 *
 */

/**
 * Hoa_Framework
 */
require_once 'Framework.php';

/**
 * Hoa_Test_Exception
 */
import('Test.Exception');

/**
 * Class Hoa_Test_Log.
 *
 * .
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2008 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Log
 */

class Hoa_Test_Log {

    /**
     * Test succeed.
     *
     * @const bool
     */
    const TEST_SUCCEED = true;

    /**
     * Test failed.
     *
     * @const bool
     */
    const TEST_FAILED  = false;

    /**
     * Logs.
     *
     * @var Hoa_Test_Log array
     */
    protected static $_logs = array();

    /**
     * Last entry index.
     *
     * @var Hoa_Test_Log array
     */
    protected static $_i    = -1;



    /**
     * New entry.
     *
     * @access  public
     * @return  int
     */
    public static function newEntry ( ) {

        return ++self::$_i;
    }

    /**
     * Add a message.
     *
     * @access  public
     * @param   string  $info       Information name.
     * @param   string  $message    Message.
     * @return  array
     */
    public static function write ( $info, $message ) {

        return self::$_logs[self::$_i][$info] = $message;
    }

    /**
     * Transform object to string.
     *
     * @access  public
     * @return  string
     */
    public static function __toString ( ) {

        $out = null;

        foreach(self::$_logs as $i => $logs) {

            foreach($logs as $info => $message)
                $out .= $message . "\n";

            $out .= "\n\n";
        }
    }
}
