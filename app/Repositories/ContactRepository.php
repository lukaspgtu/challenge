<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ContactRepository
{
    /**
     * Create a new contact repository instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * check duplicate.
     * 
     * @param string $email
     * @param string $account
     * @return bool
     */
    public function exists(string $email, string $account): bool
    {
        return DB::table('contacts')
            ->where('email', $email)
            ->where('account', $account)
            ->count() > 0;
    }

    /**
     * create contact.
     * 
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        DB::table('contacts')->insert($data);
    }

    /**
     * update contact.
     * 
     * @param string $email
     * @param string $account
     * @param array $data
     * @return void
     */
    public function update(string $email, string $account, array $data): void
    {
        DB::table('contacts')
            ->where('email', $email)
            ->where('account', $account)
            ->update($data);
    }
}