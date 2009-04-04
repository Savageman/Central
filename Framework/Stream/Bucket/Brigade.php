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
 * @package     Hoa_Stream
 * @subpackage  Hoa_Stream_Bucket_Brigade
 *
 */

/**
 * Hoa_Framework
 */
require_once 'Framework.php';

/**
 * Hoa_Stream_Bucket_Exception
 */
import('Stream.Bucket.Exception');

/**
 * Class Hoa_Stream_Bucket_Brigade.
 *
 * Manipulate stream buckets through brigades.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2008 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Stream
 * @subpackage  Hoa_Stream_Bucket_Brigade
 */

class Hoa_Stream_Bucket_Brigade {

    /**
     * Whether the stream is already a brigade.
     *
     * @const bool
     */
    const IS_A_BRIGADE = true;

    /**
     * Whether the stream is not a brigade.
     *
     * @const bool
     */
    const IS_A_STREAM  = false;

    /**
     * Brigade.
     *
     * @var Hoa_Stream_Bucket_Brigade resource
     */
    protected $_brigade = null;

    /**
     * Bucket.
     *
     * @var Hoa_Stream_Bucket_Brigade object
     */
    protected $_bucket  = null;



    /**
     * Set a brigade.
     * If a stream is given (with the constant self::IS_A_STREAM), it will
     * create a brigade automatically.
     *
     * @access  public
     * @param   resource  $brigade    A stream or a brigade.
     * @param   bool      $is         Specify if $brigade is a stream or a
     *                                brigade, given by self::IS_A_* constant.
     * @param   string    $buffer     Stream buffer.
     * @return  void
     */
    public function __construct ( &$brigade, $is = self::IS_A_BRIGADE, $buffer = '' ) {

        if($is === self::IS_A_BRIGADE)
            $this->setBrigade($brigade);
        else
            $this->setBrigade(stream_bucket_new($brigade, $buffer));

        return;
    }

    /**
     * Test the end-of-bucket.
     * When testing, set the new bucket object.
     *
     * @access  public
     * @return  bool
     */
    public function eob ( ) {

        unset($this->_bucket);

        if(false == $this->_bucket = stream_bucket_make_writeable($this->getBrigade()))
            return true;

        return false;
    }

    /**
     * Append bucket to the brigade.
     *
     * @access  public
     * @param   Hoa_Stream_Bucket_Brigade  $bucket    Bucket to add.
     * @return  void
     */
    public function append ( Hoa_Stream_Bucket_Brigade $bucket ) {

        stream_bucket_append($this->getBrigade(), $bucket->getBucket());

        return;
    }

    /**
     * Prepend bucket to the brigade.
     *
     * @access  public
     * @param   Hoa_Stream_Bucket_Brigade  $bucket    Bucket to add.
     * @return  void
     */
    public function prepend ( Hoa_Stream_Bucket_Brigage $bucket ) {

        stream_bucket_prepend($this->getBrigade(), $bucket->getBucket());

        return;
    }

    /**
     * Set bucket data.
     *
     * @access  public
     * @param   string  $data    Data to set.
     * @retun   string
     */
    public function setData ( $data ) {

        if(null === $this->getBucket())
            return $this->getBucket()->data;

        $old                        = $this->getBucket()->data;
        $this->getBucket()->data    = $data;
        $this->getBucket()->datalen = strlen($this->getBucket()->data);

        return $old;
    }

    /**
     * Get bucket data.
     *
     * @access  public
     * @return  string
     */
    public function getData ( ) {

        if(null === $this->getBucket())
            return null;

        return $this->getBucket()->data;
    }

    /**
     * Get bucket length.
     *
     * @access  public
     * @return  int
     */
    public function getLength ( ) {

        if(null === $this->getBucket())
            return 0;

        return $this->getBucket()->datalen;
    }

    /**
     * Set the brigade.
     *
     * @access  protected
     * @param   resource   &$stream    Brigade to add.
     * @return  resource
     */
    protected function setBrigade ( &$brigade ) {

        $old            = $this->_brigade;
        $this->_brigade = $brigade;

        return $old;
    }

    /**
     * Get the brigade.
     *
     * @access  public
     * @return  resource
     */
    public function getBrigade ( ) {

        return $this->_brigade;
    }

    /**
     * Get the current bucket.
     *
     * @access  protected
     * @return  object
     */
    protected function getBucket ( ) {

        return $this->_bucket;
    }
}
