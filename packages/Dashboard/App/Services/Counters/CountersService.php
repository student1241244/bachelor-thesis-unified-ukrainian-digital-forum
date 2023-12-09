<?php

namespace Packages\Dashboard\App\Services\Counters;

use Contacts\App\Models\Contact;

class CountersService extends BaseCountersService
{
    /**
     * @return array
     */
    public function getData(): array
    {
        $data = [];

        if (can('contacts.contacts.index')) {
            $data['contacts'] = (new Contact())->getCountNotRead();
            $data = array_merge($data, (new Contact)->getCountNotReadByTypes());
        }

        return $data;
    }
}
