<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Http\Requests\AirportRequest;
use App\Http\Resources\AirportResource;
use App\Models\Airport;
use App\Supports\Pages\AirportPage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Throwable;
use App\Helpers\helpers;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AirportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth')
        ];
    }
    public function index(): Response
    {
        $airports = Airport::query()
            ->select(['id', 'code', 'name', 'city', 'country', 'image', 'created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->paginate(request()->load ?? 10)
            ->withQueryString();

        return inertia('Airport/Index', [
            'pageSettings' => fn() => AirportPage::index(),
            'airports' => fn() => AirportResource::collection($airports)->additional([
                'meta' => [
                    'has_pages' => $airports->hasPages(),
                ],
            ]),
            'state' => fn() => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => request()->load ?? 10,
            ],
            'items' => fn() => AirportPage::breadcrumbs()
        ]);
    }

    public function store(AirportRequest $request): RedirectResponse
    {
        try {
            $image = $request->file('image')->store('airports', 'public');

            Airport::create([
                'code' => $request->code,
                'name' => $request->name,
                'city' => $request->city,
                'country' => $request->country,
                'image' => $image,
            ]);

            flashMessage(MessageType::CREATED->message('Bandara'));

            return to_route('airports.index');
        } catch (Throwable $e) {
            flashMessage(
                MessageType::ERROR->message(error: $e->getMessage()),
                'error'
            );

            return to_route('airports.index');
        }
    }

    public function show(Airport $airport)
    {
        //
    }
    public function edit(Airport $airport): Response
    {
        return inertia('Airport/Edit', [
            'pageSettings' => fn() => AirportPage::edit($airport),
            'items' => fn() => AirportPage::editBreadcrumbs(),
            'airport' => $airport,
        ]);
    }


    public function update(AirportRequest $request, Airport $airport): RedirectResponse
    {
        try {

            $image = $airport->image;

            if ($request->hasFile('image')) {

                if (
                    $airport->image &&
                    Storage::disk('public')->exists($airport->image)
                ) {
                    Storage::disk('public')->delete($airport->image);
                }

                $image = $request
                    ->file('image')
                    ->store('airports', 'public');
            }

            $airport->update([
                'code' => strtoupper($request->code),
                'name' => $request->name,
                'city' => $request->city,
                'country' => $request->country,
                'image' => $image,
            ]);

            flashMessage(
                MessageType::UPDATED->message('Bandara')
            );

            return back();
        } catch (Throwable $e) {

            flashMessage(
                MessageType::ERROR->message(
                    error: $e->getMessage()
                ),
                'error'
            );

            return back();
        }
    }

    public function destroy(Airport $airport)
    {
        try {
            $airport->delete();
            flashMessage(MessageType::DELETE->message('Tujuan'));
            return to_route('airports.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('airports.index');
        }
    }
}
