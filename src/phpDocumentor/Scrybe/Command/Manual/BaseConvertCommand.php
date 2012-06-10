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

namespace phpDocumentor\Scrybe\Command\Manual;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use phpDocumentor\Scrybe\Converter\Factory;
use phpDocumentor\Scrybe\Converter\Format;
use phpDocumentor\Scrybe\Application;

/**
 * Abstract Command class containing the scaffolding for the subsequent
 * converting commands.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
abstract class BaseConvertCommand extends \Cilex\Command\Command
{
    /** @var int Returned by the execute method to indicate success */
    const RETURNCODE_OK    = 0;

    /** @var int Returned by the execute method to indicate a general error */
    const RETURNCODE_ERROR = 1;

    /** @var string The string representation of the output format */
    protected $output_format = Format\Format::HTML;

    /**
     * Configures the options and default help text.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->addOption(
                'target', 't', InputOption::VALUE_OPTIONAL,
                'target location for output', 'build'
            )
            ->addOption(
                'input-format', 'i', InputOption::VALUE_OPTIONAL,
                'which input format does the documentation sources have?',
                'markdown'
            )
            ->addOption(
                'template', null, InputOption::VALUE_OPTIONAL,
                'which template should be used to generate the documentation?',
                'layout'
            )
            ->addArgument(
                'source', InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'One or more files or directories to fetch files from'
            );

        $supported_formats = '  * '.implode(
            PHP_EOL.'  * ', array()
//            $this->getConverterFactory()->getSupportedInputFormats(
//                $this->output_format
//            )
        );

        $this->setHelp(
            <<<DESCRIPTION
Generates reference documentation as {$this->output_format}.

You can define the type of files use as input using the <info>--input-format</info>
of <info>-i</info> option.

This specific command supports the following input formats:

$supported_formats
DESCRIPTION
        );
    }

    /**
     * Execute the transformation process to an output format as defined in the
     * $output_format class variable.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @see $output_format to determine the output format.
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \phpDocumentor\Scrybe\Logger $logger  */
        $logger = $this->getService(Application::LOGGER);
        $logger->setConsoleOutput($output);

        try {
            $converter = $this->getConverter($input);

            echo $converter->convert(
                $this->buildCollection(
                    $input->getArgument('source'),
                    $converter->getDefinition()->getInputFormat()->getExtensions()
                ),
                $input->getOption('target'),
                $this->getTemplate($input)
            );
        } catch(\Exception $e) {
            $logger->error($e->getMessage());
            return self::RETURNCODE_ERROR;
        }

        return self::RETURNCODE_OK;
    }

    /**
     * Returns a template object based off the human-readable template name.
     *
     * @param InputInterface $input
     *
     * @return \phpDocumentor\Scrybe\Template\TemplateInterface
     */
    protected function getTemplate(InputInterface $input)
    {
        /** @var \phpDocumentor\Scrybe\Template\Factory $template_factory  */
        $template_factory = $this->getService(Application::TEMPLATE_FACTORY);
        $template = $template_factory->get('twig');
        $template->setName($input->getOption('template'));
        return $template;
    }

    /**
     * Returns the converter for this operation.
     *
     * @param InputInterface $input
     *
     * @return \phpDocumentor\Scrybe\Converter\ConverterInterface
     */
    protected function getConverter(InputInterface $input)
    {
        return $this->getConverterFactory()->get(
            $input->getOption('input-format'), $this->output_format
        );
    }

    /**
     * Returns the factory for converters.
     *
     * @return Converter\Factory
     */
    public function getConverterFactory()
    {
        return $this->getService(Application::CONVERTER_FACTORY);
    }

    /**
     * Constructs a Fileset collection and returns that.
     *
     * @param array $sources    List of source paths.
     * @param array $extensions List of extensions to scan for in directories.
     *
     * @return \phpDocumentor\Fileset\Collection
     */
    protected function buildCollection(array $sources, array $extensions)
    {
        $collection = new \phpDocumentor\Fileset\Collection();
        $collection->setAllowedExtensions($extensions);
        foreach ($sources as $path) {
            if (is_dir($path)) {
                $collection->addDirectory($path);
                continue;
            }

            $collection->addFile($path);
        }

        return $collection;
    }
}
