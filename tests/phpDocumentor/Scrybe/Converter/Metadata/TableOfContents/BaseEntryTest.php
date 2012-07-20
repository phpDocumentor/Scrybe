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

namespace phpDocumentor\Scrybe\Converter\Metadata\TableOfContents;

class BaseEntryStub extends BaseEntry {};

/**
 * Test class for the BaseEntry object.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class BaseEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseEntry
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new BaseEntryStub();
    }

    /**
     * @covers phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\BaseEntry::getParent
     * @covers phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\BaseEntry::setParent
     */
    public function testAddingAParentEntry()
    {
        $this->assertSame(null, $this->object->getParent());

        $heading = new Heading();
        $this->object->setParent($heading);

        $this->assertSame($heading, $this->object->getParent());
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @covers phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\BaseEntry::setParent
     */
    public function testAddingAnInvalidParentEntry()
    {
        $toc = new \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents();
        $this->object->setParent($toc);
    }

    /**
     * @covers phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\BaseEntry::getChildren
     * @covers phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\BaseEntry::addChild
     */
    public function testAddingChildren()
    {
        $this->assertEmpty($this->object->getChildren());

        $heading = new Heading();
        $this->object->addChild($heading);

        $this->assertCount(1, $this->object->getChildren());
        $this->assertSame(array($heading), $this->object->getChildren());
    }

    /**
     * @covers phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\BaseEntry::getName
     * @covers phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\BaseEntry::setName
     */
    public function testSettingAName()
    {
        $this->assertSame('', $this->object->getName());

        $this->object->setName('name');

        $this->assertSame('name', $this->object->getName());
    }

}
