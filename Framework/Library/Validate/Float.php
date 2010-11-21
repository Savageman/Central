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
 * @package     Hoa_Validate
 * @subpackage  Hoa_Validate_Float
 *
 */

/**
 * Hoa_Validate_Abstract
 */
import('Validate.Abstract');

/**
 * Class Hoa_Validate_Float.
 *
 * Validate a data, should be an float.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Validate
 * @subpackage  Hoa_Validate_Float
 */

class Hoa_Validate_Float extends Hoa_Validate_Abstract {

    /**
     * Is not float.
     *
     * @const string
     */
    const IS_NOT_FLOAT = 'isNotFloat';

    /**
     * Errors messages
     *
     * @var Hoa_Validate_Abstract array
     */
    protected $errors = array(
        self::IS_NOT_FLOAT => 'Data could be a float number, given %s.'
    );



    /**
     * Check if a data is valid.
     *
     * @access  public
     * @param   string  $data    Data to valid.
     * @return  bool
     * @throw   Hoa_Validate_Exception
     */
    public function isValid ( $data = null ) {

        //if(false === ctype_digit($data)) {
        if(0 === preg_match('#^[0-9\.]+$#', (string) $data)) {

            $this->addOccuredError(self::IS_NOT_FLOAT, $data);

            return false;
        }

        return true;
    }
}
