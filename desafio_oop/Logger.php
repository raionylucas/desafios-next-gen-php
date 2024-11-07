<?php

namespace MyLog;

enum LogLevel: string
{
    case alert = 'alert:';
    case danger = 'danger:';
    case log = 'log:';
}

class FileLogger
{
    public function __construct(private string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function writeFile(LogLevel $level, string $message, array $data)
    {
        $file = fopen($this->filePath, 'a');
        $date = date('Y-m-d H:i:s');
        $formatData = json_encode($data);
        $formatMessage = "$date | " . $level->value . " [$message] [$formatData]";

        fwrite($file, $formatMessage . PHP_EOL);
        fclose($file);
    }
}

class Logger
{
    public function __construct(private FileLogger $filelogger) {}

    public function log(LogLevel $level, string $message, array $data)
    {
        $this->filelogger->writeFile($level, $message, $data);
    }
}
