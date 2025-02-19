<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\Command;

use Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormatRegistry;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'ibexa:system-info:dump',
    description: 'Collects system information and dumps it.',
    aliases: [
        'ez-support-tools:dump-info',
        'ibexa:dump-info',
        'ibexa:info',
    ]
)]
final class SystemInfoDumpCommand extends Command
{
    private SystemInfoCollectorRegistry $systemInfoCollectorRegistry;

    private OutputFormatRegistry $outputFormatRegistry;

    public function __construct(SystemInfoCollectorRegistry $systemInfoCollectorRegistry, OutputFormatRegistry $outputFormatRegistry)
    {
        $this->systemInfoCollectorRegistry = $systemInfoCollectorRegistry;
        $this->outputFormatRegistry = $outputFormatRegistry;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp(
                <<<'EOD'
By default it dumps information from all available information collectors.
You can specify one or more collectors as arguments, e.g. 'php database hardware'.
To get a list if available collectors, use '--list-info-collectors'
EOD
            )
            ->addOption(
                'list-info-collectors',
                null,
                InputOption::VALUE_NONE,
                'List all available information collectors, and exit.'
            )
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_OPTIONAL,
                'Output format (currently only JSON)',
                'json'
            )
            ->addArgument(
                'info-collectors',
                InputArgument::IS_ARRAY,
                'Which information collector(s) should be used? (separate multiple names with spaces)'
            )
        ;
    }

    /**
     * Execute the Command.
     *
     * @param $input InputInterface
     * @param $output OutputInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('list-info-collectors')) {
            $output->writeln('Available info collectors:', OutputInterface::OUTPUT_NORMAL);
            foreach ($this->systemInfoCollectorRegistry->getIdentifiers() as $identifier) {
                $output->writeln("  $identifier", OutputInterface::OUTPUT_NORMAL);
            }

            return Command::SUCCESS;
        }

        $outputFormatter = $this->outputFormatRegistry->getItem(
            $input->getOption('format')
        );

        if ($input->getArgument('info-collectors')) {
            $identifiers = $input->getArgument('info-collectors');
        } else {
            $identifiers = $this->systemInfoCollectorRegistry->getIdentifiers();
        }

        // Collect info for the given identifiers.
        $collectedInfoArray = [];
        foreach ($identifiers as $identifier) {
            $collectedInfoArray[$identifier] = $this->systemInfoCollectorRegistry->getItem($identifier)->collect();
        }

        $output->writeln(
            $outputFormatter->format($collectedInfoArray)
        );

        return Command::SUCCESS;
    }
}
