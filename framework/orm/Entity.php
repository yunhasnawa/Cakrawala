<?php

namespace framework\orm;

use framework\Model;

class Entity extends Model
{
    protected string $table;
    protected bool $isView;

    public function __construct(string $table, $isView = false)
    {
        parent::__construct();

        $this->table = $table;
        $this->isView = $isView;
    }
}