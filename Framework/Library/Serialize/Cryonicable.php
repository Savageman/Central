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
 * @package     Hoa_Serialize
 * @subpackage  Hoa_Serialize_Cryonicable
 *
 */

/**
 * Hoa_Serialize_Serializable
 */
import('Serialize.Serializable');

/**
 * Interface Hoa_Serialize_Cryonicable.
 *
 * Force to implement __wakeup() and __sleep() method, in addition to the
 * serialize common methods.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Serialize
 * @subpackage  Hoa_Serialize_Cryonicable
 */

interface Hoa_Serialize_Cryonicable extends Hoa_Serialize_Serializable {

    /**
     * Try to reestablish the object statement and behavior before it is slept.
     *
     * @access  public
     * @return  void
     */
    public function __wakeup ( );

    /**
     * Commit pending data or perform similar cleanup tasks.
     * This method should return an array of object attributes that not being
     * serialized. If null is returned, an error will occurred.
     * A trivial complete workaround should be:
     *     return array_keys(get_object_vars($this));
     *
     * @access  public
     * @return  mixed
     */
    public function __sleep ( );
}
