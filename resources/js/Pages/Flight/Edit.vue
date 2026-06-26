<script setup>
import { Link, useForm } from "@inertiajs/vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbHeader from "@/Components/BreadcrumbHeader.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import InputError from "@/Components/InputError.vue";

import { Button } from "@/Components/ui/button";
import { Card, CardContent, CardHeader } from "@/Components/ui/card";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";

import { IconArrowBack, IconCheck, IconPlane } from "@tabler/icons-vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    pageSettings: Object,
    items: Array,
    airlines: Array,
    airports: Array,
    flight: Object,
});

const form = useForm({
    airline_id: props.flight.airline_id ?? "",
    departure_airport_id: props.flight.departure_airport_id ?? "",

    arrival_airport_id: props.flight.arrival_airport_id ?? "",

    flight_number: props.flight.flight_number ?? "",

    scheduled_departure: props.flight.scheduled_departure ?? "",

    scheduled_arrival: props.flight.scheduled_arrival ?? "",

    price: props.flight.price ?? "",

    status: props.flight.flight_status?.status ?? "on_time",

    delay_minutes: props.flight.flight_status?.delay_minutes ?? 0,

    reason: props.flight.flight_status?.reason ?? "",

    actual_departure: props.flight.flight_status?.actual_departure ?? "",

    actual_arrival: props.flight.flight_status?.actual_arrival ?? "",

    _method: "PUT",
});

const onHandleSubmit = () => {
    form.post(props.pageSettings.action, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <div class="flex flex-col w-full gap-y-6 pb-32">
        <BreadcrumbHeader :items="items" />

        <Card>
            <CardHeader>
                <div
                    class="flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center"
                >
                    <HeaderTitle
                        :title="pageSettings.title"
                        :sub-title="pageSettings.subtitle"
                        :icon="IconPlane"
                    />

                    <Button variant="emerald" size="xl" as-child>
                        <Link :href="route('flights.index')">
                            <IconArrowBack class="size-4" />
                            Kembali
                        </Link>
                    </Button>
                </div>
            </CardHeader>

            <CardContent>
                <form
                    class="grid grid-cols-1 gap-4 lg:grid-cols-2"
                    @submit.prevent="onHandleSubmit"
                >
                    <!-- AIRLINE -->
                    <div class="flex flex-col gap-2">
                        <Label> Maskapai </Label>

                        <select
                            v-model="form.airline_id"
                            class="h-10 rounded-md border px-3"
                        >
                            <option value="">Pilih Maskapai</option>

                            <option
                                v-for="airline in airlines"
                                :key="airline.id"
                                :value="airline.id"
                            >
                                {{ airline.name }}
                            </option>
                        </select>

                        <InputError :message="form.errors.airline_id" />
                    </div>

                    <!-- FLIGHT NUMBER -->
                    <div class="flex flex-col gap-2">
                        <Label> Nomor Penerbangan </Label>

                        <Input v-model="form.flight_number" />

                        <InputError :message="form.errors.flight_number" />
                    </div>

                    <!-- DEPARTURE -->
                    <div class="flex flex-col gap-2">
                        <Label> Bandara Keberangkatan </Label>

                        <select
                            v-model="form.departure_airport_id"
                            class="h-10 rounded-md border px-3"
                        >
                            <option value="">Pilih Bandara</option>

                            <option
                                v-for="airport in airports"
                                :key="airport.id"
                                :value="airport.id"
                            >
                                {{ airport.code }}
                                -
                                {{ airport.name }}
                            </option>
                        </select>

                        <InputError
                            :message="form.errors.departure_airport_id"
                        />
                    </div>

                    <!-- ARRIVAL -->
                    <div class="flex flex-col gap-2">
                        <Label> Bandara Tujuan </Label>

                        <select
                            v-model="form.arrival_airport_id"
                            class="h-10 rounded-md border px-3"
                        >
                            <option value="">Pilih Bandara</option>

                            <option
                                v-for="airport in airports"
                                :key="airport.id"
                                :value="airport.id"
                            >
                                {{ airport.code }}
                                -
                                {{ airport.name }}
                            </option>
                        </select>

                        <InputError :message="form.errors.arrival_airport_id" />
                    </div>

                    <!-- SCHEDULED DEPARTURE -->
                    <div class="flex flex-col gap-2">
                        <Label> Jadwal Keberangkatan </Label>

                        <Input
                            type="datetime-local"
                            v-model="form.scheduled_departure"
                        />

                        <InputError
                            :message="form.errors.scheduled_departure"
                        />
                    </div>

                    <!-- SCHEDULED ARRIVAL -->
                    <div class="flex flex-col gap-2">
                        <Label> Jadwal Kedatangan </Label>

                        <Input
                            type="datetime-local"
                            v-model="form.scheduled_arrival"
                        />

                        <InputError :message="form.errors.scheduled_arrival" />
                    </div>

                    <!-- PRICE -->
                    <div class="flex flex-col gap-2 lg:col-span-2">
                        <Label> Harga Tiket </Label>

                        <Input type="number" min="0" v-model="form.price" />

                        <InputError :message="form.errors.price" />
                    </div>

                    <!-- STATUS -->
                    <div class="flex flex-col gap-2">
                        <Label> Status </Label>

                        <select
                            v-model="form.status"
                            class="h-10 rounded-md border px-3"
                        >
                            <option value="on_time">On Time</option>
                            <option value="boarding">Boarding</option>
                            <option value="delayed">Delayed</option>
                            <option value="departed">Departed</option>
                            <option value="arrived">Arrived</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- DELAY -->
                    <div class="flex flex-col gap-2">
                        <Label> Delay (Menit) </Label>

                        <Input
                            type="number"
                            min="0"
                            v-model="form.delay_minutes"
                        />
                    </div>

                    <!-- REASON -->
                    <div class="flex flex-col gap-2 lg:col-span-2">
                        <Label> Alasan </Label>

                        <textarea
                            v-model="form.reason"
                            class="min-h-24 rounded-md border px-3 py-2"
                        />
                    </div>

                    <!-- ACTUAL DEPARTURE -->
                    <div class="flex flex-col gap-2">
                        <Label> Actual Departure </Label>

                        <Input
                            type="datetime-local"
                            v-model="form.actual_departure"
                        />
                    </div>

                    <!-- ACTUAL ARRIVAL -->
                    <div class="flex flex-col gap-2">
                        <Label> Actual Arrival </Label>

                        <Input
                            type="datetime-local"
                            v-model="form.actual_arrival"
                        />
                    </div>

                    <div class="flex justify-end gap-2 lg:col-span-2">
                        <Button
                            type="submit"
                            variant="emerald"
                            :disabled="form.processing"
                        >
                            <IconCheck class="size-4" />
                            Update
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
