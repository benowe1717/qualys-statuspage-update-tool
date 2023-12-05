<?php

    class my_logger {

        private $file = __DIR__ . "/.creds.ini";
        private $date_format = "M d H:m:s";
        private $hostname = "";
        private $program = "php";
        private $pid = -1;
        public $fp;
        public $error;

        function __construct() {
            if($this->fp = fopen("php://stdout", "w")) {
                $this->hostname = gethostname();
                $this->pid = getmypid();
                $this->log_msg("Starting logger...");
            }
        }

        public function log_msg(string $msg) {
            $now = date($this->date_format);
            $message = "{$now} {$this->hostname} {$this->program}[{$this->pid}] {$msg}";
            fwrite($this->fp, $message);
        }

    }

?>