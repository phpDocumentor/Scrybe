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

/**
 * @property \ezcDocumentRstOptions $options
 */
class Document extends \ezcDocumentRst
{
    protected $meta_data = array();

    function __construct(File $file)
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
        $this->registerRole(
            'doc', 'phpDocumentor\Scrybe\Converter\RestructuredText\Roles\Doc'
        );

        $this->loadString($file->fread());
    }

    public function setMetaData($name, $value)
    {
        $this->meta_data[$name] = $value;
    }

    public function getMetaData($name)
    {
        return isset($this->meta_data[$name]) ? $this->meta_data[$name] : null;
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

