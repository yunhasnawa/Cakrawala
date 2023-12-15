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

    public function setData(array $data)
    {
        $this->_data = $data;
    }

    public function modifyData($index, $value)
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

    public function render()
    {
        require_once $this->_template;
    }
}