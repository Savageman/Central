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
 * \Hoa\Cache\Exception
 */
-> import('Cache.Exception')

/**
 * \Hoa\Cache\Backend
 */
-> import('Cache.Backend.~');

}

namespace Hoa\Cache\Backend {

/**
 * Class \Hoa\Cache\Backend\Eaccelerator.
 *
 * Eaccelerator backend manager.
 * EAccelerator is an extension, take care that EAccelerator is loaded.
 *
 * @author     Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright (c) 2007, 2011 Ivan ENDERLIN.
 * @license    http://gnu.org/licenses/gpl.txt GNU GPL
 */

class Eaccelerator extends Backend {

    /**
     * Check if EAccelerator is loaded, else an exception is thrown.
     *
     * @access  public
     * @param   array   $parameters    Parameters.
     * @return  void
     * @throw   \Hoa\Cache\Exception
     */
    public function __construct ( Array $parameters = array() ) {

        if(!extension_loaded('eaccelerator'))
            throw new \Hoa\Cache\Exception(
                'EAccelerator is not loaded on server.', 0);

        parent::__construct($parameters);

        return;
    }

    /**
     * Save cache content in EAccelerator store.
     * All data is obligatory serialized.
     *
     * @access  public
     * @param   mixed  $data    Data to store.
     * @return  void
     */
    public function store ( $data ) {

        $this->clean();

        return eaccelerator_put(
            $this->getIdMd5(),
            serialize($data),
            $this->getParameter('lifetime')
        );
    }

    /**
     * Load data from EAccelerator cache.
     * Data is obligatory unseralized, please see the self::save() method.
     *
     * @access  public
     * @return  void
     */
    public function load ( ) {

        $this->clean();

        $content = eaccelerator_get($this->getIdMd5());

        return unserialize($content);
    }

    /**
     * Clean expired cache.
     * Note : \Hoa\Cache::CLEAN_USER is not supported, it's reserved for APC
     * backend.
     *
     * @access  public
     * @param   int  $lifetime    Lifetime of caches.
     * @return  void
     * @throw   \Hoa\Cache\Exception
     */
    public function clean ( $lifetime = \Hoa\Cache::CLEAN_EXPIRED ) {

        switch($lifetime) {

            case \Hoa\Cache::CLEAN_ALL:
                $infos = eaccelerator_list_keys();

                // EAccelerator bug (http://eaccelerator.net/ticket/287).
                foreach($infos as $foo => $info) {

                    $key = 0 === strpos($info['name'], ':')
                               ? substr($info['name'], 1)
                               : $info['name'];

                    if(false === eaccelerator_rm($key))
                        throw new \Hoa\Cache\Exception(
                            'Remove all existing cache file failed (maybe for the %s cache).',
                            1, $key);
                }
              break;

            case \Hoa\Cache::CLEAN_EXPIRED:
                // Manage by EAccelerator.
              break;

            case \Hoa\Cache::CLEAN_USER:
                throw new \Hoa\Cache\Exception(
                    '\Hoa\Cache::CLEAN_USER constant is not supported by ' .
                    'EAccelerator backend.', 2);

            default:
                return;
        }

        return;
    }

    /**
     * Remove a cache data.
     *
     * @access  public
     * @return  void
     */
    public function remove ( ) {

        eaccelerator_rm($this->getIdMd5());

        return;
    }
}

}
