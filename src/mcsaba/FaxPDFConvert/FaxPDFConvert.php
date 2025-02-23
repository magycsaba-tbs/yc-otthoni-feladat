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
        $peopleData->arrange();

        $faxFiles = new FaxData($this->pathFaxDirectory);
        (new FaxDataUidFiles($peopleData->customers, $faxFiles))->generate();

        $pdfFileNames = [];
        foreach ($peopleData->customers as $customer) {
            $pdfFileNames[] = $customer->getPDF($this->PDFDirectory);
        }
        return $pdfFileNames;
    }

}