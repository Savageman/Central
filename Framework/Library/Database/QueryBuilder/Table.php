<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright (c) 2007-2011, Ivan Enderlin. All rights reserved.
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
 *
 *
 * @category    Framework
 * @package     Hoa_Database
 * @subpackage  Hoa_Database_QueryBuilder_Table
 *
 */

/**
 * Hoa_Database_QueryBuilder_Exception
 */
import('Database.QueryBuilder.Exception');

/**
 * Hoa_Database_QueryBuilder_Dml_Interface
 */
import('Database.QueryBuilder.Dml.Interface');

/**
 * Hoa_Database_QueryBuilder_Dml_Delete
 */
import('Database.QueryBuilder.Dml.Delete');

/**
 * Hoa_Database_QueryBuilder_Dml_Insert
 */
import('Database.QueryBuilder.Dml.Insert');

/**
 * Hoa_Database_QueryBuilder_Dml_Select
 */
import('Database.QueryBuilder.Dml.Select');

/**
 * Hoa_Database_QueryBuilder_Dml_Update
 */
import('Database.QueryBuilder.Dml.Update');

/**
 * Class Hoa_Database_QueryBuilder_Table.
 *
 * Aliases to DML query builder.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007-2011 Ivan ENDERLIN.
 * @license     New BSD License
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Database
 * @subpackage  Hoa_Database_QueryBuilder_Table
 */

abstract class Hoa_Database_QueryBuilder_Table implements Hoa_Database_QueryBuilder_Dml_Interface {

    /**
     * Define the type of query.
     * Usefull for the Hoa_Database_Model_Table::query() method, to know how to
     * use the result of the query.
     *
     * @const int
     */
    const TYPE_DELETE     = 0;
    const TYPE_INSERT     = 1;
    const TYPE_SELECT     = 2;
    const TYPE_UPDATE     = 4;

    /**
     * Type of SELECT : ALL or DISTINCT.
     *
     * @const string
     */
    const SELECT_ALL      = 'ALL';
    const SELECT_DISTINCT = 'DISTINCT';

    /**
     * The query.
     *
     * @var Hoa_Database_QueryBuilder_Table string
     */
    private   $_query        = null;

    /**
     * The type of query.
     *
     * @var Hoa_Database_QueryBuilder_Table string
     */
    private   $type          = null;

    /**
     * Type of SELECT. Please, see the SELECT_* constant.
     *
     * @var Hoa_Database_QueryBuilder_Table string
     */
    private   $selectType    = null;

    /**
     * Prepared value for special query (like UPDATE, or INSERT).
     *
     * @var Hoa_Database_QueryBuilder_Table array
     */
    private   $preparedValue = array();



    /**
     * Set the query.
     *
     * @access  private
     * @param   string   $query    Query to set.
     * @return  string
     */
    private function setQuery ( $query ) {

        $old          = $this->_query;
        $this->_query = $query;

        return $old;
    }

    /**
     * Erase query (and type of query of course).
     * Return the query.
     *
     * @access  protected
     * @return  string
     */
    protected function eraseQuery ( ) {

        $old          = $this->_query;
        $this->_query = null;

        $this->setType(null);

        return $old;
    }

    /**
     * Get the query.
     *
     * @access  public
     * @return  string
     */
    public function getQuery ( ) {

        return $this->_query;
    }

    /**
     * Set the type of query. Please, see the TYPE_* constants.
     *
     * @access  public
     * @param   int     $type    The type of query.
     * @return  int
     */
    protected function setType ( $type ) {

        $old        = $this->type;
        $this->type = $type;

        return $old;
    }

    /**
     * Get the type of query. Please, see the TYPE_* constants.
     *
     * @access  public
     * @return  int
     */
    public function getType ( ) {

        return $this->type;
    }

    /**
     * Get the select type. Please, see the self::SELECT_* constants.
     *
     * @access  public
     * @return  string
     */
    public function getSelectType ( ) {

        return $this->selectType;
    }

    /**
     * Get the prepared value stack.
     *
     * @access  public
     * @return  array
     */
    public function getPreparedValue ( ) {

        return $this->preparedValue;
    }

    /**
     * Reset the prepared value stack.
     *
     * @access  public
     * @return  void
     */
    public function resetPreparedValue ( ) {

        $this->preparedValue = array();

        return;
    }

    /**
     * Add a prepared value.
     *
     * @access  public
     * @param   string  $name     The value name.
     * @param   string  $value    The value.
     * @return  array
     */
    public function addPreparedValue ( $name, $value ) {

        $this->preparedValue[$name] = $value;

        return $this->getPreparedValue();
    }

    /**
     * Built the delete query, through the Hoa_Database_QueryBuilder_Dml_Delete
     * class.
     *
     * @access  public
     * @return  void
     * @throw   Hoa_Database_QueryBuilder_Exception
     */
    public function delete ( ) {

        $delete = new Hoa_Database_QueryBuilder_Dml_Delete($this);
        $this->setQuery($delete->getQuery());

        return;
    }

    /**
     * Built the insert query, through the Hoa_Database_QueryBuilder_Dml_Insert
     * class.
     *
     * @access  public
     * @param   array   $values    Array that represents keys and values to
     *                             insert.
     * @return  void
     * @throw   Hoa_Database_QueryBuilder_Exception
     */
    public function insert ( Array $values ) {

        $insert = new Hoa_Database_QueryBuilder_Dml_Insert($this, $values);
        $this->setQuery($insert->getQuery());

        return;
    }

    /**
     * Built the select query, through the Hoa_Database_QueryBuilder_Dml_Select
     * class.
     * This method takes n arguments. If no argument is given, the select query
     * will select all table fields. Else, all argument must be an instance of
     * Hoa_Database_Model_Field.
     *
     * @access  public
     * @param   mixed                     $field    Field to select.
     * @param   Hoa_Database_Model_Field  ...       ...
     * @return  void
     * @throw   Hoa_Database_QueryBuilder_Exception
     */
    public function select ( $field = Hoa_Database_QueryBuilder_Dml_Select::ALL ) {

        if($field === Hoa_Database_QueryBuilder_Dml_Select::ALL)
            $args = array();
        else
            $args = func_get_args();

        foreach($args as $key => $value)
            if(!($value instanceof Hoa_Database_Model_Field))
                throw new Hoa_Database_QueryBuilder_Exception(
                    'This method only takes instances of ' .
                    'Hoa_Database_Model_Field in parameter ; given %s.',
                    0,
                    is_object($value)
                        ? get_class($value)
                        : gettype($value));

        $select = new Hoa_Database_QueryBuilder_Dml_Select($this, $args);
        $this->setQuery($select->getQuery());
        $this->setType(self::TYPE_SELECT);

        return;
    }

    /**
     * Set the SELECT type to ALL.
     *
     * @access  public
     * @return  Hoa_Database_Model_Table
     */
    public function all ( ) {

        $this->selectType = self::SELECT_ALL;

        return $this;
    }

    /**
     * Set the SELECT type to DISTINCT.
     *
     * @access  public
     * @return  Hoa_Database_Model_Table
     */
    public function distinct ( ) {

        $this->selectType = self::SELECT_DISTINCT;

        return $this;
    }

    /**
     * Built the update query, through the Hoa_Database_QueryBuilder_Dml_Update
     * class.
     *
     * @access  public
     * @param   array   $values    Array that represents keys and values to
     *                             update.
     * @return  void
     * @throw   Hoa_Database_QueryBuilder_Exception
     */
    public function update ( Array $values ) {

        $update = new Hoa_Database_QueryBuilder_Dml_Update($this, $values);
        $this->setQuery($update->getQuery());

        return;
    }
}
