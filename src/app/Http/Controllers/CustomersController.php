<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Http\Requests\StoreCustomer;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCustomer;
use App\Services\ApplicantListService;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Gate;

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
     * @var ApplicantListService
     */
    private $applicantListService;

    /**
     * CustomersController constructor.
     * @param CustomerRepository $customerRepository
     * @param CustomerService $customerService
     */
    public function __construct(
        CustomerRepository $customerRepository,
        CustomerService $customerService,
        ApplicantListService $applicantListService
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerService = $customerService;
        $this->applicantListService = $applicantListService;
    }

    public function create()
    {
        $userId = auth()->user()->id;
        
        return view('customers.create', ['userId' => $userId]);
    }

    public function store(StoreCustomer $request)
    {
        $attributes = $request->validated();
        $userId = $attributes['user_id'];
        $customer = $this->customerRepository->create($attributes, $userId);

        return redirect()->route('customers.show', ['customer' => $customer]);
    }

    public function show(int $id)
    {           
        $customer = $this->customerRepository->find($id);
        $lists = $this->applicantListService->getLists($customer);

        if ($this->customerService->hasCustomerProfile($customer)) {
            return view('customers.show', 
                [
                    'customer' => $customer, 
                    'lists' => $lists
                ]
            );
        }

        return redirect()->route('customers.create', ['userId' => $customer->user_id])
            ->with('status', 'It looks like you need to add your details!');
    }

    public function edit(int $id)
    {
        $customer = $this->customerRepository->find($id);

        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(UpdateCustomer $request, int $customerId)
    {
        $attributes = $request->validated();    
        $customer = $this->customerRepository->update($attributes, $customerId);

        return redirect()->route('customers.show', ['customer' => $customer]);
    }

    public function destroy(int $id)
    {
        $customer = $this->customerRepository->find($id);
        $this->customerRepository->softDelete($customer->id);
        auth()->logout();

        return redirect()->route('home')->with('status', 'Your account has been deleted!');
    }
}
