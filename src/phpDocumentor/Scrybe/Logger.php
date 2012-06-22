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

class Logger
{
    /** @var Logger */
    static $instance = null;

    /** @var OutputInterface */
    protected $output = null;

    public static function setInstance($instance)
    {
        self::$instance = $instance;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setConsoleOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function info($message)
    {
        if ($this->output) {
            $this->output->writeln('<info>'.$message.'</info>');
        }
    }

    public function warning($message)
    {
        if ($this->output) {
            $this->output->writeln('<comment>'.$message.'</comment>');
        }
    }

    public function error($message)
    {
        if ($this->output) {
            $this->output->writeln('<error>'.$message.'</error>');
        }
    }

    public function log($message = '')
    {
        if ($this->output) {
            $this->output->writeln($message);
        }
    }

}
