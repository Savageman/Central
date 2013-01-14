<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2013, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoa\Console {

/**
 * Class \Hoa\Console\Cursor.
 *
 * Allow to manipulate the cursor:
 *     • move;
 *     • moveTo;
 *     • save;
 *     • restore;
 *     • clear;
 *     • scroll;
 *     • hide;
 *     • show;
 *     • getPosition;
 *     • setStyle;
 *     • colorize;
 *     • changeColor;
 *     • bip.
 * Please, see C0 and C1 control codes.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

class Cursor {

    /**
     * Move the cursor.
     * Steps can be:
     *     • u, up,    ↑ : move to the previous line;
     *     • U, UP       : move to the first line;
     *     • r, right, → : move to the next column;
     *     • R, RIGHT    : move to the last column;
     *     • d, down,  ↓ : move to the next line;
     *     • D, DOWN     : move to the last line;
     *     • l, left,  ← : move to the previous column;
     *     • L, LEFT     : move to the first column.
     * Steps can be concatened by a single space if $repeat is equal to 1.
     *
     * @access  public
     * @param   string  $steps     Steps.
     * @param   int     $repeat    How many times do we move?
     * @return  void
     */
    public static function move ( $steps, $repeat = 1 ) {

        if(OS_WIN)
            return;

        if(1 > $repeat)
            return;
        elseif(1 === $repeat)
            $handle = explode(' ', $steps);
        else
            $handle = explode(' ', $steps, 1);

        foreach($handle as $step)
            switch($step) {

                // CUU.
                case 'u':
                case 'up':
                case '↑':
                    echo "\033[" . $repeat . 'A';
                  break;

                case 'U':
                case 'UP':
                    static::moveTo(null, 1);
                  break;

                // CUF.
                case 'r':
                case 'right':
                case '→':
                    echo "\033[" . $repeat . 'C';
                  break;

                case 'R':
                case 'RIGHT':
                    static::moveTo(9999);
                  break;

                // CUD.
                case 'd':
                case 'down':
                case '↓':
                    echo "\033[" . $repeat . 'B';
                  break;

                case 'D':
                case 'DOWN':
                    static::moveTo(null, 9999);
                  break;

                // CUB.
                case 'l':
                case 'left':
                case '←':
                    echo "\033[" . $repeat . 'D';
                  break;

                case 'L':
                case 'LEFT':
                    static::moveTo(1);
                  break;
            }

        return;
    }

    /**
     * Move to the line X and the column Y.
     * If null, use the current coordinate.
     *
     * @access  public
     * @param   int  $x    X coordinate.
     * @param   int  $y    Y coordinate.
     * @return  void
     */
    public static function moveTo ( $x = null, $y = null ) {

        if(OS_WIN)
            return;

        if(null === $x || null === $y) {

            $position = static::getPosition();

            if(null === $x)
                $x = $position['x'];

            if(null === $y)
                $y = $position['y'];
        }

        // CUP.
        echo "\033[" . $y . ";" . $x . "H";

        return;
    }

    /**
     * Save current position.
     *
     * @access  public
     * @return  void
     */
    public static function save ( ) {

        if(OS_WIN)
            return;

        // SCP.
        echo "\033[s";

        return;
    }

    /**
     * Restore cursor to the last saved position.
     *
     * @access  public
     * @return  void
     */
    public static function restore ( ) {

        if(OS_WIN)
            return;

        // RCP.
        echo "\033[u";

        return;
    }

    /**
     * Clear the screen.
     * Part can be:
     *     • a, all,   ↕ : clear entire screen and static::move(1, 1);
     *     • u, up,    ↑ : clear from cursor to beginning of the screen;
     *     • r, right, → : clear from cursor to the end of the line;
     *     • d, down,  ↓ : clear from cursor to end of the screen;
     *     • l, left,  ← : clear from cursor to beginning of the screen;
     *     •    line,  ↔ : clear all the line and static::move(1).
     * Parts can be concatenated by a single space.
     *
     * @access  public
     * @param   string  $parts    Parts to clean.
     * @return  void
     */
    public static function clear ( $parts = 'all' ) {

        if(OS_WIN)
            return;

        foreach(explode(' ', $parts) as $part)
            switch($part) {

                // ED.
                case 'a':
                case 'all':
                case '↕':
                    echo "\033[2J";
                    static::moveTo(1, 1);
                  break;

                // ED.
                case 'u':
                case 'up':
                case '↑':
                    echo "\033[1J";
                  break;

                // EL.
                case 'r':
                case 'right':
                case '→':
                    echo "\033[0K";
                  break;

                // ED.
                case 'd':
                case 'down':
                case '↓':
                    echo "\033[0J";
                  break;

                // EL.
                case 'l':
                case 'left':
                case '←':
                    echo "\033[1K";
                  break;

                // EL.
                case 'line':
                case '↔':
                    echo "\r\033[K";
                  break;
            }

        return;
    }

    /**
     * Scroll whole page.
     * Directions can be:
     *     • u, up,    ↑ : scroll whole page up;
     *     • d, down,  ↓ : scroll whole page down.
     * Directions can be concatenated by a single space.
     *
     * @access  public
     * @param   string  $directions    Directions.
     * @reutrn  void
     */
    public static function scroll ( $directions ) {

        if(OS_WIN)
            return;

        $handle = array('up' => 0, 'down' => 0);

        foreach(explode(' ', $directions) as $direction)
            switch($direction) {

                case 'u':
                case 'up':
                case '↑':
                    ++$handle['up'];
                  break;

                case 'd':
                case 'down':
                case '↓':
                    ++$handle['down'];
                  break;
            }

        if(0 < $handle['up'])
            // SU.
            echo "\033[" . $handle['up'] . "S";

        if(0 < $handle['down'])
            // SD.
            echo "\033[" . $handle['up'] . "T";

        return;
    }

    /**
     * Hide the cursor.
     *
     * @access  public
     * @return  void
     */
    public static function hide ( ) {

        if(OS_WIN)
            return;

        // DECTCEM.
        echo "\033[?25l";

        return;
    }

    /**
     * Show the cursor.
     *
     * @access  public
     * @return  void
     */
    public static function show ( ) {

        if(OS_WIN)
            return;

        // DECTCEM.
        echo "\033[?25h";

        return;
    }

    /**
     * Get current position (x and y) of the cursor.
     *
     * @access  public
     * @return  array
     */
    public static function getPosition ( ) {

        if(OS_WIN)
            return;

        // DSR.
        echo "\033[6n";

        // Read \033[y;xR.
        fread(STDIN, 2); // skip \033 and [.

        $x      = null;
        $y      = null;
        $handle = &$y;

        do {

            $char = fread(STDIN, 1);

            switch($char) {

                case ';':
                    $handle = &$x;
                  break;

                case 'R':
                    break 2;

                default:
                    $handle .= $char;
            }

        } while(true);

        return array(
            'x' => (int) $x,
            'y' => (int) $y
        );
    }

    /**
     * Colorize cursor.
     * Attributes can be:
     *     •  n,         normal           : normal;
     *     •  b,         bold             : bold;
     *     •  u,         underlined       : underlined;
     *     •  bl,        blink            : blink;
     *     •  i,         inverse          : inverse;
     *     • !b,        !bold             : normal weight;
     *     • !u,        !underlined       : not underlined;
     *     • !bl,       !blink            : steady;
     *     • !i,        !inverse          : positive;
     *     • fg(color), foreground(color) : set foreground to “color”;
     *     • bg(color), background(color) : set background to “color”.
     * “color” can be:
     *     • default;
     *     • black;
     *     • red;
     *     • green;
     *     • yellow;
     *     • blue;
     *     • magenta;
     *     • cyan;
     *     • white;
     *     • 0-256 (classic palette);
     *     • #hexa.
     * Attributes can be concatenated by a single space.
     *
     * @access  public
     * @param   string  $attributes    Attributes.
     * @return  void
     */
    public static function colorize ( $attributes ) {

        if(OS_WIN)
            return;

        static $_rgbTo256 = null;

        if(null === $_rgbTo256)
            $_rgbTo256 = array(
                '000000', '800000', '008000', '808000', '000080', '800080',
                '008080', 'c0c0c0', '808080', 'ff0000', '00ff00', 'ffff00',
                '0000ff', 'ff00ff', '00ffff', 'ffffff', '000000', '00005f',
                '000087', '0000af', '0000d7', '0000ff', '005f00', '005f5f',
                '005f87', '005faf', '005fd7', '005fff', '008700', '00875f',
                '008787', '0087af', '0087d7', '0087ff', '00af00', '00af5f',
                '00af87', '00afaf', '00afd7', '00afff', '00d700', '00d75f',
                '00d787', '00d7af', '00d7d7', '00d7ff', '00ff00', '00ff5f',
                '00ff87', '00ffaf', '00ffd7', '00ffff', '5f0000', '5f005f',
                '5f0087', '5f00af', '5f00d7', '5f00ff', '5f5f00', '5f5f5f',
                '5f5f87', '5f5faf', '5f5fd7', '5f5fff', '5f8700', '5f875f',
                '5f8787', '5f87af', '5f87d7', '5f87ff', '5faf00', '5faf5f',
                '5faf87', '5fafaf', '5fafd7', '5fafff', '5fd700', '5fd75f',
                '5fd787', '5fd7af', '5fd7d7', '5fd7ff', '5fff00', '5fff5f',
                '5fff87', '5fffaf', '5fffd7', '5fffff', '870000', '87005f',
                '870087', '8700af', '8700d7', '8700ff', '875f00', '875f5f',
                '875f87', '875faf', '875fd7', '875fff', '878700', '87875f',
                '878787', '8787af', '8787d7', '8787ff', '87af00', '87af5f',
                '87af87', '87afaf', '87afd7', '87afff', '87d700', '87d75f',
                '87d787', '87d7af', '87d7d7', '87d7ff', '87ff00', '87ff5f',
                '87ff87', '87ffaf', '87ffd7', '87ffff', 'af0000', 'af005f',
                'af0087', 'af00af', 'af00d7', 'af00ff', 'af5f00', 'af5f5f',
                'af5f87', 'af5faf', 'af5fd7', 'af5fff', 'af8700', 'af875f',
                'af8787', 'af87af', 'af87d7', 'af87ff', 'afaf00', 'afaf5f',
                'afaf87', 'afafaf', 'afafd7', 'afafff', 'afd700', 'afd75f',
                'afd787', 'afd7af', 'afd7d7', 'afd7ff', 'afff00', 'afff5f',
                'afff87', 'afffaf', 'afffd7', 'afffff', 'd70000', 'd7005f',
                'd70087', 'd700af', 'd700d7', 'd700ff', 'd75f00', 'd75f5f',
                'd75f87', 'd75faf', 'd75fd7', 'd75fff', 'd78700', 'd7875f',
                'd78787', 'd787af', 'd787d7', 'd787ff', 'd7af00', 'd7af5f',
                'd7af87', 'd7afaf', 'd7afd7', 'd7afff', 'd7d700', 'd7d75f',
                'd7d787', 'd7d7af', 'd7d7d7', 'd7d7ff', 'd7ff00', 'd7ff5f',
                'd7ff87', 'd7ffaf', 'd7ffd7', 'd7ffff', 'ff0000', 'ff005f',
                'ff0087', 'ff00af', 'ff00d7', 'ff00ff', 'ff5f00', 'ff5f5f',
                'ff5f87', 'ff5faf', 'ff5fd7', 'ff5fff', 'ff8700', 'ff875f',
                'ff8787', 'ff87af', 'ff87d7', 'ff87ff', 'ffaf00', 'ffaf5f',
                'ffaf87', 'ffafaf', 'ffafd7', 'ffafff', 'ffd700', 'ffd75f',
                'ffd787', 'ffd7af', 'ffd7d7', 'ffd7ff', 'ffff00', 'ffff5f',
                'ffff87', 'ffffaf', 'ffffd7', 'ffffff', '080808', '121212',
                '1c1c1c', '262626', '303030', '3a3a3a', '444444', '4e4e4e',
                '585858', '606060', '666666', '767676', '808080', '8a8a8a',
                '949494', '9e9e9e', 'a8a8a8', 'b2b2b2', 'bcbcbc', 'c6c6c6',
                'd0d0d0', 'dadada', 'e4e4e4', 'eeeeee'
            );

        $handle = array();

        foreach(explode(' ', $attributes) as $attribute) {

            switch($attribute) {

                case 'n':
                case 'normal':
                    $handle[] = 0;
                  break;

                case 'b':
                case 'bold':
                    $handle[] = 1;
                  break;

                case 'u':
                case 'underlined':
                    $handle[] = 4;
                  break;

                case 'bl':
                case 'blink':
                    $handle[] = 5;
                  break;

                case 'i':
                case 'inverse':
                    $handle[] = 7;
                  break;

                case '!b':
                case '!bold':
                    $handle[] = 22;
                  break;

                case '!u':
                case '!underlined':
                    $handle[] = 24;
                  break;

                case '!bl':
                case '!blink':
                    $handle[] = 25;
                  break;

                case '!i':
                case '!inverse':
                    $handle[] = 27;
                  break;

                default:
                    if(0 === preg_match('#^([^\(]+)\(([^\)]+)\)$#', $attribute, $m))
                        break;

                    $shift = 0;

                    switch($m[1]) {

                        case 'fg':
                        case 'foreground':
                            $shift = 0;
                          break;

                        case 'bg':
                        case 'background':
                            $shift = 10;
                          break;

                        default:
                          break 2;
                    }

                    $_handle  = 0;
                    $_keyword = true;

                    switch($m[2]) {

                        case 'black':
                            $_handle = 30;
                          break;

                        case 'red':
                            $_handle = 31;
                          break;

                        case 'green':
                            $_handle = 32;
                          break;

                        case 'yellow':
                            $_handle = 33;
                          break;

                        case 'blue':
                            $_handle = 34;
                          break;

                        case 'magenta':
                            $_handle = 35;
                          break;

                        case 'cyan':
                            $_handle = 36;
                          break;

                        case 'white':
                            $_handle = 37;
                          break;

                        case 'default':
                            $_handle = 39;
                          break;

                        default:
                            $_keyword = false;

                            if('#' === $m[2][0]) {

                                $rgb      = hexdec(substr($m[2], 1));
                                $r        = ($rgb >> 16) & 255;
                                $g        = ($rgb >>  8) & 255;
                                $b        =  $rgb        & 255;
                                $distance = null;

                                foreach($_rgbTo256 as $i => $_rgb) {

                                    $_rgb = hexdec($_rgb);
                                    $_r   = ($_rgb >> 16) & 255;
                                    $_g   = ($_rgb >>  8) & 255;
                                    $_b   =  $_rgb        & 255;

                                    $d = sqrt(
                                        pow($_r - $r, 2)
                                      + pow($_g - $g, 2)
                                      + pow($_b - $b, 2)
                                    );

                                    if(   null === $distance
                                       || $d   <=  $distance) {

                                        $distance = $d;
                                        $_handle  = $i;
                                    }
                                }
                            }
                            else
                                $_handle = intval($m[2]);
                    }

                    if(true === $_keyword)
                        $handle[] = $_handle + $shift;
                    else
                        $handle[] = (38 + $shift) . ';5;' . $_handle;
            }
        }

        echo "\033[" . implode($handle, ';') . "m";

        return;
    }

    /**
     * Change color number to a specific RGB color.
     *
     * @access  public
     * @param   int  $fromCode    Color number.
     * @param   int  $toColor     RGB color.
     * @return  void
     */
    public static function changeColor ( $fromCode, $toColor ) {

        if(OS_WIN)
            return;

        $r = ($toColor >> 16) & 255;
        $g = ($toColor >>  8) & 255;
        $b =  $tocolor        & 255;

        echo "\033]4;" . $fromCode . ";#" .
             sprintf('%02x%02x%02x', $r, $g, $b) .
             "\033\\";

        return;
    }

    /**
     * Set cursor style.
     * Style can be:
     *     • b, block,     ▋: block;
     *     • u, underline, _: underline;
     *     • v, vertical,  |: vertical.
     *
     * @access  public
     * @param   int   $style    Style.
     * @param   bool  $blink    Whether the cursor is blink or steady.
     * @return  void
     */
    public static function setStyle ( $style, $blink = true ) {

        if(OS_WIN)
            return;

        switch($style) {

            case 'b':
            case 'block':
            case '▋':
                $_style = 1;
              break;

            case 'u':
            case 'underline':
            case '_':
                $_style = 2;
              break;

            case 'v':
            case 'vertical':
            case '|':
                $_style = 5;
              break;
        }

        if(false === $blink)
            ++$_style;

        // DECSCUSR.
        echo "\033[" . $_style . " q";

        return;
    }

    /**
     * Make a stupid “bip”.
     *
     * @access  public
     * @return  void
     */
    public static function bip ( ) {

        echo "\007";

        return;
    }
}

}
