<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\ServicePackage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    public function create(ServicePackage $servicePackage)
    {
        return view('public.our-services.order', compact('servicePackage'));
    }

    public function store(Request $request, ServicePackage $servicePackage)
    {
        $validated = $request->validate([
            'customer_full_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:40',
            'email' => 'required|email|max:255',
            'pic_number' => 'nullable|string|max:255',
        ]);

        $salesOrder = DB::transaction(function () use ($validated, $servicePackage) {
            $soNumber = $this->generateUniqueSoNumber();

            $normalPrice = $servicePackage->normal_price;
            $discountPrice = $servicePackage->discount_price;
            $finalPrice = $discountPrice !== null ? $discountPrice : $normalPrice;

            return SalesOrder::create([
                'so_number' => $soNumber,
                'customer_full_name' => $validated['customer_full_name'],
                'company_name' => $validated['company_name'],
                'whatsapp_number' => $validated['whatsapp_number'],
                'email' => $validated['email'],
                'pic_number' => $validated['pic_number'] ?? null,
                'service_package_id' => $servicePackage->id,
                'package_name' => $servicePackage->name,
                'normal_price' => $normalPrice,
                'discount_price' => $discountPrice,
                'final_price' => $finalPrice,
                'status' => 'NEW',
            ]);
        });

        return redirect()->route('our-services.order.show', $salesOrder);
    }

    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->loadMissing('servicePackage');

        return view('public.our-services.confirmation', compact('salesOrder'));
    }

    public function invoice(SalesOrder $salesOrder)
    {
        $pdf = Pdf::loadView('public.our-services.invoice', [
            'salesOrder' => $salesOrder,
        ])->setPaper('a4');

        return $pdf->download("invoice-{$salesOrder->so_number}.pdf");
    }

    private function generateUniqueSoNumber(): string
    {
        $prefix = 'SO'.now()->format('ym');

        $lastSoNumber = DB::table('sales_orders')
            ->where('so_number', 'like', $prefix.'%')
            ->lockForUpdate()
            ->orderByDesc('so_number')
            ->value('so_number');

        $lastSequence = 0;
        if (is_string($lastSoNumber) && strlen($lastSoNumber) >= 5) {
            $lastSequence = (int) substr($lastSoNumber, -5);
        }

        $nextSequence = $lastSequence + 1;

        return $prefix.str_pad((string) $nextSequence, 5, '0', STR_PAD_LEFT);
    }
}
