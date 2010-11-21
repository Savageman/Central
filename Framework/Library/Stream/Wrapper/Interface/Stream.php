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
 * @package     Hoa_Stream
 * @subpackage  Hoa_Stream_Wrapper_Interface_Stream
 *
 */

/**
 * Interface Hoa_Stream_Wrapper_Interface_Stream.
 *
 * Interface for “stream stream wrapper” class.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Stream
 * @subpackage  Hoa_Stream_Wrapper_Interface_Stream
 */

interface Hoa_Stream_Wrapper_Interface_Stream {

    /**
     * Retrieve the underlaying resource.
     *
     * @access  public
     * @param   int     $castAs    Can be STREAM_CAST_FOR_SELECT when
     *                             stream_select() is calling stream_cast() or
     *                             STREAM_CAST_AS_STREAM when stream_cast() is
     *                             called for other uses.
     * @return  resource
     */
    public function stream_cast ( $castAs );

    /**
     * Close a resource.
     * This method is called in response to fclose().
     * All resources that were locked, or allocated, by the wrapper should be
     * released.
     *
     * @access  public
     * @return  void
     */
    public function stream_close ( );

    /**
     * Tests for end-of-file on a file pointer.
     * This method is called in response to feof().
     *
     * @access  public
     * @return  bool
     */
    public function stream_eof ( );

    /**
     * Flush the output.
     * This method is called in response to fflush().
     * If we have cached data in our stream but not yet stored it into the
     * underlying storage, we should do so now.
     *
     * @access  public
     * @return  bool
     */
    public function stream_flush ( );

    /**
     * Advisory file locking.
     * This method is called in response to flock(), when file_put_contents()
     * (when flags contains LOCK_EX), stream_set_blocking() and when closing the
     * stream (LOCK_UN).
     *
     * @access  public
     * @param   int     $operation    Operation is one the following:
     *                                  * LOCK_SH to acquire a shared lock (reader) ;
     *                                  * LOCK_EX to acquire an exclusive lock (writer) ;
     *                                  * LOCK_UN to release a lock (shared or exclusive) ;
     *                                  * LOCK_NB if we don't want flock() to
     *                                    block while locking (not supported on
     *                                    Windows).
     * @return  bool
     */
    public function stream_lock ( $operation );

    /**
     * Open file or URL.
     * This method is called immediately after the wrapper is initialized (f.e.
     * by fopen() and file_get_contents()).
     *
     * @access  public
     * @param   string  $path           Specifies the URL that was passed to the
     *                                  original function.
     * @param   string  $mode           The mode used to open the file, as
     *                                  detailed for fopen().
     * @param   int     $options        Holds additional flags set by the
     *                                  streams API. It can hold one or more of
     *                                  the following values OR'd together:
     *                                    * STREAM_USE_PATH, if path is relative,
     *                                      search for the resource using the
     *                                      include_path;
     *                                    * STREAM_REPORT_ERRORS, if this is
     *                                    set, you are responsible for raising
     *                                    errors using trigger_error during
     *                                    opening the stream. If this is not
     *                                    set, you should not raise any errors.
     * @param   string  &$openedPath    If the $path is opened successfully, and
     *                                  STREAM_USE_PATH is set in $options,
     *                                  $openedPath should be set to the full
     *                                  path of the file/resource that was
     *                                  actually opened.
     * @return  bool
     */
    public function stream_open ( $path, $mode, $options, &$openedPath );

    /**
     * Read from stream.
     * This method is called in response to fread() and fgets().
     *
     * @access  public
     * @param   int     $count    How many bytes of data from the current
     *                            position should be returned.
     * @return  string
     */
    public function stream_read ( $count );

    /**
     * Seek to specific location in a stream.
     * This method is called in response to fseek().
     * The read/write position of the stream should be updated according to the
     * $offset and $whence.
     *
     * @access  public
     * @param   int     $offset    The stream offset to seek to.
     * @param   int     $whence    Possible values:
     *                               * SEEK_SET to set position equal to $offset
     *                                 bytes ;
     *                               * SEEK_CUR to set position to current
     *                                 location plus $offsete ;
     *                               * SEEK_END to set position to end-of-file
     *                                 plus $offset.
     * @return  bool
     */
    public function stream_seek ( $offset, $whence = SEEK_SET );

    /**
     * Change stream options.
     * This method is called to set options on the stream.
     *
     * @access  public
     * @param   int     $option    One of:
     *                               * STREAM_OPTION_BLOCKING, the method was
     *                                 called in response to
     *                                 stream_set_blocking() ;
     *                               * STREAM_OPTION_READ_TIMEOUT, the method
     *                                 was called in response to
     *                                 stream_set_timeout() ;
     *                               * STREAM_OPTION_WRITE_BUFFER, the method
     *                                 was called in response to
     *                                 stream_set_write_buffer().
     * @param   int     $arg1      If $option is:
     *                               * STREAM_OPTION_BLOCKING: requested blocking
     *                                 mode (1 meaning block, 0 not blocking) ;
     *                               * STREAM_OPTION_READ_TIMEOUT: the timeout
     *                                 in seconds ;
     *                               * STREAM_OPTION_WRITE_BUFFER: buffer mode
     *                                 (STREAM_BUFFER_NONE or
     *                                 STREAM_BUFFER_FULL).
     * @param   int     $arg2      If $option is:
     *                               * STREAM_OPTION_BLOCKING: this option is
     *                                 not set ;
     *                               * STREAM_OPTION_READ_TIMEOUT: the timeout
     *                                 in microseconds ;
     *                               * STREAM_OPTION_WRITE_BUFFER: the requested
     *                                 buffer size.
     * @return  bool
     */
    public function stream_set_option ( $option, $arg1, $arg2 );

    /**
     * Retrieve information about a file resource.
     * This method is called in response to fstat().
     *
     * @access  public
     * @return  array
     */
    public function stream_stat ( );

    /**
     * Retrieve the current position of a stream.
     * This method is called in response to ftell().
     *
     * @access  public
     * @return  int
     */
    public function stream_tell ( );

    /**
     * Write to stream.
     * This method is called in response to fwrite().
     *
     * @access  public
     * @param   string  $data    Should be stored into the underlying stream.
     * @return  int
     */
    public function stream_write ( $data );
}
