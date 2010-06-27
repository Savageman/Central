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
 * @subpackage  Hoa_Test_Urg_Type_Xn
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
 * Hoa_Test_Urg_Type_Exception_Maxtry
 */
import('Test.Urg.Type.Exception.Maxtry');

/**
 * Hoa_Test_Urg_Type_BoundInteger
 */
import('Test.Urg.Type.BoundInteger');

/**
 * Hoa_Test
 */
import('Test.~');

/**
 * Class Hoa_Test_Urg_Type_Xn.
 *
 * Represent a x^n expression.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 *              Julien LORRAIN <julien.lorrain@gmail.com>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Urg_Type_Xn
 */

class Hoa_Test_Urg_Type_Xn extends Hoa_Test_Urg_Type_BoundInteger {

    /**
     * Name of type.
     *
     * @var Hoa_Test_Urg_Type_Interface_Type string
     */
    protected $_name = 'xn';

    /**
     * Base.
     *
     * @var Hoa_Test_Urg_Type_Xn int
     */
    protected $_base = 0;



    /**
     * Constructor.
     *
     * @access  public
     * @param   int     $base    Base.
     * @return  void
     */
    public function __construct ( $base ) {

        $this->setBase($base);
        $bound = (int) floor(log(parent::getPositiveInfinity(), $base));
        parent::__construct(-$bound, $bound, parent::BOUND_CLOSE, parent::BOUND_CLOSE);

        parent::setArguments($base);

        return;
    }

    /**
     * A predicate.
     *
     * @access  public
     * @param   bool    $q    Q-value.
     * @return  bool
     */
    public function predicate ( $q = null ) {

        if(null === $q)
            $q = $this->getValue();

        $out = false;
        $i   = $this->getLowerBoundValue();
        $max = $this->getUpperBoundValue();

        for($i    = $this->getLowerBoundValue(),
            $max  = $this->getUpperBoundValue();
            $i   <= $max
            &&
            !($out  = $q >= pow($this->getBase(), $i));
            $i++);

        return $out;
    }

    /**
     * Choose a random value.
     *
     * @access  public
     * @return  void
     * @throws  Hoa_Test_Urg_Type_Exception_Maxtry
     */
    public function randomize ( ) {

        $maxtry = Hoa_Test::getInstance()->getParameter('test.maxtry');

        do {

            parent::randomize();
            $random = pow($this->getBase(), $this->getValue());

        } while(false === $this->predicate($random) && $maxtry-- > 0);

        if($maxtry == -1)
            throw new Hoa_Test_urg_Type_Exception_Maxtry(
                'All tries failed (%d tries).',
                0, Hoa_Test::getInstance()->getParameter('test.maxtry'));

        $this->setValue($random);

        return;
    }

    /**
     * Set the base.
     *
     * @access  protected
     * @param   int        $base    Base.
     * @return  int
     */
    protected function setBase ( $base ) {

        $old         = $this->_base;
        $this->_base = $base;

        return $old;
    }

    /**
     * Get the base.
     *
     * @access  public
     * @return  int
     */
    public function getBase ( ) {

        return $this->_base;
    }
}
