<?php

declare(strict_types=1);

namespace Mogelijk;

class IbanToBic
{
    private array $datasets = [];

    public function __construct()
    {
        $this->loadDatasets();
    }

    public function ibanToBic(string $iban): ?string
    {
        $iban = strtoupper($iban);
        $country = substr($iban, 0, 2);
        if (! isset($this->datasets[$country])) {
            return null;
        }

        $bankCode = null;
        switch ($country) {
            case 'AT':
                $bankCode = substr($iban, 4, 5);
                break;
            case 'BE':
                $bankCode = substr($iban, 4, 3);
                break;
            case 'DE':
                $bankCode = substr($iban, 4, 8);
                break;
            case 'ES':
                $bankCode = substr($iban, 4, 4);
                break;
            case 'FR':
                $bankCode = substr($iban, 4, 5);
                break;
            case 'LU':
                $bankCode = substr($iban, 4, 3);
                break;
            case 'NL':
                $bankCode = substr($iban, 4, 4);
                break;
        }
        if (! $bankCode) {
            return null;
        }

        return $this->datasets[$country][$bankCode] ?? null;
    }

    private function loadDatasets(): void
    {
        $this->datasets['AT'] = json_decode(file_get_contents(__DIR__.'/../datasets/at.json'), true);
        $this->datasets['BE'] = json_decode(file_get_contents(__DIR__.'/../datasets/be.json'), true);
        $this->datasets['DE'] = json_decode(file_get_contents(__DIR__.'/../datasets/de.json'), true);
        $this->datasets['ES'] = json_decode(file_get_contents(__DIR__.'/../datasets/es.json'), true);
        $this->datasets['FR'] = json_decode(file_get_contents(__DIR__.'/../datasets/fr.json'), true);
        $this->datasets['LU'] = json_decode(file_get_contents(__DIR__.'/../datasets/lu.json'), true);
        $this->datasets['NL'] = json_decode(file_get_contents(__DIR__.'/../datasets/nl.json'), true);
    }
}
