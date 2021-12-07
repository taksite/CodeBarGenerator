<?php

declare (strict_types=1);

namespace Code;
use Code\Exceptions\SaveFileException;
use Code\Exceptions\OpenFileException;
use Exception;

class FileOperations
{
    
    private $fileNameLoad = "";
    private $fileNameSave = "";
    private $file = "";

    public function __construct(array $fileName)
    {
        $this->fileNameLoad = $fileName['load'];
        if (empty($fileName['save']))
        {
            $this->fileNameSave = $this->fileNameLoad."_out.html";
        }
        else 
        {
            $this->fileNameSave = $fileName['save'];
        }
        
    }

    public function getFileNames () : array
    {
        return [
                    'load' => $this->fileNameLoad,
                    'save' => $this->fileNameSave
        ];
    }

    public function openFileLoad() : void
    {       
       if (!$this->file = fopen($this->fileNameLoad,"r")) throw new OpenFileException;
    }

    public function close() : void
    {
        fclose ($this->file);       
    }
    
    public function getTableFromLine() : array
    {
        $line = fgets($this->file);
        if (empty($line)) return [];
        return explode(';',$line);
    }

    public function endFile() : bool
    {
        if (feof($this->file)) return true;
        return false;
    }

    public function openFileSave() : void
    {
        try 
        {
            $this->file = fopen($this->fileNameSave,"w");
        } catch (Exception $e)
        {
            throw new Exception ("Error open file",1);
        }

    }

    public function save(string $data) : bool
    {
        
        if (!flock($this->file, LOCK_EX)) throw new SaveFileException;
        if (!fputs($this->file, $data)) throw new SaveFileException;
        if (!flock($this->file, LOCK_UN)) throw new SaveFileException;
        return true;
    }

}