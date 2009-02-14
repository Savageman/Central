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
 * @package     Hoa_Pom
 * @subpackage  Hoa_Pom_Token_LateParsing
 *
 */

/**
 * Hoa_Framework
 */
require_once 'Framework.php';

/**
 * Hoa_Pom_Token_Util_Exception
 */
import('Pom.Token.Util.Exception');

/**
 * Hoa_Pom_Token_Util_Interface_Tokenizable
 */
import('Pom.Token.Util.Interface.Tokenizable');

/**
 * Hoa_Pom
 */
import('Pom.~');

/**
 * Hoa_Pom_Parser_ParserLr
 */
import('Pom.Parser.ParserLr');

/**
 * Class Hoa_Pom_Token_LateParsing.
 *
 * Represent a late parsing, i.e. do not evaluate object model leafs except if
 * only needed. It is equivalent to force the tree to grow step by step.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2008 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Pom
 * @subpackage  Hoa_Pom_Token_LateParsing
 */

class Hoa_Pom_Token_LateParsing implements Hoa_Pom_Token_Util_Interface_Tokenizable {

    /**
     * Collection of unevaluated tokens.
     *
     * @var Hoa_Pom_token_LateParsing array
     */
    protected $_tokens = array();



    /**
     * Add many tokens.
     *
     * @access  public
     * @param   array   $tokens    Tokens to add.
     * @return  array
     */
    public function addTokens ( Array $tokens = array() ) {

        foreach($tokens as $i => $token)
            $this->addToken($token);

        return $this->_tokens;
    }

    /**
     * Add a token.
     *
     * @access  public
     * @param   mixed   $token    Token to add.
     * @return  array
     */
    public function addToken ( $token ) {

        $this->_tokens[] = $token;

        return $this->_tokens;
    }

    /**
     * Get all tokens.
     *
     * @access  public
     * @return  array
     */
    public function getTokens ( ) {

        return $this->_tokens;
    }

    /**
     * Force the object model to grow, i.e. force the parse leafs.
     *
     * @access  public
     * @return  array
     */
    public function grow ( ) {

        $subRoot = new Hoa_Pom_Parser_ParserLr(
            $this->getTokens(),
            Hoa_Pom_Parser_Lexer::LATE
        );

        return $subRoot->getElements();
    }

    /**
     * Transform token to “tokenizer array”.
     *
     * @access  public
     * @return  array
     */
    public function tokenize ( ) {

        return $this->getTokens();
    }
}
