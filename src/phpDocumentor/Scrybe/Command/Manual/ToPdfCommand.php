<?php
namespace phpDocumentor\Scrybe\Command\Manual;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputOption;
use \phpDocumentor\Scrybe\Converter\ConverterFactory;
use \phpDocumentor\Scrybe\File;

class ToPdfCommand extends ConvertCommandAbstract
{
    protected $output_format = ConverterFactory::PDF;

    protected function configure()
    {
        parent::configure();

        $this->setName('manual:to-pdf')
            ->setDescription('Generates reference documentation as PDF file')
            ->addOption(
                'title', null, InputOption::VALUE_OPTIONAL,
                'The title of this document'
            )
            ->addOption(
                'author', null, InputOption::VALUE_OPTIONAL,
                'Name of the author'
            )
            ->addOption(
                'cover-logo', null, InputOption::VALUE_OPTIONAL,
                'Path to a cover logo relative to the source root'
            )
            ->addOption(
                'toc', null, InputOption::VALUE_OPTIONAL,
                'Whether the document should have a table of contents',
                true
            );
    }

    protected function getConverter(InputInterface $input)
    {
        /** @var \phpDocumentor\Scrybe\Converter\Markdown2Pdf $converter  */
        $converter = parent::getConverter($input);
        $converter->setTitle($input->getOption('title'));
        $converter->setAuthor($input->getOption('author'));
        $converter->setCoverLogo($input->getOption('cover-logo'));
        $converter->setTableOfContents($input->getOption('toc') !== 'false');

        return $converter;
    }
}
