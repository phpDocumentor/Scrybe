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

/**
 * Test file for the File entry type.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingAFilename()
    {
        $file = new File();
        $file->setFilename('test');

        $this->assertSame('test', $file->getFilename());
    }
}
