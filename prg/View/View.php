<?php

declare(strict_types=1);

namespace Code\View;

class View 
{
  
    public static function templateToHtml (string $template, array $table) : string
        {

            if (!file_exists($template)) 
                {
                    return $templt="view_error";
                }

            $templt = file_get_contents ($template); // get template
            
            foreach($table as $key => $data) 
                {
                    $templt=str_replace("{\$".$key."\$}", $data, $templt);
                }
            
            $templt=preg_replace('({\$(.*?)\$})', "you forgot!", $templt);   //if not included variables in the table

            return $templt;
        }

    public static function showHtml (string $html) : void
    {
        echo $html;  // for autorefresh
    }

}
