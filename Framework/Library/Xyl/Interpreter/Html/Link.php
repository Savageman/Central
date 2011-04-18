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
 * \Hoa\Xyl\Interpreter\Html\Concrete
 */
-> import('Xyl.Interpreter.Html.Concrete')

/**
 * \Hoa\Xyl\Element\Executable
 */
-> import('Xyl.Element.Executable')

/**
 * \Hoa\Xml\Element\Model\Phrasing
 */
-> import('Xml.Element.Model.Phrasing');

}

namespace Hoa\Xyl\Interpreter\Html {

/**
 * Class \Hoa\Xyl\Interpreter\Html\Link.
 *
 * The <link /> component.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2011 Ivan Enderlin.
 * @license    New BSD License
 */

class          Link
    extends    Concrete
    implements \Hoa\Xyl\Element\Executable,
               \Hoa\Xml\Element\Model\Phrasing {

    /**
     * Extra attributes.
     *
     * @var \Hoa\Xyl\Interpreter\Html\Concrete array
     */
    protected $iAttributes = array(
        'href' => null,
    );

    /**
     * Extra attributes mapping.
     *
     * @var \Hoa\Xyl\Interpreter\Html\Concrete array
     */
    protected $attributesMapping = array(
        'href' => 'href'
    );



    /**
     * Paint the element.
     *
     * @access  protected
     * @param   \Hoa\Stream\IStream\Out  $out    Out stream.
     * @return  void
     */
    protected function paint ( \Hoa\Stream\IStream\Out $out ) {

        $this->writeAttribute(
            'href',
            $this->computeAttributeValue(
                'href',
                $this->abstract->readCustomAttributes('href')
            )
        );
        $out->writeAll('<a' . $this->readAttributesAsString() . '>');
        $this->computeValue($out);
        $out->writeAll('</a>');

        return;
    }

    /**
     * Pre-execute an element.
     *
     * @access  public
     * @return  void
     */
    public function preExecute ( ) {

        return;
    }

    /**
     * Post-execute an element.
     *
     * @access  public
     * @return  void
     */
    public function postExecute ( ) {

        $this->computeStaticReference();
        $this->computeHyperReference();

        return;
    }

    protected function computeHyperReference ( ) {

        if(false === $this->abstract->attributeExists('href'))
            return;

        $this->abstract->writeAttribute(
            'href',
            $this->computeLink($this->abstract->readAttribute('href'))
        );

        return;
    }

    protected function computeStaticReference ( ) {

        if(false === $this->abstract->attributeExists('sref'))
            return;

        $this->abstract->writeAttribute(
            'sref',
            $this->computeLink($this->abstract->readAttribute('sref'))
        );

        return;
    }
}

}
