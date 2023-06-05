<?php

abstract class CommandRunner
{
    abstract function onUnhandled($command);

    public function processArguments($argc, $argv)
    {
        if ($argc <= 1) {
            echo "Not enough arguments.\n";
            exit(1);
        }
        for ($i = 1; $i < $argc; $i++) {
            $commandName = $argv[$i];
            $methodName = "on".ucfirst(strtolower($commandName))."Command";

            if (method_exists(Static::class, $methodName)) {
                call_user_func_array([Static::class, $methodName], ['name' => $commandName, 'runner' => $this]);
            } else {
                $this->onUnhandled($commandName);
            }
        }
    }

    public function run($argc, $argv)
    {
        $argv = $this->processArguments($argc, $argv);
        print_r($argv);
    }
}