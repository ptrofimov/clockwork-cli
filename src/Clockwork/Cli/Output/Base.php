<?php
namespace Clockwork\Cli\Output;

use Clockwork\Cli\Colors;

class Base
{
    /** @var Colors */
    private $colors;

    public function __construct()
    {
        $this->colors = new Colors;
    }

    protected function color($string)
    {
        return $this->colors->colorize($string);
    }
}
