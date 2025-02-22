<?php

namespace mcsaba\FaxPDFConvert;

class FaxPDFConvert
{
    private string $pathPeopleJSON;
    private string $pathFaxDirectory;
    private string $PDFDirectory;

    public function __construct(string $pathPeopleJSON, string $pathFaxDirectory, string $PDFDirectory)
    {
        $this->pathPeopleJSON = $pathPeopleJSON;
        $this->pathFaxDirectory = $pathFaxDirectory;
        $this->PDFDirectory = $PDFDirectory;
    }

    public function process(): array
    {
        $peopleData = new PeopleData($this->pathPeopleJSON);
        $peopleDataConverted = $peopleData->convert();

        $faxFiles = new FaxData($this->pathFaxDirectory);
        new FaxDataUidFiles($peopleDataConverted, $faxFiles);

        $pdfFileNames = [];
        foreach ($peopleDataConverted as $customer) {
            $pdfFileNames[] = $customer->getPDF($this->PDFDirectory);
        }
        return $pdfFileNames;
    }

}