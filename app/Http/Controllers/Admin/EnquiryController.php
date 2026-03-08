<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(): View
    {
        $enquiries = Enquiry::orderBy('created_at', 'desc')->get();

        return view('admin.enquiries.index', compact('enquiries'));
    }
}
