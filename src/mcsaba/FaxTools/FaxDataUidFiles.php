<?php

namespace mcsaba\FaxTools;

use chillerlan\QRCode\{QRCode};

class FaxDataUidFiles
{
    public function __construct(array $customers, FaxData $faxData)
    {
        foreach ($faxData as $directory => $files) {
            $rootDirectory = $faxData->parentDirectory . '/' . $directory;
            $flagFile = $rootDirectory . '/done';
            $uuidFile = $rootDirectory . '/userId.uuid';
            if (!file_exists($flagFile)) {
                try {
                    $result = (new QRCode)->readFromFile($rootDirectory . '/' . $files[0]);
                    $uuid = (string)$result;
                    file_put_contents($uuidFile, $uuid);
                    touch($flagFile);
                } catch (Throwable $exception) {
                    echo 'HIBA tortent!';
                    print_r($exception);
                    die();
                }
            } else {
                $uuid = file_get_contents($uuidFile);
            }
            $customers[$uuid]->setUUID($uuid);
            $customers[$uuid]->addDirectory($rootDirectory, $files);
        }
    }
}

