<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display all expenses.
     */
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'desc')->paginate(10);
        return view('admin.expenses.index', compact('expenses'));
    }

    /**
     * Show form to create a new expense.
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a new expense.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'payment_type' => 'nullable|string|max:50',
            'transaction_number' => 'nullable|string|max:100',
            'bill_image' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string',
        ]);

        // Handle image upload
        $billImagePath = null;
        if ($request->hasFile('bill_image')) {
            $billImagePath = $request->file('bill_image')->store('uploads/expenses', 'public');
        }

        Expense::create([
            'expense_type' => $request->expense_type,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'payment_type' => $request->payment_type,
            'transaction_number' => $request->transaction_number,
            'bill_image' => $billImagePath,
            'note' => $request->note,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    /**
     * Show single expense (optional).
     */
    public function show(Expense $expense)
    {
        return view('admin.expenses.show', compact('expense'));
    }

    /**
     * Edit expense.
     */
    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * Update expense record.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'payment_type' => 'nullable|string|max:50',
            'transaction_number' => 'nullable|string|max:100',
            'bill_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string',
        ]);

        $billImagePath = $expense->bill_image;

        if ($request->hasFile('bill_image')) {
            // Delete old image if exists
            if ($billImagePath && Storage::disk('public')->exists($billImagePath)) {
                Storage::disk('public')->delete($billImagePath);
            }
            $billImagePath = $request->file('bill_image')->store('uploads/expenses', 'public');
        }

        $expense->update([
            'expense_type' => $request->expense_type,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'payment_type' => $request->payment_type,
            'transaction_number' => $request->transaction_number,
            'bill_image' => $billImagePath,
            'note' => $request->note,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Delete expense.
     */
    public function destroy(Expense $expense)
    {
        if ($expense->bill_image && Storage::disk('public')->exists($expense->bill_image)) {
            Storage::disk('public')->delete($expense->bill_image);
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
