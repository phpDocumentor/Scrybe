<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2012 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Scrybe\Template;

require_once 'Mock/Template.php';

/**
 * Test for the Template\Factory class of phpDocumentor Scrybe.
 *
 * @author  Mike van Riel <mike.vanriel@naenius.com>
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests whether a Template can be registered using the constructor.
     *
     * @covers \phpDocumentor\Scrybe\Template\Factory::__construct
     */
    public function testRegisterTemplateEngineViaConstructor()
    {
        $factory = new Factory(
            array('Mock' => '\phpDocumentor\Scrybe\Template\Mock\Template')
        );

        $this->assertInstanceOf(
            '\phpDocumentor\Scrybe\Template\Mock\Template', $factory->get('Mock')
        );
    }

    /**
     * Tests whether this factory registers the twig template engine by default.
     * @covers \phpDocumentor\Scrybe\Template\Factory
     */
    public function testHasTwigTemplateEngine()
    {
        $factory = new Factory();
        $this->assertInstanceOf(
            '\phpDocumentor\Scrybe\Template\Twig', $factory->get('twig')
        );
    }

    /**
     * Tests whether a Template could be registered using the register method.
     *
     * @covers \phpDocumentor\Scrybe\Template\Factory::register
     */
    public function testRegisterTemplateEngine()
    {
        $factory = new Factory();
        $factory->register('Mock', '\phpDocumentor\Scrybe\Template\Mock\Template');
        $this->assertInstanceOf(
            '\phpDocumentor\Scrybe\Template\Mock\Template', $factory->get('Mock')
        );
    }

    /**
     * \phpDocumentor\Scrybe\Template\Factory::register
     * @expectedException \InvalidArgumentException
     */
    public function testRegisterInvalidName()
    {
        $factory = new Factory();
        $factory->register(array(), '');
    }

    /**
     * \phpDocumentor\Scrybe\Template\Factory::register
     * @expectedException \InvalidArgumentException
     */
    public function testRegisterInvalidClassName()
    {
        $factory = new Factory();
        $factory->register('', array());
    }

    /**
     * @covers \phpDocumentor\Scrybe\Template\Factory::get
     * @expectedException \InvalidArgumentException
     */
    public function testGetUnknownTemplateEngine()
    {
        $factory = new Factory();
        $factory->get('Mock');
    }

    /**
     * @covers \phpDocumentor\Scrybe\Template\Factory::get
     * @expectedException \RuntimeException
     */
    public function testGetInvalidTemplateEngine()
    {
        $factory = new Factory();
        $factory->register('Mock', '\DOMDocument');
        $factory->get('Mock');
    }
}

