<?php
namespace Clockwork\Cli\Output;

class ShortLine extends Base
{
    public function output(array $log)
    {
        echo $this->color(sprintf(
            '%s %5.3f %s %s %s {dark gray}%s{default}' . PHP_EOL,
            date('H:m:i', $log['time']),
            $log['responseDuration'] / 1000,
            $log['responseStatus'] >= 300 ? "{light red}$log[responseStatus]{default}" : "{light green}$log[responseStatus]{default}",
            $log['method'],
            $log['uri'],
            $log['headers']['host'][0]
        ));
    }
}
