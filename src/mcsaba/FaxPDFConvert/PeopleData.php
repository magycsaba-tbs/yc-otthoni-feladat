<?php

namespace mcsaba\FaxPDFConvert;

class PeopleData
{
    private string $peopleDataFilePath;

    public function __construct(string $peopleDataFilePath)
    {
        $this->peopleDataFilePath = $peopleDataFilePath;
    }

    public function convert(): array
    {
        $peopleData = file_get_contents($this->peopleDataFilePath);
        $people = json_decode($peopleData);
        $peopleIndexed = [];

        foreach ($people as $person) {
            $peopleIndexed[$person->id] = new Customer($person->name, $person->date_of_birth);
        }
        return ($peopleIndexed);
    }
}