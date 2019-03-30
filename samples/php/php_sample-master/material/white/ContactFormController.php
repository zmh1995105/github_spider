<?php
namespace App\Http\Controllers;

use App\Http\Controller\Frontend;
use Lavender\Http\FormRequest;

class ContactFormController extends Frontend
{

	public function __construct()
	{
        $this->loadLayout();
	}

	public function get()
	{
		return view('contact.form');
	}

    public function post(FormRequest $request)
    {
        form('contact')->handle($request);

        return redirect()->back();
    }


}
