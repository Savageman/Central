<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2012, Ivan Enderlin. All rights reserved.
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
 * \Hoa\Xml\Read
 */
-> import('Xml.Read')

/**
 * \Hoa\File\Read
 */
-> import('File.Read');

}

namespace Hoa\Xml\Bin {

/**
 * Class \Hoa\Xml\Bin\Shell.
 *
 * Interactive XML shell.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2012 Ivan Enderlin.
 * @license    New BSD License
 */

class Shell extends \Hoa\Console\Dispatcher\Kit {

    /**
     * Options description.
     *
     * @var \Hoa\Xml\Bin\Shell array
     */
    protected $options = array(
        array('color', \Hoa\Console\GetOption::OPTIONAL_ARGUMENT, 'c'),
        array('help', \Hoa\Console\GetOption::NO_ARGUMENT,        'h'),
        array('help', \Hoa\Console\GetOption::NO_ARGUMENT,        '?')
    );

    /**
     * Current color level (among: 1, 8 and 256).
     *
     * @var \Hoa\Xml\Bin\Shell int
     */
    protected $_color  = 1;

    /**
     * Palette.
     *
     * @var \Hoa\Xml\Bin\Shell array
     */
    protected $_colors = array(
        8 => array(
            'oc'        => '34',
            'tagname'   => '32',
            'attrname'  => '34',
            'attrvalue' => '34',
            '='         => '34',
            'q'         => '34',
            'comment'   => '37',
            'pi'        => '35',
            'entity'    => '37',
            'text'      => '33'
        ),
        256 => array(
            'oc'        => '38;5;240',
            'tagname'   => '38;5;64',
            'attrname'  => '38;5;245',
            'attrvalue' => '38;5;136',
            '='         => '38;5;240',
            'q'         => '38;5;240',
            'comment'   => '38;5;241',
            'pi'        => '38;5;125',
            'entity'    => '38;5;255',
            'text'      => '38;5;166'
        )
    );



    /**
     * The entry method.
     *
     * @access  public
     * @return  int
     */
    public function main ( ) {

        $filename = null;

        while(false !== $c = $this->getOption($v)) switch($c) {

            case 'c':
                $v = true === $v ? 256 : intval($v);

                switch($v) {

                    case 1:
                    case 8:
                    case 256:
                        $this->_color = $v;
                      break;
                }
              break;

            case 'h':
            case '?':
                return $this->usage();
              break;

            case '__ambiguous':
                $this->resolveOptionAmbiguity($v);
              break;
        }

        $this->parser->listInputs($filename);

        if(null === $filename)
            return $this->usage();

        $line = 'load ' . $filename;

        do {

            try {

                @list($command, $argument) = preg_split('#\s+#', $line, 2);

                switch($command) {

                    case 'load':
                        if('%' === $argument) {

                            $root = new \Hoa\Xml\Read(
                                new \Hoa\File\Read(
                                    $root->getInnerStream()->getStreamName()
                                ),
                                false
                            );
                            cout('Reloaded!');
                        }
                        else {

                            $root = new \Hoa\Xml\Read(
                                new \Hoa\File\Read($argument),
                                false
                            );
                            cout('Loaded!');
                        }

                        $current = $root;
                        cout();

                    case 'h':
                    case 'help':
                        cout('Usage:');
                        cout('    h[elp] to print this help;');
                        cout('    %      to print loaded filename;');
                        cout('    load   to load a file (`load %` to reload);');
                        cout('    ls     to print current tree;');
                        cout('    cd     to move in the tree with XPath;');
                        cout('    pwd    to print the current path;');
                        cout('    color  to change color (among 1, 8 and 256);');
                        cout('    q[uit] to quit.');
                        cout();
                      break;

                    case '%':
                        cout($root->getInnerStream()->getStreamName());
                      break;

                    case 'ls':
                        cout(
                            $this->cout($current->readDOM()),
                            \Hoa\Console\Io::NEW_LINE,
                            \Hoa\Console\Io::NO_WORDWRAP
                        );
                      break;

                    case 'cd':
                        if(null === $argument) {

                            cout('Need an argument.');

                            break;
                        }

                        $handle = $current->xpath($argument);

                        if(empty($handle)) {

                            cout($argument . ' is not found.');

                            break;
                        }

                        $current = $handle[0];
                      break;

                    case 'pwd':
                        cout($current->readDOM()->getNodePath());
                      break;

                    case 'color':
                        $argument = intval($argument);

                        if(     1 !== $argument
                           &&   8 !== $argument
                           && 256 !== $argument) {

                            cout($argument . ' is not valid color (1, 8 or 256).');

                            break;
                        }

                        $this->_color = $argument;
                      break;

                    case 'q':
                    case 'quit':
                        cout('Bye bye!');
                      break 2;

                    default:
                        if(!empty($command))
                            cout('Command ' . $command . ' not found.');
                }
            }
            catch ( \Hoa\Core\Exception $e ) {

                cout($e->getFormattedMessage());

                continue;
            }

            cout();

        } while('quit' != $line = $this->readLine('> '));

        return;
    }

    /**
     * The command usage.
     *
     * @access  public
     * @return  int
     */
    public function usage ( ) {

        cout('Usage   : xml:shell <options> [filename]');
        cout('Options :');
        cout($this->makeUsageOptionsList(array(
            'c'    => 'Allowed colors number among 1, 8 and 256 (default).',
            'help' => 'This help.'
        )));

        return;
    }

    /**
     * Pretty print XML tree.
     *
     * @access  public
     * @param   \DOMNode  $element    Element.
     * @return  string
     */
    public function cout ( \DOMNode $element ) {

        if(1 === $this->_color)
            return $element->C14N();

        $out   = null;
        $nodes = $element->childNodes;

        for($i = 0, $max = $nodes->length; $i < $max; ++$i) {

            $node = $nodes->item($i);

            switch($node->nodeType) {

                case XML_ELEMENT_NODE:
                    $out .= $this->color('<', 'oc') .
                            $this->color($node->tagName, 'tagname');

                    foreach($node->attributes as $attr)
                        $out .= ' ' .
                                $this->color($attr->name, 'attrname') .
                                $this->color('=', '=') .
                                $this->color('"', 'q') .
                                $this->color($attr->value, 'attrvalue') .
                                $this->color('"', 'q');

                    $out .= $this->color('>', 'oc') .
                            $this->cout($node) .
                            $this->color('</', 'oc') .
                            $this->color($node->tagName, 'tagname') .
                            $this->color('>', 'oc');
                  break;

                case XML_TEXT_NODE:
                    $out .= $this->color($node->wholeText, 'text');
                  break;

                case XML_CDATA_SECTION_NODE:
                  break;

                case XML_ENTITY_REF_NODE:
                    $out .= $this->color('&' . $node->name . ';', 'entity');
                  break;

                case XML_ENTITY_NODE:
                  break;

                case XML_PI_NODE:
                    $out .= $this->color(
                        '<?' . $node->target. ' ' . $node->data . '?>',
                        'pi'
                    );
                  break;

                case XML_COMMENT_NODE:
                    $out .= $this->color(
                        '<!--' . $node->data . '-->',
                        'comment'
                    );
                  break;

                default:
                    var_dump($node->nodeType);
            }
        }

        return $out;
    }

    /**
     * Use colors.
     *
     * @access  public
     * @param   string  $text     Text.
     * @param   string  $token    Token.
     * @return  string
     */
    public function color ( $text, $token ) {

        return '[' . $this->_colors[$this->_color][$token] . 'm' .
               $text .
               '[0m';
    }
}

}
