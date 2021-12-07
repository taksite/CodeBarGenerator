<?php

declare(strict_types=1);

namespace Code\CommandLine;

class CommandLine
{
    // private $argumentsCli = [];
    private $fileNameScript = "";
    private $fileNameLoad = "";
    private $fileNameSave = "";

    public function __construct(array $arguments)
    {
       //  $this-> argumentsCli = $arguments;

        if (isset($arguments[1])) 
        {
            $this->fileNameLoad = $arguments[1];
        }  
        else 
        {
            $this->fileNameLoad = "";
        }
        
        if (isset($arguments[2])) 
        {
            $this->fileNameSave = $arguments[2];
        } 
        else 
        {
            $this->fileNameSave = "";
        }        

        if (isset($arguments[0]))
        {
            $this->fileNameScript = $arguments[0];
        }
        else
        {
            $this->fileNameScript = "";
        }

    }

    public static function isRunCli() : bool
    {
        if (PHP_SAPI <> 'cli') return false;
        return true; 
    }

    public function getArgumentsCli() : array
    {
            return [
                        'fileNameScript'    => $this->fileNameScript,
                        'fileNameLoad'      => $this->fileNameLoad,
                        'fileNameSave'      => $this->fileNameSave
            ];
    }

    public function getNameFileLoad() : string
    {
        return $this->fileNameLoad;
    }

    public function getNameFileSave() : string
    {
        return $this->fileNameSave;
    }

    public function getNameFileScript()
    {
        return $this->fileNameScript;
    }
}