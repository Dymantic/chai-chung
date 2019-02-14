<?php

namespace App\Http\Controllers;

use Dymantic\Secretary\ContactForm;
use Dymantic\Secretary\Secretary;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(ContactForm $form, Secretary $secretary)
    {
        $secretary->receive($form->contactMessage());
    }
}
