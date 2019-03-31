<?php

use Flarum\Extend;
use PersianFla\RTL\Frontend\Content\RTL;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->content(RTL::class),
];
