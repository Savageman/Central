<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * GNU General Public License
 *
 * This file is part of Hoa Open Accessibility.
 * Copyright (c) 2007, 2011 Ivan ENDERLIN. All rights reserved.
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
 * \Hoa\Tree\Visitor\Generic
 */
-> import('Tree.Visitor.Generic')

/**
 * \Hoa\Visitor\Visit
 */
-> import('Visitor.Visit');

}

namespace Hoa\Tree\Visitor {

/**
 * Class \Hoa\Tree\Visitor\Dump.
 *
 * Dump a tree.
 *
 * @author     Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright (c) 2007, 2011 Ivan ENDERLIN.
 * @license    http://gnu.org/licenses/gpl.txt GNU GPL
 */

class Dump extends Generic implements \Hoa\Visitor\Visit {

    /**
     * Tree deep.
     *
     * @var \Hoa\Tree\Visitor\Dump int
     */
    protected $_i = 0;



    /**
     * Just change the default transversal order value.
     *
     * @access  public
     * @param   int     $order    Traversal order (please, see the * self::*_ORDER
     *                            constants).
     * @return  void
     */
    public function __construct ( $order = parent::IN_ORDER ) {

        parent::__construct($order);

        return;
    }

    /**
     * Visit an element.
     *
     * @access  public
     * @param   \Hoa\Visitor\Element  $element    Element to visit.
     * @param   mixed                 &$handle    Handle (reference).
     * @param   mixed                 $eldnah     Handle (not reference).
     * @return  string
     */
    public function visit ( \Hoa\Visitor\Element $element,
                            &$handle = null,
                             $eldnah = null ) {

        $pre    = null;
        $in     = '> ' . str_repeat('  ', $this->_i) .
                  $element->getValue() . "\n";
        $post   = null;
        $childs = $element->getChilds();
        $i      = 0;
        $max    = floor(count($childs) / 2);

        ++$this->_i;

        foreach($childs as $id => $child)
            if($i++ < $max)
                $pre  .= $child->accept($this, $handle, $eldnah);
            else
                $post .= $child->accept($this, $handle, $eldnah);

        --$this->_i;

        switch($this->getOrder()) {

            case parent::IN_ORDER:
                return $in  . $pre . $post;
              break;

            case parent::POST_ORDER:
                return $post . $in . $pre;
              break;

            default:
                return $pre  . $in . $post;
              break;
        }
    }
}

}
