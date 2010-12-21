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
 * @package     Hoa_Realdom
 * @subpackage  Hoa_Realdom_String
 *
 */

/**
 * Hoa_Realdom
 */
import('Realdom.~') and load();

/**
 * Hoa_Realdom_Constinteger
 */
import('Realdom.Constinteger');

/**
 * Class Hoa_Realdom_String.
 *
 * Realistic domain: string.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Realdom
 * @subpackage  Hoa_Realdom_String
 */

class Hoa_Realdom_String extends Hoa_Realdom {

    /**
     * Realistic domain name.
     *
     * @var Hoa_Realdom string
     */
    protected $_name         = 'string';

    /**
     * Minimum code point.
     *
     * @var Hoa_Realdom_String int
     */
    protected $_codepointMin = 0;

    /**
     * Maximum code point.
     *
     * @var Hoa_Realdom_String int
     */
    protected $_codepointMax = 0;

    /**
     * String's length.
     *
     * @var Hoa_Realdom_Integer object
     */
    protected $_length       = null;

    /**
     * All generated letters.
     *
     * @var Hoa_Realdom_String array
     */
    protected $_letters      = array();



    /**
     * Construct a realistic domain.
     *
     * @access  public
     * @param   Hoa_Realdom_Integer       $length          Length.
     * @param   Hoa_Realdom_Constinteger  $codepointMin    Minimum code point.
     * @param   Hoa_Realdom_Constinteger  $codepointMax    Maximum code point.
     * @throw   Hoa_Realdom_Integer
     * @return  void
     */
    public function construct ( Hoa_Realdom_Integer      $length       = null,
                                Hoa_Realdom_Constinteger $codepointMin = null,
                                Hoa_Realdom_Constinteger $codepointMax = null ) {

        if(null === $length)
            $length = new Hoa_Realdom_Constinteger(13);

        if(null === $codepointMin)
            $codepointMin = new Hoa_Realdom_Constinteger(0x20);

        if(null === $codepointMax)
            $codepointMax = new Hoa_Realdom_Constinteger(0x7E);

        $this->_length       = $length;
        $this->_codepointMin = $codepointMin->getValue();
        $this->_codepointMax = $codepointMax->getValue();

        for($i = $this->getCodepointMin(), $j = $this->getCodepointMax();
            $i <= $j;
            ++$i)
            $this->_letters[] = iconv('UCS-4LE', 'UTF-8', pack('V', $i));

        return;
    }

    /**
     * Predicate whether the sampled value belongs to the realistic domains.
     *
     * @access  public
     * @param   mixed  $q    Sampled value.
     * @return  boolean
     */
    public function predicate ( $q ) {

        if(!is_string($q))
            return false;

        if(false === $this->getLength()->predicate(mb_strlen($q)))
            return false;

        $split  = preg_split('#(?<!^)(?!$)#u', $q);
        $out    = true;
        $handle = 0;
        $min    = $this->getCodepointMin();
        $max    = $this->getCodepointMax();

        foreach($split as $letter) {

            $handle = unpack('V', iconv('UTF-8', 'UCS-4LE', $letter));
            $out    = $out && ($min <= $handle[1]) && ($handle[1] <= $max);
        }

        return $out;
    }

    /**
     * Sample one new value.
     *
     * @access  protected
     * @return  mixed
     */
    protected function _sample ( Hoa_Test_Sampler $sampler ) {

        $string  = null;
        $letters = array();
        $count   = count($this->_letters) - 1;
        $length  = $this->getLength()->sample($sampler);

        if(0 > $length)
            return false;

        for($i = 0; $i < $length; ++$i)
            $string .= $this->_letters[$sampler->getInteger(0, $count)];

        return $string;
    }

    /**
     * Get the minimum code point.
     *
     * @access  public
     * @return  int
     */
    public function getCodepointMin ( ) {

        return $this->_codepointMin;
    }

    /**
     * Get the maximum code point.
     *
     * @access  public
     * @return  int
     */
    public function getCodepointMax ( ) {

        return $this->_codepointMax;
    }

    /**
     * Get the string's length.
     *
     * @access  public
     * @return  Hoa_Realdom_Integer
     */
    public function getLength ( ) {

        return $this->_length;
    }
}
