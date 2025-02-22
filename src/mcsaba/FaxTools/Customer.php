<?php

namespace mcsaba\FaxTools;

use Fpdf\Fpdf;

class Customer
{
    private string $uuid;
    private string $name;
    private string $dateOfBirth;
    private array $directories;

    public function __construct(string $name, string $dateOfBirth)
    {
        $this->name = $name;
        $this->dateOfBirth = $dateOfBirth;
        $this->directories = [];
    }

    public function addDirectory(string $directory, array $files): void
    {
        $this->directories[$directory] = $files;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getSimpleName(): string
    {
        return str_replace(' ', '_', $this->name);
    }

    public function getPDF(string $PDFDirectory): string|bool
    {
        if (count($this->directories) > 0) {
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 32);
            $pdf->Cell(0, 120, $this->name, 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', 24);
            $pdf->Cell(0, 40, $this->dateOfBirth, 0, 1, 'C');
            $pdf->Cell(0, 20, count($this->directories) . ' fax(es)', 0, 1, 'C');
            foreach ($this->directories as $directory => $files) {
                $dirParts = explode('/', $directory);
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 32);
                $pdf->Cell(0, 120, date("m/d/Y H:i", strtotime(end($dirParts))), 0, 1, 'C');
                foreach ($files as $file) {
                    if (str_ends_with($file, 'png')) {
                        $pdf->AddPage();
                        $pdf->Image($directory . '/' . $file, 0, 0, 210, 297);
                    }
                }
            }
            @mkdir($PDFDirectory);
            $filename = $PDFDirectory . '/' . $this->getSimpleName() . '___' . $this->uuid . '.pdf';
            $pdf->Output($filename, 'F');
            return $filename;
        } else {
            return false;
        }
    }

}