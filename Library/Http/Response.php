<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2011, Ivan Enderlin. All rights reserved.
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
 * \Hoa\Http\Exception
 */
-> import('Http.Exception')

/**
 * \Hoa\Stream\IStream\Out
 */
-> import('Stream.I~.Out');

}

namespace Hoa\Http {

/**
 * Class \Hoa\Http\Response.
 *
 * Parse HTTP headers.
 * Please, see the RFC 2616.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2011 Ivan Enderlin.
 * @license    New BSD License
 */

class Response implements \Hoa\Stream\IStream\Out {

    /**
     * Continue.
     *
     * @const int
     */
    const STATUS_CONTINUE                        = 100;

    /**
     * Switching protocols.
     *
     * @const int
     */
    const STATUS_SWITCHING_PROTOCOLS             = 101;

    /**
     * OK.
     *
     * @const int
     */
    const STATUS_OK                              = 200;

    /**
     * Created.
     *
     * @const int
     */
    const STATUS_CREATED                         = 201;

    /**
     * Accepted.
     *
     * @const int
     */
    const STATUS_ACCEPTED                        = 202;

    /**
     * Non-authoritative information.
     *
     * @const int
     */
    const STATUS_NON_AUTHORITATIVE_INFORMATION   = 203;

    /**
     * No content.
     *
     * @const int
     */
    const STATUS_NO_CONTENT                      = 204;

    /**
     * Reset content.
     *
     * @const int
     */
    const STATUS_RESET_CONTENT                   = 205;

    /**
     * Partial content.
     *
     * @const int
     */
    const STATUS_PARTIAL_CONTENT                 = 206;

    /**
     * Multiple choices.
     *
     * @const int
     */
    const STATUS_MULTIPLE_CHOICES                = 300;

    /**
     * Moved permanently.
     *
     * @const int
     */
    const STATUS_MOVED_PERMANENTLY               = 301;

    /**
     * Found.
     *
     * @const int
     */
    const STATUS_FOUND                           = 302;

    /**
     * See other.
     *
     * @const int
     */
    const STATUS_SEE_OTHER                       = 303;

    /**
     * Not modified.
     *
     * @const int
     */
    const STATUS_NOT_MODIFIED                    = 304;

    /**
     * Use proxy.
     *
     * @const int
     */
    const STATUS_USE_PROXY                       = 305;

    /**
     * Temporary redirect.
     *
     * @const int
     */
    const STATUS_TEMPORARY_REDIRECT              = 307;

    /**
     * Bad request.
     *
     * @const int
     */
    const STATUS_BAD_REQUEST                     = 400;

    /**
     * Unauthorized.
     *
     * @const int
     */
    const STATUS_UNAUTHORIZED                    = 401;

    /**
     * Payment required.
     *
     * @const int
     */
    const STATUS_PAYMENT_REQUIRED                = 402;

    /**
     * Forbidden.
     *
     * @const int
     */
    const STATUS_FORBIDDEN                       = 403;

    /**
     * Not found.
     *
     * @const int
     */
    const STATUS_NOT_FOUND                       = 404;

    /**
     * Method not allowed.
     *
     * @const int
     */
    const STATUS_METHOD_NOT_ALLOWED              = 405;

    /**
     * Not acceptable.
     *
     * @const int
     */
    const STATUS_NOT_ACCEPTABLE                  = 406;

    /**
     * Proxy authentification required.
     *
     * @const int
     */
    const STATUS_PROXY_AUTHENTIFICATION_RQEUIRED = 407;

    /**
     * Request time-out.
     *
     * @const int
     */
    const STATUS_REQUEST_TIME_OUT                = 408;

    /**
     * Conflict.
     *
     * @const int
     */
    const STATUS_CONFLICT                        = 409;

    /**
     * Gone.
     *
     * @const int
     */
    const STATUS_GONE                            = 410;

    /**
     * Length required.
     *
     * @const int
     */
    const STATUS_LENGTH_REQUIRED                 = 411;

    /**
     * Precondition failed.
     *
     * @const int
     */
    const STATUS_PRECONDITION_FAILED             = 412;

    /**
     * Request entity too large.
     *
     * @const int
     */
    const STATUS_REQUEST_ENTITY_TOO_LARGE        = 413;

    /**
     * Request URI too large.
     *
     * @const int
     */
    const STATUS_REQUEST_URI_TOO_LARGE           = 414;

    /**
     * Unsupported media type.
     *
     * @const int
     */
    const STATUS_UNSUPPORTED_MEDIA_TYPE          = 415;

    /**
     * Requested range not satisfiable.
     *
     * @const int
     */
    const STATUS_REQUESTED_RANGE_NOT_SATISFIABLE = 416;

    /**
     * Expectation failed.
     *
     * @const int
     */
    const STATUS_EXPECTATION_FAILED              = 417;

    /**
     * Internal server error.
     *
     * @const int
     */
    const STATUS_INTERNAL_SERVER_ERROR           = 500;

    /**
     * Not implemented.
     *
     * @const int
     */
    const STATUS_NOT_IMPLEMENTED                 = 501;

    /**
     * Bad gateway.
     *
     * @const int
     */
    const STATUS_BAD_GATEWAY                     = 502;

    /**
     * Service unavailable.
     *
     * @const int
     */
    const STATUS_SERVICE_UNAVAILABLE             = 503;

    /**
     * Gateway time-out.
     *
     * @const int
     */
    const STATUS_GATEWAY_TIME_OUT                = 504;

    /**
     * HTTP version not supported.
     *
     * @const int
     */
    const STATUS_HTTP_VERSION_NOT_SUPPORTED      = 505;

    protected $_body;

    public function __construct ( $headers = null ) {

        if(null !== $headers)
            $this->parse($headers);

        return;
    }

    public function parse ( $headers ) {

        $headers = explode("\r\n", $headers);
        $state   = 0;

        foreach($headers as $header) {

            $semicolon  = strpos($header, ':');
            $fieldName  = strtolower(substr($header, 0, $semicolon));
            $fieldValue = trim(substr($header, $semicolon + 1));

            switch($fieldName) {

                case 'accept-ranges':
                    $this->setAcceptRanges($fieldValue);
                  break;

                case 'age':
                    $this->setAge($fieldValue);
                  break;

                case 'etag':
                    $this->setETag($fieldValue);
                  break;

                case 'location':
                    $this->setLocation($fieldValue);
                  break;

                case 'proxy-authenticate':
                    $this->setProxyAuthenticate($fieldValue);
                  break;

                case 'retry-after':
                    $this->setRetryAfter($fieldValue);
                  break;

                case 'server':
                    $this->setServer($fieldValue);
                  break;

                case 'vary':
                    $this->setVary($fieldValue);
                  break;

                case 'www-authenticate':
                    $this->setWWWAuthenticate($fieldValue);
                  break;

                case false:
                    if(0 === $state)
                        $state = 1;
                    else
                        $this->setContent($header);
                  break;

                default:
                    var_dump($fieldName, $fieldValue);
                    echo "\n";
            }
        }

        return;
    }

    /**
     * Write n characters.
     *
     * @access  public
     * @param   string  $string    String.
     * @param   int     $length    Length.
     * @return  mixed
     */
    public function write ( $string, $length ) {

        echo $string;
    }

    /**
     * Write a string.
     *
     * @access  public
     * @param   string  $string    String.
     * @return  mixed
     */
    public function writeString ( $string ) {

        echo $string;
    }

    /**
     * Write a character.
     *
     * @access  public
     * @param   string  $character    Character.
     * @return  mixed
     */
    public function writeCharacter ( $character ) {

        echo $string;
    }

    /**
     * Write a boolean.
     *
     * @access  public
     * @param   bool    $boolean    Boolean.
     * @return  mixed
     */
    public function writeBoolean ( $boolean ) {

        echo $boolean;
    }

    /**
     * Write an integer.
     *
     * @access  public
     * @param   int     $integer    Integer.
     * @return  mixed
     */
    public function writeInteger ( $integer ) {

        echo $integer;
    }

    /**
     * Write a float.
     *
     * @access  public
     * @param   float   $float    Float.
     * @return  mixed
     */
    public function writeFloat ( $float ) {

        echo $float;
    }

    /**
     * Write an array.
     *
     * @access  public
     * @param   array   $array    Array.
     * @return  mixed
     */
    public function writeArray ( Array $array ) {

        echo $array;
    }

    /**
     * Write a line.
     *
     * @access  public
     * @param   string  $line    Line.
     * @return  mixed
     */
    public function writeLine ( $line ) {

        echo $line;
    }

    /**
     * Write all, i.e. as much as possible.
     *
     * @access  public
     * @param   string  $string    String.
     * @return  mixed
     */
    public function writeAll ( $string ) {

        echo $string;
    }

    /**
     * Truncate a file to a given length.
     *
     * @access  public
     * @param   int     $size    Size.
     * @return  bool
     */
    public function truncate ( $size ) {

        echo $size;
    }
}

}