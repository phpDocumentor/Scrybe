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

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Singleton logger class to send logging output to the Symfony Console.
 *
 * @todo replace this solution with something more sturdy such as monolog
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class Logger
{
    /** @var Logger */
    static $instance = null;

    /** @var OutputInterface */
    protected $output = null;

    /**
     * Sets an instance of this class.
     *
     * This method is mainly used for Unit testing as it provides an interface
     * to insert mock objects.
     *
     * @param Logger $instance
     *
     * @return void
     */
    public static function setInstance($instance)
    {
        self::$instance = $instance;
    }

    /**
     * Returns the instance of this singleton; create a new one if none present.
     *
     * @return Logger
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Sets the Output class of Symfony2's Console component where to route
     * logging to.
     *
     * @param OutputInterface $output
     *
     * @return void
     */
    public function setConsoleOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * Logs a message with the info colouring.
     *
     * @param string $message
     *
     * @return void
     */
    public function info($message)
    {
        $this->log('<info>' . $message . '</info>');
    }

    /**
     * Logs a message with the warning colouring.
     *
     * @param string $message
     *
     * @return void
     */
    public function warning($message)
    {
        $this->log('<comment>' . $message . '</comment>');
    }

    /**
     * Logs a message with the error colouring.
     *
     * @param string $message
     *
     * @return void
     */
    public function error($message)
    {
        $this->log('<error>' . $message . '</error>');
    }

    /**
     * Logs a message without colouring.
     *
     * @param string $message
     *
     * @return void
     */
    public function log($message = '')
    {
        if ($this->output) {
            $this->output->writeln($message);
        }
    }

}
