<?php

namespace mcsaba\FaxPDFConvert;

use chillerlan\QRCode\{QRCode};

class FaxDataUidFiles
{
    public function __construct(private array $customers, private FaxData $faxData)
    {
    }

    public function generate(): void
    {
        foreach ($this->faxData as $directory => $files) {
            $rootDirectory = $this->faxData->parentDirectory . '/' . $directory;
            $flagFile = $rootDirectory . '/done';
            $uuidFile = $rootDirectory . '/userId.uuid';
            if (!file_exists($flagFile)) {
                $uuid = $this->getQRCodeData($rootDirectory . '/' . $files[0]);
                if ($uuid !== false) {
                    file_put_contents($uuidFile, $uuid);
                    touch($flagFile);
                }
            } else {
                $uuid = file_get_contents($uuidFile);
            }
            $this->customers[$uuid]->setUuid($uuid);
            $this->customers[$uuid]->addDirectory($rootDirectory, $files);
        }
    }

    private function getQRCodeData(string $path): false|string
    {
        try {
            $result = (new QRCode)->readFromFile($path);
            $uuid = (string)$result;
            return $uuid;
        } catch (Throwable $exception) {
            echo 'HIBA tortent!';
            print_r($exception);
            return false;
        }
    }
}

