<?php

namespace KrisOzolins\UniqueTranslation;

use Illuminate\Validation\Rules\DatabaseRule;

class UniqueTranslationRule
{
    use DatabaseRule;

    /**
     * @var string
     */
    protected $rule = 'unique_translation';

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string|null
     */
    protected $column = null;

    /**
     * @var mixed
     */
    protected $ignoreValue = null;

    /**
     * @var string|null
     */
    protected $ignoreColumn = null;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string|null $column
     *
     * @return static
     */
    public static function for($table, $column = null)
    {
        return new static($table, $column);
    }

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string|null $column
     */
    public function __construct($table, $column = null)
    {
        $this->table = $table;
        $this->column = $column;
    }

    /**
     * Ignore any record that has a column with the given value.
     *
     * @param mixed $value
     * @param string $column
     *
     * @return $this
     */
    public function ignore($value, $column = 'id')
    {
        $this->ignoreValue = $value;
        $this->ignoreColumn = $column;

        return $this;
    }

    /**
     * Generate a string representation of the validation rule.
     *
     * @return string
     */
    public function __toString()
    {
        return rtrim(sprintf('%s:%s,%s,%s,%s,%s',
            $this->rule,
            $this->table,
            $this->column ?: 'NULL',
            $this->ignoreValue ? '"'.$this->ignoreValue.'"' : 'NULL',
            $this->ignoreColumn ?: 'NULL',
            $this->formatWheres()
        ), ',');
    }
}
