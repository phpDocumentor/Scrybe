<?php
namespace phpDocumentor\Scrybe\Command\Manual;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputOption;
use \phpDocumentor\Scrybe\Converter\ConverterFactory;
use \phpDocumentor\Scrybe\File;

class ToHtmlCommand extends ConvertCommandAbstract
{
    protected $output_format = ConverterFactory::HTML;

    protected function configure()
    {
        parent::configure();

        $this->setName('manual:to-html')
            ->setDescription('Generates reference documentation as HTML');
    }
}
