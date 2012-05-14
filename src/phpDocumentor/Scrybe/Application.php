<?php
namespace phpDocumentor\Scrybe;

/**
 * Entry point for the Scrybe.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class Application extends \Cilex\Application
{
    /** @var string Version number */
    const VERSION = "1.0.0a1";

    /**
     * Constructor that initializes the framework and commands.
     */
    function __construct()
    {
        parent::__construct('phpDocumentor Scrybe', self::VERSION);
        $this->addCommands();
    }

    /**
     * Method responsible for adding the commands for this application.
     *
     * @return void
     */
    protected function addCommands()
    {
        $this->command(new \phpDocumentor\Scrybe\Command\Manual\ToHtmlCommand());
        $this->command(new \phpDocumentor\Scrybe\Command\Manual\ToPdfCommand());
    }
}
