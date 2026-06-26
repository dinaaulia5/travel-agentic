<?php

namespace App\Http\Controllers;


use Inertia\Response;

class FlightController extends Controller
{

    public function index(): Response
    {
        return inertia('LandingPage/Flights/SearchResult');
    }
}
