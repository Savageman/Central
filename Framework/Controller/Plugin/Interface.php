<?php

/**
 * Hoa Framework
 *
 *
 * @license
 *
 * GNU General Public License
 *
 * This file is part of HOA Open Accessibility.
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
 * @package     Hoa_Controller
 * @subpackage  Hoa_Controller_Plugin_Interface
 *
 */

/**
 * Hoa_Framework
 */
require_once 'Framework.php';

/**
 * Class Hoa_Controller_Plugin_Interface.
 *
 * Plugin interface.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2008 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Controller
 * @subpackage  Hoa_Controller_Plugin_Interface
 */

interface Hoa_Controller_Plugin_Interface {

    /**
     * preRouter notification.
     *
     * @access  public
     * @param   Hoa_Controller_Request_Abstract  $request    The request object.
     * @return  mixed
     * @throw   Hoa_Controller_Exception
     */
    public function preRouter ( Hoa_Controller_Request_Abstract $request );

    /**
     * postRouter notification.
     *
     * @access  public
     * @param   Hoa_Controller_Request_Abstract  $request    The request object.
     * @param   Hoa_Controller_Router_Standard   $router     The router object.
     * @return  mixed
     * @throw   Hoa_Controller_Exception
     */
    public function postRouter ( Hoa_Controller_Request_Abstract $request,
                                 Hoa_Controller_Router_Standard  $router );

    /**
     * preDispatcher notification.
     *
     * @access  public
     * @param   Hoa_Controller_Request_Abstract  $request    The request object.
     * @param   Hoa_Controller_Router_Standard   $router     The router object.
     * @return  mixed
     * @throw   Hoa_Controller_Exception
     */
    public function preDispatcher ( Hoa_Controller_Request_Abstract $request,
                                    Hoa_Controller_Router_Standard  $router );

    /**
     * postDispatcher notification.
     *
     * @access  public
     * @param   Hoa_Controller_Request_Abstract     $request       The request
     *                                                             object.
     * @param   Hoa_Controller_Dispatcher_Abstract  $dispatcher    The dispatcher
     *                                                             object.
     * @param   string                              $dispatch      Dispatch
     *                                                             result.
     * @return  mixed
     * @throw   Hoa_Controller_Exception
     */
    public function postDispatcher ( Hoa_Controller_Request_Abstract    $request,
                                     Hoa_Controller_Dispatcher_Abstract $dispatcher,
                                     $dispatch );
}
