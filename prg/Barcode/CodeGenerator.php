<?php
// https://github.com/kreativekorp/barcode

declare(strict_types=1);

namespace Code\Barcode;

class CodeGenerator extends BarcodeGenerator
{
    protected array $options;

    public function __construct (array $options)
    {
        $this->options = $options;
    }

    public function barSvgGenerator(string $datacode) : string
    {
        $datalen=strlen($datacode);

        switch ($datalen)
        {
            case 13:
                        $symbology = "ean-13";
                        break;
            case 8:
                        $symbology = "ean-8";
                        break;
            case 12:    
                        $symbology = "upc-a";
                        break;
            default:
                        $symbology = 0;
                        break;
        }

        if ($symbology == 0) return "";
        return $this->render_svg($symbology, $datacode, $this->options);

    }
}