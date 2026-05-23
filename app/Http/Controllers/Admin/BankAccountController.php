<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::query()
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.bank-accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('admin.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ]);

        $hasActive = BankAccount::query()->where('is_active', true)->exists();

        DB::transaction(function () use ($validated, $hasActive) {
            if (! $hasActive) {
                BankAccount::query()->where('is_active', true)->update(['is_active' => false]);
            }

            BankAccount::create([
                'bank_name' => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'account_name' => $validated['account_name'],
                'is_active' => ! $hasActive,
            ]);
        });

        return redirect()
            ->route('admin.bank-accounts.index')
            ->with('success', 'Nomor rekening berhasil ditambahkan.');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('admin.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ]);

        $bankAccount->update($validated);

        return redirect()
            ->route('admin.bank-accounts.index')
            ->with('success', 'Nomor rekening berhasil diupdate.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()
            ->route('admin.bank-accounts.index')
            ->with('success', 'Nomor rekening berhasil dihapus.');
    }

    public function activate(BankAccount $bankAccount)
    {
        DB::transaction(function () use ($bankAccount) {
            BankAccount::query()->where('is_active', true)->update(['is_active' => false]);
            $bankAccount->update(['is_active' => true]);
        });

        return redirect()
            ->route('admin.bank-accounts.index')
            ->with('success', 'Nomor rekening aktif berhasil diganti.');
    }
}
