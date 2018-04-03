<?php

namespace Malyusha\Presenter\Contracts;

interface Presentable
{
    /**
     * Create and returns cached presenter instance.
     *
     * @return mixed
     */
    public function present();
}