<?php

namespace Core\Processor;

class BooleanProcessor extends AbstractProcessor
{

    public function canBeProcessed(): bool
    {
        $loweredVal = strtolower($this->value);
        return in_array($loweredVal, ['true', 'false'], true);
    }

    public function execute(): bool
    {
        return strtolower($this->value) === 'true';
    }
}