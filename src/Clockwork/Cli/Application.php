<?php
namespace Clockwork\Cli;

use Clockwork\Cli\Output\Details;
use Clockwork\Cli\Output\ShortLine;

class Application
{
    /** @var LogFileScanner */
    private $fileScanner;
    /** @var ShortLine */
    private $shortLine;
    /** @var Details */
    private $details;
    /** @var float */
    private $updateInterval = 0.1;
    /** @var Colors */
    private $colors;

    public function __construct(array $dirs)
    {
        $this->fileScanner = new LogFileScanner($dirs);
        $this->shortLine = new ShortLine;
        $this->details = new Details;
        $this->colors = new Colors;
    }

    public function run()
    {
        $hotKey = 'a';
        $links = array();
        $since = microtime(true);
        system("stty -echo -icanon min 0 time 0");
        while (true) {
            foreach ($this->fileScanner->getNewFiles($since) as $file) {
                $log = json_decode(file_get_contents($file['file']), true);
                echo $this->colors->colorize("{yellow}$hotKey{default} ");
                $this->shortLine->output($log);
                $links[$hotKey] = $file['file'];
                $hotKey = $hotKey == 'z' ? 'a' : chr(ord($hotKey) + 1);
                $since = $file['time'];
            }
            usleep($this->updateInterval * 1000000);
            foreach (str_split(fread(STDIN, 10)) as $char) {
                if (ord($char) == 127) {
                    $since = microtime(true) - 600;
                    echo 'Requests for last 10 minutes', PHP_EOL;
                } elseif (ord($char) == 27) {
                    system("stty echo");
                    exit;
                } elseif (isset($links[$char])) {
                    $this->details->output(json_decode(file_get_contents($links[$char]), true));
                }
            }
        }

    }
}
