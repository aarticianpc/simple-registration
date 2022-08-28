<?php

namespace Core\Processor;

abstract class AbstractProcessor implements ProcessorInterface
{
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}