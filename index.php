<?php
declare(strict_types=1);

### ---------------------------------------------------------------------
require_once("./Utils/auto_load_class.php");
### ---------------------------------------------------------------------
// Debug  dump();
require_once("./Utils/debug.php");
### ---------------------------------------------------------------------
use Code\Barcode\CodeGenerator;
/* CAUTION!
// use in php.ini: extension=gd (in Windows 10)
// $image = $generator->render_image($format, $symbology, $data, $options);
// or just use render_svg();
*/
### ---------------------------------------------------------------------
use Code\CommandLine\CommandLine;
use Code\View\View;
use Code\FileOperations;
use Code\Exceptions\NameFileException;
use Code\Exceptions\OpenFileException;
use Code\Exceptions\EmptyTableException;
use Code\Exceptions\SaveFileException;

### ---------------------------------------------------------------------

define ( 'TEST_MODE' , 'OFF');

if (!CommandLine::isRunCli()) exit ("This is not a command line prompt.");

$cli = new  CommandLine($argv);

$options =  ['sf' => 1, 'w' => 155, 'h' => 70, 'tf' => 'Arial', 'ts' => 10];
$generator =  new CodeGenerator($options);

$file = new FileOperations( 
                            [ 
                              'load' => $cli->getNameFileLoad(), 
                              'save' => $cli->getNameFileSave()
                            ]); 
try {   
        if (!empty($cli->getNameFileLoad)) throw new NameFileException();
        if (!file_exists($cli->getNameFileLoad())) throw new NameFileException();
        if ($file -> openFileLoad()) throw new OpenFileException;

### ---------------------------------------------------------------------
(int) $i = 0;
(string) $container = "";

while(!$file->endFile())
{
     if (!empty( $table = $file->getTableFromLine()))
     {
        if (count($table)<7) throw new EmptyTableException;
        isset($table[0]) ? $table[0] : $table[0] = "";
        isset($table[1]) ? $table[1] : $table[1] = "";
        isset($table[7]) ? $table[3] : $table[3] = "";
        isset($table[4]) ? $table[4] : $table[4] = "";
        isset($table[5]) ? $table[5] : $table[5] = "";
        isset($table[6]) ? $table[6] : $table[6] = "";
        isset($table[2]) ? $table[2] : $table[2] = "";

        $container .= "<tr><td>".$table[0]."</td>";   // id assort
        $container .= "<td>".$table[1]."</td>";       // name
        $container .= "<td>".$table[3]."</td>";       // quantity
        $container .= "<td>".$table[4]."</td>";       // price_purch_last     
        $container .= "<td>".$table[5]."</td>";       // vat
        $container .= "<td>".$table[6]."</td>";       // price_sg
        $container .= "<td>".$table[2]."</td>";       // ean 
        $container .= "<td>".$generator -> barSvgGenerator(trim($table[2]))."</td> </tr>";  // barcode
    }

    $i++;
    // for testing only!
    if (TEST_MODE === "ON" && $i >15)  break;
}

  $file->close();
### ---------------------------------------------------------------------
  $inputHtml = "./templates/index_tpl.html";
  $table = [
              'title'         => "CodeBarGenerator",
              'container'     => $container,
              'quantityGods'  => (string) $i
  ];

  $html =  View::templateToHtml ($inputHtml, $table);
 ### ---------------------------------------------------------------------
  $file->openFileSave();
  $file->save($html);
  $file->close();

} catch (NameFileException $e)
{
    echo ("No file name to load, or no file exist.");
    exit();
} catch (EmptyTableException $e)
{
  echo ("Something wrong with reading data lines $i.");
  exit();
} catch (OpenFileException $e)
{
  echo ("Error open file.");
  exit();
} catch (SaveFileException $e)
{
  echo ("Error save file.");
  exit();
}




