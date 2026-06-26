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
});

const form = useForm({
    airline_id: "",
    departure_airport_id: "",
    arrival_airport_id: "",
    flight_number: "",
    scheduled_departure: "",
    scheduled_arrival: "",
    price: "",
    _method: props.pageSettings.method,
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
                    <!-- Airline -->
                    <div class="flex flex-col gap-2">
                        <Label>Maskapai</Label>

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

                    <!-- Flight Number -->
                    <div class="flex flex-col gap-2">
                        <Label>Nomor Penerbangan</Label>

                        <Input
                            v-model="form.flight_number"
                            placeholder="GA101"
                        />

                        <InputError :message="form.errors.flight_number" />
                    </div>

                    <!-- Departure Airport -->
                    <div class="flex flex-col gap-2">
                        <Label>Bandara Keberangkatan</Label>

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
                                {{ airport.code }} -
                                {{ airport.name }}
                            </option>
                        </select>

                        <InputError
                            :message="form.errors.departure_airport_id"
                        />
                    </div>

                    <!-- Arrival Airport -->
                    <div class="flex flex-col gap-2">
                        <Label>Bandara Tujuan</Label>

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
                                {{ airport.code }} -
                                {{ airport.name }}
                            </option>
                        </select>

                        <InputError :message="form.errors.arrival_airport_id" />
                    </div>

                    <!-- Scheduled Departure -->
                    <div class="flex flex-col gap-2">
                        <Label>Jadwal Keberangkatan</Label>

                        <Input
                            type="datetime-local"
                            v-model="form.scheduled_departure"
                        />

                        <InputError
                            :message="form.errors.scheduled_departure"
                        />
                    </div>

                    <!-- Scheduled Arrival -->
                    <div class="flex flex-col gap-2">
                        <Label>Jadwal Kedatangan</Label>

                        <Input
                            type="datetime-local"
                            v-model="form.scheduled_arrival"
                        />

                        <InputError :message="form.errors.scheduled_arrival" />
                    </div>

                    <!-- Price -->
                    <div class="flex flex-col gap-2 lg:col-span-2">
                        <Label>Harga Tiket</Label>

                        <Input
                            type="number"
                            min="0"
                            v-model="form.price"
                            placeholder="1500000"
                        />

                        <InputError :message="form.errors.price" />
                    </div>

                    <div class="flex justify-end gap-2 lg:col-span-2">
                        <Button
                            type="button"
                            variant="ghost"
                            @click="form.reset()"
                        >
                            Reset
                        </Button>

                        <Button
                            type="submit"
                            variant="emerald"
                            size="xl"
                            :disabled="form.processing"
                        >
                            <IconCheck class="size-4" />
                            Submit
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
