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

namespace phpDocumentor\Scrybe\Converter\RestructuredText;

use phpDocumentor\Scrybe\Converter\ToHtmlInterface;
use phpDocumentor\Fileset\File;
use phpDocumentor\Scrybe\Converter\Definition;
use phpDocumentor\Scrybe\Converter\BaseConverter;
use phpDocumentor\Scrybe\Logger;
use phpDocumentor\Scrybe\Template\TemplateInterface;

class ToHtml extends BaseConverter implements ToHtmlInterface
{
    /** @var \ezcDocumentRstOptions */
    protected $options;

    /**
     * Discovers the data that is spanning all files.
     *
     * This method tries to find any data that needs to be collected before
     * the actual creation and substitution phase begins.
     *
     * Examples of data that needs to be collected during an initial phase is
     * a table of contents, list of document titles for references, assets
     * and more.
     *
     * @see manual://extending#build_cycle for more information regarding the
     *     build process.
     *
     * @return void
     */
    protected function discover()
    {
        /** @var File $file */
        foreach($this->fileset as $file) {
            $rst = new Document($this, $file);
            $rst->options->xhtmlVisitor
                = 'phpDocumentor\Scrybe\Converter\RestructuredText\Visitors\Discover';

            Logger::getInstance()->log(
                '> Scanning file "' . $file->getRealPath() . '"'
            );

            try {
                $rst->getAsXhtml();
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    /**
     * Converts the input files into one or more output files in the intended
     * format.
     *
     * This method reads the files, converts them into the correct format and
     * returns the contents of the conversion if the destination is
     * scrybe://result or writes the files directly to the destination location.
     *
     * The template is used to decorate the individual files and can be obtained
     * using the `\phpDocumentor\Scrybe\Template\Factory` class.
     *
     * @param TemplateInterface $template
     *
     * @see manual://extending#build_cycle for more information regarding the
     *     build process.
     *
     * @return string[]|null The contents of the resulting file(s) or null if
     *     the files are written directly to file.
     */
    protected function create(TemplateInterface $template)
    {
        $result = array();

        /** @var File $file */
        foreach($this->fileset as $file) {
            $rst = new Document($this, $file);

            Logger::getInstance()->log(
                '> Parsing file "' . $file->getRealPath() . '"'
            );

            try {
                $xhtml_document = $rst->getAsXhtml();
                $converted_contents = $template->decorate(
                    $xhtml_document->save()
                );
                $rst->logStats();
            } catch(\Exception $e) {
                $rst->logStats($e);
                continue;
            }

            $destination = $this->getDestinationFilenameRelativeToProjectRoot(
                $file
            );
            $result[$destination] = $converted_contents;
        }

        return $result;
    }

}
