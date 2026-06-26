<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Supports\Pages\BookingPage;
use Inertia\Response;

class BookingController extends Controller
{
    public function index(): Response
    {
        $bookings = Booking::query()
            ->with([
                'user:id,name,email',
                'flight:id,flight_number',
            ])
            ->select([
                'id',
                'user_id',
                'flight_id',
                'booking_code',
                'contact_name',
                'contact_email',
                'contact_phone',
                'passenger_count',
                'seat_class',
                'total_price',
                'booking_status',
                'payment_status',
                'created_at',
            ])
            ->filter(request()->only(['search']))
            ->sorting(request()->only([
                'field',
                'direction',
            ]))
            ->paginate(request()->load ?? 10)
            ->withQueryString();

        return inertia('Booking/Index', [
            'pageSettings' => fn() => BookingPage::index(),

            'items' => fn() => BookingPage::breadcrumbs(),

            'bookings' => fn() =>
            BookingResource::collection($bookings)
                ->additional([
                    'meta' => [
                        'has_pages' => $bookings->hasPages(),
                    ],
                ]),
            'state' => fn() => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => request()->load ?? 10,
            ],
        ]);
    }
}
