<?php
namespace phpDocumentor\Scrybe;

/**
 * Test covering the Pandoc class.
 *
 * @see Pandoc
 */
class PandocTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Pandoc
     */
    protected $fixture;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->fixture = new Pandoc;
    }

    /**
     * @covers phpDocumentor\Scrybe\Pandoc::setDestinationFile
     * @covers phpDocumentor\Scrybe\Pandoc::getDestinationFile
     */
    public function testSettingAndGettingOfDestinationFile()
    {
        $this->fixture->setDestinationFile('/tmp/dest');
        $this->assertEquals('/tmp/dest', $this->fixture->getDestinationFile());
    }

    /**
     * @covers phpDocumentor\Scrybe\Pandoc::convert
     */
    public function testConvertRstToMarkdown()
    {
        $source_path = $this->getPreparedRstSourcePath();
        $collection  = new \phpDocumentor\Fileset\Collection();
        $collection->addFile($source_path);

        $resulting_markdown = $this->fixture->convert(
            'rst', 'markdown', $collection
        );

        $this->assertEquals(
            $this->getConvertedMarkdownFixture(), $resulting_markdown
        );
    }

    /**
     * @covers phpDocumentor\Scrybe\Pandoc::convert
     */
    public function testConvertRstToMarkdownToDestinationFile()
    {
        $source_path      = $this->getPreparedRstSourcePath();
        $destination_path = '/tmp/scrybe.pandoc.dest.rst';
        $collection       = new \phpDocumentor\Fileset\Collection();
        $collection->addFile($source_path);
        $this->fixture->setDestinationFile($destination_path);

        $result = $this->fixture->convert(
            'rst', 'markdown', $collection
        );

        $this->assertEquals('', $result);
        $this->assertEquals(
            $this->getConvertedMarkdownFixture(),
            file_get_contents($destination_path)
        );
    }

    /**
     * Prepares a RestructuredText sample and stores it on disc for use by
     * tests covering the convert method.
     *
     * @see getConvertedMarkdownFixture() for the Markdown results when this
     *     sample is converted.
     *
     * @return string
     */
    protected function getPreparedRstSourcePath()
    {
        $source_path = '/tmp/scrybe.pandoc.source.rst';
        file_put_contents($source_path, <<<RST
Heading 1
=========

Heading 2
---------

Heading 3
~~~~~~~~~
RST
        );
        return $source_path;
    }

    /**
     * Returns the Markdown representation of the prepared RestructuredText
     * sample.
     *
     * @see getPreparedRstSourcePath() for the RestructuredText sample.
     *
     * @return string
     */
    protected function getConvertedMarkdownFixture()
    {
        return <<<MD
# Heading 1

## Heading 2

### Heading 3

MD;
    }

}
