<?php

namespace App\Jobs;

use App\Repositories\ContactRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessContacts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $contactRepository;
    private $contacts;
    private $path;

    /**
     * Create a new job instance.
     * @param array $contacts
     * @param string $path
     * @return void
     */
    public function __construct(array $contacts, string $path = null)
    {
        $this->contactRepository    = new ContactRepository();
        $this->contacts             = $contacts;
        $this->path                 = $path;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        if (!$this->path) {

            $this->path = 'contacts-temp/' . uniqid(date('YmdHis')) . '.json';

            Storage::put($this->path, json_encode($this->contacts));

        }

        $data = [];

        foreach ($this->contacts as $contact) {

            $age = $this->calcutateAge($contact->date_of_birth);

            if ($age >= 18 && $age <= 65) {

                $value = [
                    'name'                          => $contact->name,
                    'address'                       => $contact->address,
                    'checked'                       => $contact->checked,
                    'description'                   => $contact->description,
                    'interest'                      => $contact->interest,
                    'date_of_birth'                 => gmdate('Y-m-d H:i:s', strtotime($contact->date_of_birth)),
                    'email'                         => $contact->email,
                    'account'                       => $contact->account,
                    'credit_card_type'              => $contact->credit_card->type,
                    'credit_card_number'            => $contact->credit_card->number,
                    'credit_card_name'              => $contact->credit_card->name,
                    'credit_card_expirationDate'    => $contact->credit_card->expirationDate
                ];

                if (!$this->contactRepository->exists($contact->email, $contact->account)) {

                    $data[] = $value;

                } else {

                    $this->contactRepository->update($contact->email, $contact->account, $value);

                }

            }

        }

        if (count($data) > 0) {
            $this->contactRepository->create($data);
        }

        Storage::delete($this->path);
    }

    /**
     * calcutate age.
     * @param string $birthday
     * @return void
     */
    private function calcutateAge($birthday)
    {
        $birthday = date('Y-m-d', strtotime($birthday));

        $birthdayObject = new \DateTime($birthday);

        $nowObject = new \DateTime();

        $diff = $birthdayObject->diff($nowObject);

        return $diff->y;
    }

    /**
     * check if credit card number contains three consecutive same digits.
     * @param string $number
     * @return void
     */
    private function checkCardNumber(string $number)
    {
        return strpos($number, '111') !== false
            || strpos($number, '222') !== false
            || strpos($number, '333') !== false
            || strpos($number, '444') !== false
            || strpos($number, '555') !== false
            || strpos($number, '666') !== false
            || strpos($number, '777') !== false
            || strpos($number, '888') !== false
            || strpos($number, '999') !== false
            || strpos($number, '000') !== false;
    }
}
