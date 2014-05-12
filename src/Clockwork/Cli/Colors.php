<?php
namespace Clockwork\Cli;

class Colors
{
    /** @var array */
    private $colors = array(
        'black' => "\033[0;30m",
        'blue' => "\033[0;34m",
        'green' => "\033[0;32m",
        'cyan' => "\033[0;36m",
        'red' => "\033[0;31m",
        'purple' => "\033[0;35m",
        'brown' => "\033[0;33m",
        'light gray' => "\033[0;37m",
        'dark gray' => "\033[1;30m",
        'light blue' => "\033[1;34m",
        'light green' => "\033[1;32m",
        'light cyan' => "\033[1;36m",
        'light red' => "\033[1;31m",
        'light purple' => "\033[1;35m",
        'yellow' => "\033[1;33m",
        'white' => "\033[1;37m",
        'default' => "\033[0m",
    );
    /** @var array */
    private $colorCodes = array();

    public function __construct()
    {
        foreach ($this->colors as $name => $code) {
            $this->colorCodes[] = "{{$name}}";
        }
    }

    /** @return array */
    public function colors()
    {
        return $this->colors;
    }

    /** @return string */
    public function colorize($string)
    {
        return str_replace($this->colorCodes, $this->colors, $string);
    }

    /** @return array */
    public function example()
    {
        $example = array();
        foreach ($this->colors as $name => $code) {
            $example[] = $this->colorize("{{$name}}$name{default}");
        }

        return $example;
    }
}
