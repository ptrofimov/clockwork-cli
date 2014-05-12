<?php
namespace Clockwork\Cli;

use Clockwork\Cli\Output\Details;

class Application
{
    /** @var array */
    private $dirs;

    public function __construct(array $dirs)
    {
        $this->dirs = $dirs;
    }

    public function run()
    {
        $period = 0.1;
        $since = microtime(true) - 60000;
        system("stty -echo -icanon min 0 time 0");
        $dirs = $this->dirs;
        if (empty($dirs)) {
            $dirs = [getcwd()];
        }
        $links = [];
        $hotKey = 'a';
        while (true) {
            $files = (new LogFileScanner)->getNewFiles($dirs, $since);
            foreach ($files as $file) {
                $log = json_decode(file_get_contents($file['file']), true);
                echo $hotKey . ' ';
                echo date('H:m:i', $log['time']) . ' ';
                echo "$log[method] $log[uri] ({$log['headers']['host'][0]})\n";
                $links[$hotKey] = $file['file'];
                $hotKey = $hotKey == 'z' ? 'a' : chr(ord($hotKey) + 1);
            }
            usleep($period * 1000000);
            if (!empty($files)) {
                $since = array_pop($files)['time'];
            }
            foreach (str_split(fread(STDIN, 100)) as $char) if (isset($links[$char])) {
                (new Details)->output($links[$char]);
            }
        }

    }
}
