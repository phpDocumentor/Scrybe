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

use phpDocumentor\Scrybe\Logger;
use phpDocumentor\Fileset\File;
use phpDocumentor\Scrybe\Converter\ConverterInterface;

/**
 * @property \ezcDocumentRstOptions $options
 */
class Document extends \ezcDocumentRst
{
    protected $file;
    protected $converter;

    function __construct(ConverterInterface $converter, File $file)
    {
        parent::__construct();

        $this->options->xhtmlVisitor = 'ezcDocumentRstXhtmlBodyVisitor';
        $this->options->errorReporting = E_PARSE | E_ERROR;

        $this->registerDirective(
            'toctree',
            'phpDocumentor\Scrybe\Converter\RestructuredText\Directives\Toctree'
        );
        $this->registerDirective(
            'image',
            'phpDocumentor\Scrybe\Converter\RestructuredText\Directives\Image'
        );
        $this->registerDirective(
            'figure',
            'phpDocumentor\Scrybe\Converter\RestructuredText\Directives\Figure'
        );
        $this->registerRole(
            'doc', 'phpDocumentor\Scrybe\Converter\RestructuredText\Roles\Doc'
        );

        $this->file = $file;
        $this->converter = $converter;
        $this->loadString($file->fread());
    }

    /**
     * Returns the converter responsible for converting this object.
     *
     * @return \phpDocumentor\Scrybe\Converter\ConverterInterface
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * Returns the file associated with this document.
     *
     * @return \phpDocumentor\Fileset\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sends the errors of the given Rst document to the logger as a block.
     *
     * If a fatal error occurred then this can be passed as the $fatal argument
     * and is shown as such.
     *
     * @param \Exception|null $fatal
     *
     * @return void
     */
    public function logStats(\Exception $fatal = null)
    {
        if (!$this->getErrors() && !$fatal) {
            return;
        }

        Logger::getInstance()->log();

        /** @var \Exception $error */
        foreach ($this->getErrors() as $error) {
            Logger::getInstance()->warning('  ' . $error->getMessage());
        }
        if ($fatal) {
            Logger::getInstance()->error('  ' . $fatal->getMessage());
        }
        Logger::getInstance()->log();
    }

}

