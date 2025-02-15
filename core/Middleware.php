<?php

namespace Ynet;

abstract class Middleware
{
    abstract public function handle(Request $request, \Closure $next);
}