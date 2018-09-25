<?php

namespace Clarion\Domain\Criteria;

use Clarion\Domain\Models\Mobile;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class HasTheFollowing.
 *
 * @package namespace Clarion\Domain\Criteria;
 */
class HasTheFollowing implements CriteriaInterface
{

    protected $field;

    protected $values = [];

    public function __construct($field, ...$values)
    {
        $this->field = $field;

        $this->setValues(array_flatten($values));
    }

    static public function __callStatic($method, $args) {

        return new static($method, $args);
    }

    public function apply($model, RepositoryInterface $repository)
    {
        
        return $model->whereIn($this->field, $this->values);
    }

    protected function setValues($values)
    {
        switch ($this->field) {
            case 'mobile':
                array_walk($values, function(&$item) {
                    $item = Mobile::number($item);
                });
                break;
        }
        
        $this->values = $values;
    }
}
