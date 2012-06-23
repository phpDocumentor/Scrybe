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

namespace phpDocumentor\Scrybe;

/**
 * Entry point for the Scrybe documentation tool.
 *
 * @author  Mike van Riel <mike.vanriel@naenius.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link    http://phpdoc.org
 */
class Application extends \Cilex\Application
{
    /** @var string Version number */
    const VERSION = "1.0.0a1";

    const LOGGER = 'logger';
    const CONVERTER_FACTORY = 'converter-factory';
    const TEMPLATE_FACTORY = 'template-factory';

    /**
     * Constructor that initializes the framework and commands.
     */
    function __construct()
    {
        parent::__construct('phpDocumentor Scrybe', self::VERSION);
        $this->addCommands();

        $this[self::LOGGER] = $this->share(function () {
            return \phpDocumentor\Scrybe\Logger::getInstance();
        });
        $this[self::CONVERTER_FACTORY] = $this->share(function () {
            return new \phpDocumentor\Scrybe\Converter\Factory();
        });
        $this[self::TEMPLATE_FACTORY] = $this->share(function () {
            return new \phpDocumentor\Scrybe\Template\Factory();
        });
    }

    /**
     * Method responsible for adding the commands for this application.
     *
     * @return void
     */
    protected function addCommands()
    {
        $this->command(new \phpDocumentor\Scrybe\Command\Manual\ToHtmlCommand());

// FIXME: Disabled the ToLatex and ToPdf commands for now to prevent confusion
//        of users.

//        $this->command(new \phpDocumentor\Scrybe\Command\Manual\ToLatexCommand());
//        $this->command(new \phpDocumentor\Scrybe\Command\Manual\ToPdfCommand());
    }
}
