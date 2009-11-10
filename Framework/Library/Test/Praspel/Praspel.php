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
 * Copyright (c) 2007, 2009 Ivan ENDERLIN. All rights reserved.
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
 * @subpackage  Hoa_Test_Praspel
 *
 */

/**
 * Hoa_Framework
 */
require_once 'Framework.php';

/**
 * Hoa_Test
 */
import('Test.~');

/**
 * Hoa_Test_Praspel_Exception
 */
import('Test.Praspel.Exception');

/**
 * Hoa_Test_Praspel_Clause_Ensures
 */
import('Test.Praspel.Clause.Ensures');

/**
 * Hoa_Test_Praspel_Clause_Invariant
 */
import('Test.Praspel.Clause.Invariant');

/**
 * Hoa_Test_Praspel_Clause_Predicate
 */
import('Test.Praspel.Clause.Predicate');

/**
 * Hoa_Test_Praspel_Clause_Requires
 */
import('Test.Praspel.Clause.Requires');

/**
 * Hoa_Test_Praspel_Clause_Throws
 */
import('Test.Praspel.Clause.Throws');

/**
 * Hoa_Test_Praspel_Type
 */
import('Test.Praspel.Type');

/**
 * Hoa_Test_Praspel_Call
 */
import('Test.Praspel.Call');

/**
 * Hoa_Log
 */
import('Log.~');

/**
 * Class Hoa_Test_Praspel.
 *
 * .
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2009 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Test
 * @subpackage  Hoa_Test_Praspel
 */

class Hoa_Test_Praspel {

    /**
     *
     */
    const LOG_CHANNEL = '@hoa/Framework/Library/Test/Praspel';

    /**
     * Collection of clauses.
     *
     * @var Hoa_Test_Praspel array
     */
    protected $_clauses = array();

    /**
     * The call object.
     *
     * @var Hoa_Test_Praspel_Call object
     */
    protected $_call    = null;

    /**
     *
     */
    protected $_log     = null;



    /**
     * Constructor. Create a default “requires” clause.
     *
     * @access  public
     * @return  void
     */
    public function __construct ( ) {

        $this->_log = Hoa_Log::getChannel(
            self::LOG_CHANNEL,
            Hoa_Test::getInstance()->getLogStreams()
        );
        $this->clause('requires');
    }

    /**
     * Add a clause.
     *
     * @access  public
     * @param   string  $name    Clause name.
     * @return  Hoa_Test_Praspel_Clause
     * @throws  Hoa_Test_Praspel_Exception
     */
    public function clause ( $name ) {

        if(true === $this->clauseExists($name))
            return $this->_clauses[$name];

        $clause = null;

        switch($name) {

            case 'ensures':
                $clause = new Hoa_Test_Praspel_Clause_Ensures($this);
              break;

            case 'invariant':
                $clause = new Hoa_Test_Praspel_Clause_Invariant($this);
              break;

            case 'predicate':
                $clause = new Hoa_Test_Praspel_Clause_Predicate();
              break;

            case 'requires':
                $clause = new Hoa_Test_Praspel_Clause_Requires($this);
              break;

            case 'throws':
                $clause = new Hoa_Test_Praspel_Clause_Throws();
              break;

            default:
                throw new Hoa_Test_Praspel_Exception(
                    'Unknown clause %s.', 0, $name);
        }

        return $this->_clauses[$name] = $clause;
    }

    /**
     * Create a type.
     *
     * @access  public
     * @param   string  $name    Type name.
     * @param   ...     ...      Type arguments.
     * @return  Hoa_Test_Urg_Type_Interface_Type
     */
    public function type ( $name ) {

        $arguments = func_get_args();
        array_shift($arguments);
        $type      = new Hoa_Test_Praspel_Type($name, $arguments);

        return $type->getType();
    }

    /**
     * Call a method.
     *
     * @access  public
     * @param   object  $object         Object where method is.
     * @param   string  $magicCaller    Magic caller name.
     * @param   string  $method         Method name.
     * @return  Hoa_Test_Praspel_Call
     */
    public function call ( $object, $magicCaller, $method ) {

        $old         = $this->_call;
        $this->_call = new Hoa_Test_Praspel_Call(
            $this,
            $object,
            $magicCaller,
            $method
        );

        return $this->_call->getObject();
    }

    /**
     * Verify clauses.
     *
     * @access  public
     * @return  void
     */
    public function verify ( ) {

        $requires = $this->getClause('requires');
        $ensures  = $this->getClause('ensures');
        $call     = $this->getCall();
        $table    = array();

        $table['@requires'] = array();
        foreach($requires->getFreeVariables() as $fvName => $fvInstance) {

            $tmp = array();

            foreach($fvInstance->getTypes() as $i => $type)
                $tmp[] = get_class($type);

            $table['@requires'][$fvName] = implode(' ∧ ', $tmp);
        }

        if(true === $call->hasException()) {

            $exception = $call->getException();

            if(true === $this->clauseExists('throws')) {

                $table['@throws'] = implode(' ∧ ', $throws->getList());
                $table['throws']  = get_class($exception);

                $throws = $this->getClause('throws');

                if(false === $throws->exceptionExists($exception))
                    // LOG : exception not captured/declared + message.
                    throw new Hoa_Test_Praspel_Exception(
                        'Exception %s (with message %s) was thrown and not ' .
                        'declared in the clause “throws”, only given %s', 0,
                        array(
                            get_class($exception),
                            $exception->getMessage(),
                            implode(' ∧ ', $throws->getList())
                        ));
            }
            else
                // LOG : exception not captured/declared + message.
                throw new Hoa_Test_Praspel_Exception(
                    'Exception %s (with message %s) was thrown and no ' .
                    'clause “throws” was declared.', 1,
                    array(get_class($exception), $exception->getMessage()));
        }

        $validations = array();

        $table['@ensures'] = array();

        foreach($ensures->getFreeVariables() as $fvName => $fvInstance) {

            $valid = false;

            if(0 !== preg_match('#\\\old\s*\(\s*([a-z]+)\s*\)#i', $fvName, $matches)) {

                if(true === $requires->freeVariableExists($matches[1]))
                    $types = $requires->getFreeVariable($matches[1])->getTypes();
                else
                    // LOG : cannot verify ensures clause (old(__)).
                    throw new Hoa_Test_Praspel_Exception(
                        'Try to touch the “%1$s” free-variable through “%2$s”, ' .
                        'but “%1$s” is not declared in the “requires” clause.', 2,
                        array($matcges[1], $fvName));
            }
            else
                $types = $fvInstance->getTypes();

            $tmp = array();

            foreach($types as $i => $type) {

                $tmp[]  = get_class($type);
                $valid |= $type->predicate($call->getResult());
            }

            $table['@ensures'][$fvName] = implode(' ∧ ', $tmp);

            $validations[$fvName] = (bool) $valid;
        }

        $table['result'] = gettype($call->getResult()) . ' : ' . $call->getResult();

        if(!isset($validations['\result']))
            // LOG : \result must be declared.
            throw new Hoa_Test_Praspel_Exception(
                'Test cannot be evaluated because no “\result” free-variable ' .
                'in the “ensures” clause was declared.', 3);

        $out = true;

        foreach($validations as $i => $valid)
            $out &= $valid;

        $out = (bool) $out;

        //print_r($table);

        if(true === $out) {

            //throw new Hoa_Test_Praspel_Exception(
            //    'Test succeed.', 4);
            //var_dump('Test succeed');
            //var_dump($call->getResult());
            //echo "\n";
            $this->_log->log(true, Hoa_Log::TEST);
        }
        else {

            //throw new Hoa_Test_Praspel_Exception(
            //    'Test failed.', 5);
            //var_dump('Test failed.');
            //var_dump($call->getResult());
            //echo "\n";
            $this->_log->log(false, Hoa_Log::TEST);
        }
    }

    /**
     * Check if a clause already exists or not.
     *
     * @access  public
     * @param   string     $name    Clause name.
     * @return  bool
     */
    public function clauseExists ( $name ) {

        return isset($this->_clauses[$name]);
    }

    /**
     * Get all clauses.
     *
     * @access  public
     * @param   string     $name    Clause name.
     * @return  Hoa_Test_Praspel_Clause
     * @throw   Hoa_Test_Praspel_Exception
     */
    public function getClause ( $name ) {

        if(false === $this->clauseExists($name))
            throw new Hoa_Test_Praspel_Exception(
                'Clause %s is not defined.', 1, $name);

        return $this->_clauses[$name];
    }

    /**
     * Get the call.
     *
     * @access  public
     * @return  Hoa_Test_Praspel_Call
     */
    public function getCall ( ) {

        return $this->_call;
    }
}
