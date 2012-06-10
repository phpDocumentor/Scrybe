<?php
/**
 * phpDocumentor
 *
 * PHP Version 5
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2010-2011 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Scrybe;

/**
 * Test for the Application class of phpDocumentor Scrybe.
 *
 * @author  Mike van Riel <mike.vanriel@naenius.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link    http://phpdoc.org
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectNameAndVersion()
    {
        $fixture = new Application();
        $this->assertEquals('phpDocumentor Scrybe', $fixture['console']->getName());
        $this->assertEquals(Application::VERSION, $fixture['console']->getVersion());
    }

    /**
     * Tests whether the application has initialized the manual:to-pdf Command.
     *
     * @return void
     */
    public function testContainsToPdfCommand()
    {
        $fixture = new Application();
        $this->assertTrue($fixture['console']->has('manual:to-pdf'));
    }

    /**
     * Tests whether the application has initialized the manual:to-html Command.
     *
     * @return void
     */
    public function testContainsToHtmlCommand()
    {
        $fixture = new Application();
        $this->assertTrue($fixture['console']->has('manual:to-html'));
    }
}
