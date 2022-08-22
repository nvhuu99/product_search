<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class FindMeNumber extends Controller
{
    //
    public function index(Request $request) {
        $key = 'find-me-number';
        $perMinutes = 5;

        $numbers = [0,1,2,3,4,5,6,7,8,9,10];
        $yourNumber = null;

        if (! RateLimiter::remaining($key, $perMinutes)) {
                session()->flash(
                'error', 
                'Limit rate exceed. Please try again after: '. RateLimiter::availableIn($key)
            );
        }
        elseif ($request->filled('input')) {
            $index = rand(0, count($numbers) - 1);
            $yourNumber = $numbers[$index];
            RateLimiter::hit($key);
        }
        
        return view('find-me-number', compact('numbers', 'yourNumber'));
    }

    public function confirm() {
        RateLimiter::clear('find-me-number');
        return to_route('findMeNumber.index');
    }
}