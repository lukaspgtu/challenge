<?php

namespace App\Services;

use App\Jobs\ProcessContacts;
use App\Repositories\ContactRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ContactService
{
    private $contactRepository;

    /**
     * Create a new contact service instance.
     * @return void
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * process contacts queue.
     * @param \Illuminate\Http\UploadedFile $file
     * @return void
     */
    public function fileUpload(UploadedFile $file): void
    {
        $array = $this->fileToArray($file);

        $chunk = array_chunk($array, 1000);
        
        foreach($chunk as $contacts) {
            ProcessContacts::dispatch($contacts);
        }
    }

    /**
     * process contacts temp queue.
     * @return void
     */
    public function processTemp(): void
    {
        $files = Storage::files('contacts-temp');

        foreach($files as $path) {

            $contacts = json_decode(Storage::get($path));

            ProcessContacts::dispatch($contacts, $path);

        }
    }

    /**
     * get array from file.
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function fileToArray(UploadedFile $file): array
    {
        if ($file->clientExtension() == 'json') {
            return json_decode(file_get_contents($file));
        }

        elseif ($file->clientExtension() == 'xml') {
            $xml    = simplexml_load_string(file_get_contents($file));
            $json   = str_replace('{}', 'null', json_encode($xml));
            $json   = str_replace('"false"', 'false', $json);
            $json   = str_replace('"true"', 'true', $json);
            $json   = json_decode($json);
            return is_array($json->row) ? $json->row : [$json->row];
        }

        elseif ($file->clientExtension() == 'csv') {
            
            $csv    = file_get_contents($file);      
            $rows   = explode("\n", trim($csv));
            $data   = array_slice($rows, 1);
            $keys   = array_fill(0, count($data), $rows[0]);
            $json   = array_map(function ($row, $key) {
                $row = str_getcsv($row);
                foreach ($row as &$r) {
                    if ($r == 'null') {
                        $r = null;
                    } elseif ($r == 'false') {
                        $r = false;
                    } elseif ($r == 'true') {
                        $r = true;
                    }
                }
                return array_combine(str_getcsv($key), $row);
            }, $data, $keys);
        
            $array = json_decode(json_encode($json));

            foreach ($array as &$arr) {

                $arr->credit_card = (object) [
                    'type'              => $arr->{'credit_card/type'},
                    'number'            => $arr->{'credit_card/number'},
                    'name'              => $arr->{'credit_card/name'},
                    'expirationDate'    => $arr->{'credit_card/expirationDate'}
                ];

                unset(
                    $arr->{'credit_card/type'},
                    $arr->{'credit_card/number'},
                    $arr->{'credit_card/name'},
                    $arr->{'credit_card/expirationDate'}
                );
                
            }

            return $array;
            
        }
    }
}
