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
 * @subpackage  Hoa_Test_Praspel_ArrayDescription
 *
 */

/**
 * Hoa_Test_Praspel_Exception
 */
import('Test.Praspel.Exception');

/**
 * Hoa_Test_Praspel_DomainDisjunction
 */
import('Test.Praspel.DomainDisjunction') and load();

/**
 * Class Hoa_Test_Praspel_ArrayDescription.
 *
 * .
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Praspel_ArrayDescription
 */

class       Hoa_Test_Praspel_ArrayDescription
    extends Hoa_Test_Praspel_DomainDisjunction {

    protected $_parent = null;

    /**
     * Describe an automata A(Q, I, F, α, Γ) where:
     *     Q = {q_0, q_1},     the states;
     *     I = q_0,            the initial state;
     *     F = {q_0},          the final states;
     *     α = {from, to},     the alphabet;
     *     Γ = {(0, to,   0),
     *          (0, from, 1),
     *          (1, to,   1)}, the transitions.
     */
    private $_state    = 0;

    protected $_key   = null;
    protected $_value = null;
    protected $_array = array();

    public $_comma = null;



    public function __construct ( Hoa_Test_Praspel_Domain $parent ) {

        parent::__construct();

        $this->_comma = $this;
        $this->setParent($parent);
    }

    public function from ( ) {

        $this->_to();

        if(0 != $this->_state)
            throw new Hoa_Test_Praspel_Exception(
                'Array not well-formed.', 0);

        if(empty($this->_domains))
            return $this;

        return $this;
    }

    protected function _from ( ) {

        $this->_ok();
        $this->_key     = array_values($this->getDomains());
        $this->_domains = array();
        $this->_state   = 1;

        return;
    }

    public function to ( ) {

        $this->_from();

        return $this;
    }

    protected function _to ( ) {

        if(empty($this->_domains))
            return;

        $this->_ok();
        $this->_value   = array_values($this->getDomains());
        $this->_domains = array();
        $this->_state   = 0;
        $this->_array[] = array($this->_key, $this->_value);

        $this->_key     = null;
        $this->_value   = null;

        return;
    }

    public function end ( ) {

        $this->_to();

        $this->_parent->_currentArgument = $this->getArray();

        // break the reference.
        unset($this->_parent->_currentArgument);

        return $this->_parent;
    }

    protected function setParent ( Hoa_Test_Praspel_Domain $parent ) {

        $old           = $this->_parent;
        $this->_parent = $parent;

        return $old;
    }

    public function getParent ( ) {

        return $this->_parent;
    }

    public function getArray ( ) {

        return $this->_array;
    }
}