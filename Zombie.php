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

namespace {

from('Hoa')

/**
 * \Hoa\Zombie\Exception
 */
-> import('Zombie.Exception');

}

namespace Hoa\Zombie {

/**
 * Class \Hoa\Zombie.
 *
 * Zombie!
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

class Zombie {

    /**
     * Test if we can start a zombie.
     *
     * @access  public
     * @return  bool
     */
    public static function test ( ) {

        return true === function_exists('fastcgi_finish_request');
    }

    /**
     * Try to create a zombie.
     *
     * @access  public
     * @return  void
     */
    public static function fork ( ) {

        if(true !== static::test())
            throw new Exception(
                'This program must run behind PHP-FPM to create a zombie.', 0);

        fastcgi_finish_request();

        return;
    }

    /**
     * Oh, why not decapitate?
     *
     * @access  public
     * @return  void
     */
    public static function decapitate ( ) {

        static::_kill();

        return;
    }

    /**
     * Maybe, we can bludgeon the zombie?
     *
     * @access  public
     * @return  void
     */
    public static function bludgeon ( ) {

        static::_kill();

        return;
    }

    /**
     * Grilled zombies, hummm!
     *
     * @access  public
     * @return  void
     */
    public static function burn ( ) {

        static::_kill();

        return;
    }

    /**
     * One… two… three… … splash!
     *
     * @access  public
     * @return  void
     */
    public static function explode ( ) {

        static::_kill();

        return;
    }

    /**
     * Would like a slice?
     *
     * @access  public
     * @return  void
     */
    public static function cutOff ( ) {

        static::_kill();

        return;
    }

    /**
     * Whatever, really kill the zombie.
     *
     * @access  public
     * @return  void
     */
    protected static function _kill ( ) {

        exit;
    }

    /**
     * Get PHP's process ID.
     *
     * @access  public
     * @return  int
     */
    public static function getPid ( ) {

        return getmypid();
    }
}

}
