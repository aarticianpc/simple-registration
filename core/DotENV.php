<?php

namespace Core;

use Core\Processor\AbstractProcessor;
use Core\Processor\BooleanProcessor;
use Core\Processor\QuotedProcessor;

class DotENV
{
    /**
     * The directory where .env file can be located.
     * @var string
     */
    protected $path;

    /**
     * Configure options on which parsed will act
     * @var string[]
     */
    protected $processors = [];

    public function __construct(string $path, array $processors = []) {
        if(!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exists', $path));
        }
        $this->path = $path;
        $this->setProcessors($processors);
    }

    public function load():void
    {
        if(!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if(strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = $this->processValue($value);

            if(!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    private function setProcessors($processors = []): void
    {
        if(empty($processors)) {
            $this->processors = [
                BooleanProcessor::class,
                QuotedProcessor::class
            ];
            return;
        }

        foreach ($processors as $processor) {
            if(is_subclass_of($processor, AbstractProcessor::class)) {
                $this->processors[] = $processor;
            }
        }
    }

    /**
     * @param string $value
     * @return mixed|string
     */
    private function processValue(string $value) {
        $trimmedValue = trim($value);

        foreach ($this->processors as $processor) {
            $processorInstance = new $processor($trimmedValue);

            if($processorInstance->canBeProcessed()) {
                return $processorInstance->execute();
            }
        }
        /**
         * Do not match any processor options return as it is.
         */
        return $trimmedValue;
    }
}