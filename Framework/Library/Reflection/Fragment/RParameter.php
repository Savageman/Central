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
 */

namespace {

from('Hoa')

/**
 * \Hoa\Reflection\RParameter
 */
-> import('Reflection.RParameter');

}

namespace Hoa\Reflection\Fragment {

/**
 * Class \Hoa\Reflection\Fragment\RParameter.
 *
 * Fragment of a \Hoa\Reflection\RParameter class.
 *
 * @author     Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license    http://gnu.org/licenses/gpl.txt GNU GPL
 */

class RParameter extends \Hoa\Reflection\RParameter {

    /**
     * Reflect a fragment of parameter.
     *
     * @access  public
     * @param   string  $name    Name.
     * @return  void
     */
    public function __construct ( $name ) {

        $this->setName($name);

        return;
    }

    /**
     * Override the ReflectionParameter method.
     *
     * @access  public
     * @return  void
     */
    public function getClass ( ) {

        return null;
    }

    /**
     * Override the ReflectionParameter method.
     *
     * @access  public
     * @return  void
     */
    public function getDeclaringClass ( ) {

        return null;
    }

    /**
     * Override the ReflectionParameter method.
     *
     * @access  public
     * @return  void
     */
    public function getDeclaringFunction ( ) {

        return null;
    }
}

}
