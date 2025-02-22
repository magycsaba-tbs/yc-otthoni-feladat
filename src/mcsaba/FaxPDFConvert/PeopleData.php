<?php

namespace mcsaba\FaxPDFConvert;

class PeopleData
{
    private string $peopleDataFilePath;
    public array $customers;

    public function __construct(string $peopleDataFilePath)
    {
        $this->peopleDataFilePath = $peopleDataFilePath;
    }

    public function arrange(): void
    {
        $peopleData = file_get_contents($this->peopleDataFilePath);
        $people = json_decode($peopleData);

        foreach ($people as $person) {
            $this->customers[$person->id] = new Customer($person->name, $person->date_of_birth);
        }
    }
}