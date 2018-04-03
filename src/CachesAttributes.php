<?php

namespace Malyusha\Presenter;

/**
 * Class CachesAttributes
 */
trait CachesAttributes
{
    /**
     * @var array
     */
    protected $cachedPresenterAttributes = [];

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return mixed
     */
    protected function cached($attribute, $value)
    {
        if (! array_key_exists($attribute, $this->cachedPresenterAttributes)) {
            $this->cachedPresenterAttributes[$attribute] = $value;
        }

        return $this->cachedPresenterAttributes[$attribute];
    }

}