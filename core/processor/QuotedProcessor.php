<?php

namespace Core\Processor;

class QuotedProcessor extends AbstractProcessor
{

    public function canBeProcessed(): bool
    {
        $wrappedByDoubleQuotes = $this->isWrappedByChar('"');
        if($wrappedByDoubleQuotes) {
            return true;
        }
        return $this->isWrappedByChar('\'');
    }

    public function execute():string
    {
        return substr($this->value, 1, -1);
    }

    private function isWrappedByChar(string $char):bool {
        return !empty($this->value) && $this->value[0] === $char && $this->value[-1] === $char;
    }
}