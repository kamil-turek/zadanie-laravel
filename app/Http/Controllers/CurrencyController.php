<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'currency' => 'required|string',
                'amount' => 'required|numeric'
            ]);
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            $userId = $user->id;
            $currency = Currency::create([
                'currency' => $request->input('currency'),
                'amount' => $request->input('amount'),
                'user_id' => $userId,
                'date' => now(),
            ]);
            return response()->json(['message' => 'Currency created successfully', 'data' => $currency], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create currency', 'error' => $e->getMessage()], 500);
        }
    }

    // GET /api/currencies/date/{date}
    // Example: http://localhost:8000/api/currencies/date/2023-04-23
    public function getCurrenciesOnDate(Request $request, $date): JsonResponse
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }
            $currencies = Currency::whereDate('date', '=', $date)->get();
            if (count($currencies)) {
                return response()->json(['message' => 'Currencies fetched successfully', 'data' => $currencies]);
            } else {
                return response()->json(['message' => 'No currencies on specified date'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch currencies', 'error' => $e->getMessage()], 500);
        }
    }

    // GET /api/currencies/date/{date}/currency/{currency}
    // Example: http://localhost:8000/api/currencies/date/2023-04-24/currency/eur
    public function getCurrencyOnDate(Request $request, $date, $currency): JsonResponse
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }
            $result = Currency::where('currency', $currency)->whereDate('date', '=', $date)->first();
            if ($result) {
                return response()->json(['message' => 'Currency fetched successfully', 'data' => $result]);
            } else {
                return response()->json(['message' => 'Currency not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch currency', 'error' => $e->getMessage()], 500);
        }
    }
}
