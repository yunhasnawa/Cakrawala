<?php

namespace framework;

class View
{
    private string $_template;
    private array $_data;

    public function __construct($template)
    {
        $this->_template = $template;
        $this->_data = [];
    }

    public function setData(array $data): void
    {
        $this->_data = $data;
    }

    public function modifyData($index, $value): void
    {
        $this->_data[$index] = $value;
    }

    public function getData($index = null)
    {
        if ($index)
            return $this->_data[$index];
        else
            return $this->_data;
    }

    public function render(): void
    {
        require_once $this->_template;
    }
}