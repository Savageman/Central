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
 */

namespace {

from('Hoa')

/**
 * \Hoa\Console\Chrome\Exception
 */
-> import('Console.Chrome.Exception')

/**
 * \Hoa\Console\Core\Io
 */
-> import('Console.Core.Io');

}

namespace Hoa\Console\Chrome {

/**
 * Class \Hoa\Console\Chrome\Animation.
 *
 * This class allows to make an animation on a single line (by using the \r
 * special char, not with cleaning screen for each animation frame).
 * See the self::render() method to know tips.
 *
 * @author     Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright (c) 2007-2011 Ivan ENDERLIN.
 * @license    New BSD License
 */

abstract class Animation {

    /**
     * The animation parameters. Should be overload by childs.
     *
     * @var \Hoa\Console\Chrome\Animation
     */
    protected $parameters = array();



    /**
     * Built an animation and set parameters.
     *
     * @access  public
     * @param   array   $parameters    Animation parameters.
     * @return  void
     * @throw   \Hoa\Console\Chrome\Exception
     */
    public function __construct ( Array $parameters = array() ) {

        $this->setParameters($parameters);
    }

    /**
     * Set a group of parameters.
     *
     * @access  public
     * @param   array   $parameters    Animation parameters.
     * @return  void
     * @throw   \Hoa\Console\Chrome\Exception
     */
    public function setParameters ( Array $parameters ) {

        foreach($parameters as $parameter => $value)
            $this->setParameter($parameter, $value);
    }

    /**
     * Set a specific parameter.
     *
     * @access  public
     * @param   string  $parameter    The parameter name.
     * @param   mixed   $value        The parameter value.
     * @return  mixed
     * @throw   \Hoa\Console\Chrome\Exception
     */
    public function setParameter ( $parameter, $value ) {

        if(false === $this->parameterExists($parameter))
            throw new \Hoa\Console\Chrome\Exception(
                'The %s parameter does not exist.', 0, $parameter);

        $old                          = $this->parameters[$parameter];
        $this->parameters[$parameter] = $value;

        return $old;
    }

    /**
     * Get a specific parameter value.
     *
     * @access  public
     * @param   string  $parameter    The parameter name.
     * @return  mixed
     * @throw   \Hoa\Console\Chrome\Exception
     */
    public function getParameter ( $parameter ) {

        if(false === $this->parameterExists($parameter))
            throw new \Hoa\Console\Chrome\Exception(
                'The %s parameter does not exist.', 1, $parameter);

        return $this->parameters[$parameter];
    }

    /**
     * Check if a parameter already exist.
     *
     * @access  public
     * @param   string  $parameter    The parameter name.
     * @return  bool
     */
    public function parameterExists ( $parameter ) {

        return    isset($this->parameters[$parameter])
               && null !== $this->parameters[$parameter];
    }

    /**
     * Make a render of an animation.
     * The animation is cut in different frames. Each frame is generated by
     * calling the self::animationFrame() method that returns the current frame
     * number. This number is given to the self::animationRender() method that
     * returns the painted frame.
     * The animation frame number is given by calling the
     * self::animationFrameMax() method.
     *
     * @access  public
     * @return  int
     */
    final public function render ( ) {

        $i   = 0;
        $max = $this->animationFrameMax();

        while($i < $max) {

            $i      = $this->animationFrame($i);
            $render = $this->animationRender($i, $max);

            \Hoa\Console\Core\Io::cout(
                "\r" . $render,
                \Hoa\Console\Core\Io::NO_NEW_LINE
            );
        }

        return $i;
    }

    /**
     * A render calls the self::animationFrameMax() method to get the max number
     * of frame that the animation has.
     *
     * @acccess  protected
     * @return   int
     */
    abstract protected function animationFrameMax ( );

    /**
     * A render calls the self::animationFrame() method to get the current
     * frame number.
     *
     * @access  protected
     * @param   int        $i    The previous frame number.
     * @return  int
     */
    abstract protected function animationFrame ( $i );

    /**
     * And finally, a render calls the self::animationRender() method to get
     * the string/render of the current frame (given by $i).
     *
     * @access  protected
     * @param   int        $i      The current frame number.
     * @param   int        $max    Max number of frame.
     * @return  string
     * @throw   \Hoa\Console\Chrome\Exception
     */
    abstract protected function animationRender ( $i, $max );
}

}
