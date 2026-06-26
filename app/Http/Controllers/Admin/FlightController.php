<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlightRequest;
use App\Http\Resources\FlightResource;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Services\FlightDelayAgentService;
use App\Supports\Pages\FlightPage;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Throwable;

class FlightController extends Controller
{
    public function index(): Response
    {
        $flights = Flight::query()
            ->with([
                'airline',
                'departureAirport',
                'arrivalAirport',
                'flightStatus',
            ])
            ->filter(request()->only([
                'search',
            ]))
            ->sorting(request()->only([
                'field',
                'direction',
            ]))
            ->paginate(request()->load ?? 10)
            ->withQueryString();

        return inertia('Flight/Index', [
            'pageSettings' => fn() => FlightPage::index(),

            'items' => fn() => FlightPage::breadcrumbs(),

            'flights' => fn() =>
            FlightResource::collection($flights)
                ->additional([
                    'meta' => [
                        'has_pages' => $flights->hasPages(),
                    ],
                ]),

            'state' => fn() => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => request()->load ?? 10,
            ],
        ]);
    }

    public function create(): Response
    {
        $airlines = Airline::select('id', 'name')->get();
        $airports = Airport::select(
            'id',
            'name',
            'code',
            'city'
        )->get();
        return inertia('Flight/Create', [
            'pageSettings' => fn() => FlightPage::create(),
            'items' => fn() => FlightPage::createBreadcrumbs(),
            'airlines' => $airlines,
            'airports' =>   $airports
        ]);
    }

    public function store(FlightRequest $request): RedirectResponse
    {
        try {
            $flight = Flight::create([
                'airline_id' => $request->airline_id,
                'departure_airport_id' => $request->departure_airport_id,
                'arrival_airport_id' => $request->arrival_airport_id,
                'flight_number' => strtoupper($request->flight_number),
                'scheduled_departure' => $request->scheduled_departure,
                'scheduled_arrival' => $request->scheduled_arrival,
                'price' => $request->price,
            ]);

            $flight->flightStatus()->create([
                'status' => 'on_time',
                'delay_minutes' => 0,
                'reason' => null,
                'actual_departure' => null,
                'actual_arrival' => null,
            ]);

            flashMessage(MessageType::CREATED->message('Penerbangan'));
            return to_route('flights.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('flights.index');
        }
    }

    public function edit(Flight $flight): Response
    {
        $flight->load('flightStatus');

        $airlines = Airline::select(
            'id',
            'name'
        )->get();

        $airports = Airport::select(
            'id',
            'name',
            'code',
            'city'
        )->get();

        return inertia('Flight/Edit', [
            'pageSettings' => fn() => FlightPage::edit($flight),
            'items' => fn() => FlightPage::editBreadcrumbs(),

            'flight' => $flight,

            'airlines' => $airlines,
            'airports' => $airports,
        ]);
    }

    public function update(FlightRequest $request, Flight $flight, FlightDelayAgentService $agentService): RedirectResponse
    {
        try {
            $flight->update([
                'airline_id' => $request->airline_id,
                'departure_airport_id' => $request->departure_airport_id,
                'arrival_airport_id' => $request->arrival_airport_id,
                'flight_number' => strtoupper($request->flight_number),
                'scheduled_departure' => $request->scheduled_departure,
                'scheduled_arrival' => $request->scheduled_arrival,
                'price' => $request->price,
            ]);

            $flight->flightStatus()->update([
                'status' => $request->status,
                'delay_minutes' => $request->delay_minutes,
                'reason' => $request->reason,
                'actual_departure' => $request->actual_departure,
                'actual_arrival' => $request->actual_arrival,
            ]);

            $flight->load('flightStatus');

            $agentService->handle($flight->flightStatus);
            flashMessage(MessageType::UPDATED->message('Penerbangan'));
            return to_route('flights.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('flights.index');
        }
    }

    public function destroy(Flight $flight)
    {
        try {
            $flight->delete();
            flashMessage(MessageType::DELETE->message('Penerbangan'));
            return to_route('flights.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('flights.index');
        }
    }
}
