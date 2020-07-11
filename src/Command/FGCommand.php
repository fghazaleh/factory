<?php

declare(strict_types=1);

namespace FG\Bundle\FactoryBundle\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class FGCommand extends SymfonyCommand
{
    /**
     * @var InputInterface;
     */
    private $input;

    /**
     * @var OutputInterface;
     */
    private $output;


    abstract public function handle(): int;

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        parent::execute($input, $output);

        $this->handle();
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    protected function option(string $key, $default = null)
    {
        return $this->input->getOption($key) ?? $default;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    protected function argument(string $key, $default = null)
    {
        return $this->input->getArgument($key) ?? $default;
    }

    /**
     * @return array
     */
    protected function options(): array
    {
        return $this->input->getOptions();
    }

    /**
     * @return array
     */
    protected function arguments(): array
    {
        return $this->input->getArguments();
    }
}