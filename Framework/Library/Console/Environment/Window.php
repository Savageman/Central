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
 * \Hoa\Console\Environment\Exception
 */
-> import('Console.Environment.Exception')

/**
 * \Hoa\Console\System
 */
-> import('Console.System.~');

}

namespace Hoa\Console\Environment {

/**
 * Class \Hoa\Console\Environment\Window.
 *
 * Get some informations about the window (i.e. the terminal).
 *
 * @author     Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license    http://gnu.org/licenses/gpl.txt GNU GPL
 */

class Window {

    /**
     * Obtain data from the window environment.
     *
     * @access  public
     * @param   string  $data    Data to get.
     * @return  mixed
     * @throw   \Hoa\Console\Environment\Exception
     */
    public static function get ( $data ) {

        switch($data) {

            case 'columns':
                return self::getColumns();
              break;

            case 'lines':
                return self::getLines();
              break;

            default:
                throw new Exception(
                    'Given an unidentified data : %s.', 0, $data);
        }
    }

    /**
     * Get columns number, i.e. the window width.
     *
     * @access  public
     * @return  int
     * @throw   \Hoa\Console\System\Exception
     */
    public static function getColumns ( ) {

        if(OS_WIN) {

            $modecon = \Hoa\Console\System::execute('mode con');
            $modecon = explode("\n", trim($modecon));
            $width   = trim($modecon[3]);
            preg_match('#.*?\s*:\s*([0-9]+)#', $width, $matches);
            $out     = (int) $matches[1];
        }
        else {

            $out     = (int) trim(\Hoa\Console\System::execute('echo $COLUMNS'));

            if(empty($out)) {

                $out   = trim(\Hoa\Console\System::execute('stty -a'));
                $regex = '#(?:;\s+(?P<c>[0-9]+)\s+columns;)|(?:;\s+columns\s+(?P<d>[0-9]+);)#';

                if(false !== preg_match($regex, $out, $match))
                    $out = isset($match['c']) ? $match['c'] : $match['d'];
            }
        }

        if(empty($out))
            $out = 80;

        return $out;
    }

    /**
     * Get lines number, i.e. the window height.
     *
     * @access  public
     * @return  int
     * @throw   \Hoa\Console\System\Exception
     */
    public static function getLines ( ) {

        if(OS_WIN) {

            $modecon = \Hoa\Console\System::execute('mode con');
            $modecon = explode("\n", trim($modecon));
            $width   = trim($modecon[2]);
            preg_match('#.*?\s*:\s*([0-9]+)#', $width, $matches);
            $out     = (int) $matches[1];
        }
        else {

            $out     = (int) trim(\Hoa\Console\System::execute('echo $LINES'));

            if(empty($out)) {

                $out   = trim(\Hoa\Console\System::execute('stty -a'));
                $regex = '#(?:;\s+(?P<r>[0-9]+)\s+rows;)|(?:;\s+rows\s+(?P<s>[0-9]+);)#';

                if(false !== preg_match($regex, $out, $match))
                    $out = isset($match['r']) ? $match['r'] : $match['s'];
            }
        }

        if(empty($out))
            $out = 120;

        return $out;
    }
}

}
