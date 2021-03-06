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
 * \Hoa\Mail\Exception
 */
-> import('Mail.Exception.~')

/**
 * \Hoa\Mail\Transport\ITransport\Out
 */
-> import('Mail.Transport.I~.Out')

/**
 * \Hoa\Mail\Content\Message
 */
-> import('Mail.Content.Message');

}

namespace Hoa\Mail {

/**
 * Class \Hoa\Mail\Message.
 *
 * This class represents a message that can be sent through a transport.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

class Message extends Content\Message {

    /**
     * MIME version.
     *
     * @const string
     */
    const MIME_VERSION = '1.0';

    /**
     * Default transport layer.
     *
     * @var \Hoa\Mail\Transport\ITransport\Out object
     */
    protected static $_defaultTransport = null;

    /**
     * Transport layer.
     *
     * @var \Hoa\Mail\Transport\ITransport\Out object
     */
    protected $_transport               = null;




    /**
     * Construct a message.
     *
     * @access  public
     * @return  void
     */
    public function __construct ( ) {

        parent::__construct();
        $this['mime-version'] = static::MIME_VERSION;

        return;
    }

    /**
     * Set default transport layer.
     *
     * @access  public
     * @param   \Hoa\Mail\Transport\ITransport\Out  $transport    Transport.
     * @return  \Hoa\Mail\Transport\ITransport\Out
     */
    public static function setDefaultTransport ( Transport\ITransport\Out $transport ) {

        $old                       = static::$_defaultTransport;
        static::$_defaultTransport = $transport;

        return $old;
    }

    /**
     * Get default transport layer.
     *
     * @access  public
     * @return  \Hoa\Mail\Transport\ITransport\Out
     */
    public static function getDefaultTransport ( ) {

        return static::$_defaultTransport;
    }

    /**
     * Set transport layer.
     *
     * @access  public
     * @param   \Hoa\Mail\Transport\ITransport\Out  $transport    Transport.
     * @return  \Hoa\Mail\Transport\ITransport\Out
     */
    public function setTransport ( Transport\ITransport\Out $transport ) {

        $old              = $this->_transport;
        $this->_transport = $transport;

        return $old;
    }

    /**
     * Get a transport layer (the current or default one).
     *
     * @access  public
     * @return  \Hoa\Mail\Transport\ITransport\Out
     */
    public function getTransport ( ) {

        return $this->_transport ?: static::getDefaultTransport();
    }

    /**
     * Send the message.
     *
     * @access  public
     * @return  bool
     * @throw   \Hoa\Mail\Exception
     */
    public function send ( ) {

        $transport = $this->getTransport();

        if(null === $transport)
            throw new Exception(
                'Cannot send a message without specifying a transport.', 0);

        return $transport->send($this);
    }
}

}
