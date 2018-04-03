<?php

namespace Malyusha\Presenter;

use Malyusha\Presenter\Exceptions\PresenterException;

/**
 * Trait PresentableTrait
 *
 * @property string $presenter
 */
trait PresentableTrait
{
    /**
     * Presenter instance.
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * Returns new presenter instance.
     *
     * @return mixed
     * @throws \Malyusha\Presenter\Exceptions\PresenterException
     */
    public function present()
    {
        if (! property_exists($this, 'presenter') || ! class_exists($this->presenter)) {
            throw new PresenterException('$presenter property is required when using PresentableTrait.');
        }

        if (! $this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }

}