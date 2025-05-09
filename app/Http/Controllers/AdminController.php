<?php

namespace App\Http\Controllers;

use App\Models\Transactions; // Assuming you have a Transaction model
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure the user is logged in
        $this->middleware('can:admin'); // Only admin users can access this
    }

    public function showTransactions()
    {
        // Fetch all transactions
        $transactions = Transactions::all(); // Modify as needed (add pagination or filters)
        return view('admin.transactions', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'status' => 'required|in:pending,success,canceled',
        ]);

        // Find the transaction by ID and update the status
        $transaction = Transactions::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();

        return redirect()->route('admin.transactions')->with('success', 'Status updated successfully!');
    }
}
