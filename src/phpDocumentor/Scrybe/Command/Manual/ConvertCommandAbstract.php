<?php
namespace phpDocumentor\Scrybe\Command\Manual;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputOption;
use \phpDocumentor\Scrybe\Converter\ConverterFactory;
use \phpDocumentor\Scrybe\File;

abstract class ConvertCommandAbstract extends \Cilex\Command\Command
{
    protected $output_format = ConverterFactory::HTML;

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
            ->addArgument(
                'source', InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'One or more files or directories to fetch files from'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $converter = $this->getConverter($input);

        return $converter->execute(
            $this->buildCollection(
                $input->getArgument('source'), $output,
                $converter->getSourceExtension()
            )
        );
    }

    protected function getConverter($input)
    {
        $converter = ConverterFactory::get($input->getOption('input-format'), $this->output_format);
        $converter->setDestinationRoot($input->getOption('target'));
        return $converter;
    }

    protected function buildCollection(array $sources,
        OutputInterface $output, $extension)
    {
        $collection = new File\Collection();
        $finder = new \Symfony\Component\Finder\Finder();
        foreach ($sources as $path) {
            if (!file_exists($path)) {
                $output->writeln('Path "' . $path . '" does not exist, skipping');
                continue;
            }

            if (is_dir($path)) {
                $finder->files()->in($path)->name('*.'.$extension);
                continue;
            }

            $collection[] = new File\File($path);
        }
        $collection->addFromFinder($finder);
        return $collection;
    }
}
