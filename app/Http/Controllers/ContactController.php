<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;

class ContactController extends Controller
{
    private $contactService;

    /**
     * Create a new contact controller instance.
     * @param ContactService $contactService
     * @return void
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Create a new contact controller instance.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->contactService->processTemp();

        return response()->json([
            'success' => true,
            'message' => 'Contacts queued successfully'
        ]);
    }

    /**
     * Create a new contact controller instance.
     * @param ContactRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContactRequest $request)
    {
        $this->contactService->fileUpload($request->file);

        return response()->json([
            'success' => true,
            'message' => 'Contacts queued successfully'
        ]);
    }
}
