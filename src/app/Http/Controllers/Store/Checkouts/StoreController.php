<?php

namespace App\Http\Controllers\Store\Checkouts;

use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\Store\Checkouts\StoreRequest;

// Services
use App\Services\Store\CheckoutService;

use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService
    ) {}

    public function __invoke(StoreRequest $request): RedirectResponse
    {
        $store = app('currentStore');

        $result = $this->checkoutService->create(
            store: $store,
            data: $request->validated()
        );

        if ($result->isRedirect()) {
            return redirect()->route('store.checkouts.show', [
                'checkout' => $result->checkoutId(),
            ]);
        }

        if ($result->hasErrors()) {
            return back()
                ->withErrors(['stock' => $result->errors()])
                ->withInput();
        }

        flash('Checkout created. You have 10 minutes to complete your order.')
            ->success();

        return redirect()->route('store.checkouts.show', [
            'checkout' => $result->checkoutId(),
        ]);
    }
}
