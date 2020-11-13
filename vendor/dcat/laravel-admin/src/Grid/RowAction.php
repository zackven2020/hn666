<?php

namespace Dcat\Admin\Grid;

use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

abstract class RowAction extends GridAction
{
    /**
     * @var Fluent
     */
    protected $row;

    /**
     * @var Column
     */
    protected $column;

    /**
     * @var string
     */
    public $selectorPrefix = '.grid-row-action-';

    /**
     * Get primary key value of current row.
     *
     * @return mixed
     */
    public function getKey()
    {
        if ($this->row) {
            return $this->row->get($this->parent->getKeyName());
        }

        return parent::getKey();
    }

    /**
     * Set row model.
     *
     * @param mixed $key
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function row($key = null)
    {
        if (func_num_args() == 0) {
            return $this->row;
        }

        return $this->row->{$key};
    }

    /**
     * Set row model.
     *
     * @param Fluent $row
     *
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param Column $column
     *
     * @return $this
     */
    public function setColumn(Column $column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * 生成选择器.
     * 需要保证每个行操作的选择器都不同.
     *
     * @param string $prefix
     * @param string $class
     *
     * @return string
     */
    public function makeSelector($prefix, $class = null)
    {
        $class = $class ?: static::class;

        $key = $prefix.'-'.$class.'-'.$this->getKey();

        if (! isset(static::$selectors[$key])) {
            static::$selectors[$key] = $prefix.Str::random(8);
        }

        return static::$selectors[$key];
    }
}
