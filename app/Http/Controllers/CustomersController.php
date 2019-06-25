<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CustomerRepository;

class CustomersController extends Controller
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**]
     * @var CustomerService
     */
    private $customerService;

    /**
     * CustomersController constructor.
     * @param CustomerRepository $customerRepository
     * @param CustomerService $customerService
     */
    public function __construct(CustomerRepository $customerRepository, CustomerService $customerService)
    {
        $this->customerRepository = $customerRepository;
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * @todo : refactor this into middleware - but make sure authentication check is done before removing it.
         */
        Auth::check();
        $userId = auth()->user()->id;

        return view('customers.create', ['userId' => $userId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        $attributes = $request->validated();
        $userId = $attributes['user_id'];
        $customer = $this->customerRepository->create($attributes, $userId);

        return redirect()->route('customers.show', ['customer' => $customer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->find($id);

        if ($this->customerService->hasCustomerProfile($customer)) {
            return view('customers.show', ['customer' => $customer]);

        }

        return redirect()->route('customers.edit', ['customer' => $id])
            ->with('status', 'It looks like you need to add your details!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->find($id);

        return view('customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, $customerId)
    {
        $attributes = $request->validated();
        $customer = $this->customerRepository->update($attributes, $customerId);

        return redirect()->route('customers.show', ['customer' => $customer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
