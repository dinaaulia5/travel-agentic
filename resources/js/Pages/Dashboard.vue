<script setup>
import Banner from "@/Components/Banner.vue";
import BreadcrumbHeader from "@/Components/BreadcrumbHeader.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import { Card, CardContent } from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";
import { computed, ref } from "vue";
import { PlaneLanding } from "lucide-vue-next";

const selectedPeriod = ref("30");

import {
    Plane,
    Ticket,
    Users,
    TriangleAlert,
    Bot,
    Building2,
    TrendingUp,
} from "lucide-vue-next";
import Select from "@/Components/ui/select/Select.vue";
import SelectTrigger from "@/Components/ui/select/SelectTrigger.vue";
import SelectContent from "@/Components/ui/select/SelectContent.vue";
import SelectItem from "@/Components/ui/select/SelectItem.vue";
import SelectValue from "@/Components/ui/select/SelectValue.vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    items: Array,
    pageSettings: Object,
    statistics: Object,
    bookingAnalytics: Object,
    flightStatusChart: Object,
    liveFlights: Array,
});

const bookingCategories = computed(() =>
    props.bookingAnalytics.map((item) => item.date),
);

const bookingData = computed(() =>
    props.bookingAnalytics.map((item) => item.total),
);

const statisticCards = [
    {
        title: "Total Flights",
        value: props.statistics.total_flights,
        trend: "+12%",
        icon: Plane,
        bg: "bg-emerald-100",
        color: "text-emerald-600",
    },
    {
        title: "Total Bookings",
        value: props.statistics.total_bookings,
        trend: "+8%",
        icon: Ticket,
        bg: "bg-blue-100",
        color: "text-blue-600",
    },
    {
        title: "Total Users",
        value: props.statistics.total_users,
        trend: "+24%",
        icon: Users,
        bg: "bg-sky-100",
        color: "text-sky-600",
    },
    {
        title: "Delayed Flights",
        value: props.statistics.delayed_flights,
        badge: "CRITICAL",
        icon: TriangleAlert,
        bg: "bg-red-100",
        color: "text-red-600",
    },
    {
        title: "AI Recs",
        value: props.statistics.ai_recommendations,
        status: "Live",
        icon: Bot,
        bg: "bg-emerald-100",
        color: "text-emerald-600",
    },
    {
        title: "Airlines",
        value: props.statistics.total_airlines,
        status: "Global",
        icon: Building2,
        bg: "bg-slate-100",
        color: "text-slate-600",
    },
];

const bookingOptions = {
    chart: {
        toolbar: {
            show: false,
        },
    },

    colors: ["#10B981"],

    dataLabels: {
        enabled: false,
    },

    grid: {
        borderColor: "#E5E7EB",
    },

    xaxis: {
        categories: bookingCategories.value,
    },

    yaxis: {
        labels: {
            formatter(value) {
                return value;
            },
        },
    },

    plotOptions: {
        bar: {
            borderRadius: 8,
            columnWidth: "50%",
        },
    },
};

const bookingSeries = [
    {
        name: "Booking",
        data: bookingData.value,
    },
];

const flightStatusSeries = computed(() => [
    Number(props.flightStatusChart.on_time),
    Number(props.flightStatusChart.delayed),
    Number(props.flightStatusChart.cancelled),
]);

const flightStatusOptions = {
    chart: {
        type: "donut",
    },

    labels: ["On Time", "Delayed", "Cancelled"],

    colors: ["#047857", "#EAB308", "#DC2626"],

    legend: {
        show: false,
    },

    dataLabels: {
        enabled: false,
    },

    stroke: {
        width: 0,
    },
};
</script>

<template>
    <div class="flex w-full flex-col gap-y-6 pb-32">
        <BreadcrumbHeader :items="items" />

        <Banner
            :title="pageSettings.banner.title"
            :sub-title="pageSettings.banner.subtitle"
        />

        <!-- Statistics -->
        <div
            class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6"
        >
            <Card
                v-for="card in statisticCards"
                :key="card.title"
                class="rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300"
            >
                <CardContent class="p-6">
                    <div class="flex items-start justify-between">
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl"
                            :class="card.bg"
                        >
                            <component
                                :is="card.icon"
                                class="h-7 w-7"
                                :class="card.color"
                            />
                        </div>

                        <div
                            v-if="card.trend"
                            class="flex items-center gap-1 text-sm font-semibold text-emerald-600"
                        >
                            {{ card.trend }}

                            <TrendingUp class="h-4 w-4" />
                        </div>

                        <Badge v-if="card.badge" variant="destructive">
                            {{ card.badge }}
                        </Badge>

                        <span
                            v-if="card.status"
                            class="text-sm font-medium text-muted-foreground"
                        >
                            {{ card.status }}
                        </span>
                    </div>

                    <div class="mt-8">
                        <p class="text-muted-foreground">
                            {{ card.title }}
                        </p>

                        <h2 class="mt-2 text-4xl font-bold">
                            {{ card.value }}
                        </h2>
                    </div>
                </CardContent>
            </Card>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <!-- Booking Analytics -->
            <Card class="xl:col-span-2">
                <CardContent class="p-8">
                    <div
                        class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                    >
                        <div>
                            <h2 class="text-3xl font-bold">
                                Booking Analytics
                            </h2>

                            <p class="text-muted-foreground">
                                Statistik pemesanan penerbangan
                            </p>
                        </div>

                        <Select v-model="selectedPeriod">
                            <SelectTrigger class="w-[180px]">
                                <SelectValue />
                            </SelectTrigger>

                            <SelectContent>
                                <SelectItem value="7">
                                    7 Hari Terakhir
                                </SelectItem>

                                <SelectItem value="30">
                                    30 Hari Terakhir
                                </SelectItem>

                                <SelectItem value="90">
                                    90 Hari Terakhir
                                </SelectItem>

                                <SelectItem value="365">
                                    1 Tahun Terakhir
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div class="mt-8">
                        <apexchart
                            height="320"
                            type="bar"
                            :options="bookingOptions"
                            :series="bookingSeries"
                        />
                    </div>
                </CardContent>
            </Card>

            <!-- Flight Status -->
            <Card>
                <CardContent class="p-8">
                    <h2 class="text-3xl font-bold">Flight Status</h2>

                    <p class="text-muted-foreground">
                        Distribusi status penerbangan
                    </p>

                    <div class="mt-8">
                        <div class="mt-8">
                            <apexchart
                                type="donut"
                                :options="flightStatusOptions"
                                :series="flightStatusSeries"
                            />
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="size-3 rounded-full bg-emerald-600"
                                ></span>
                                <span>Tepat Waktu</span>
                            </div>

                            <span class="font-semibold">
                                {{ flightStatusChart.on_time }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="size-3 rounded-full bg-yellow-400"
                                ></span>
                                <span>Terlambat</span>
                            </div>

                            <span class="font-semibold">
                                {{ flightStatusChart.delayed }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="size-3 rounded-full bg-red-500"
                                ></span>
                                <span>Dibatalkan</span>
                            </div>

                            <span class="font-semibold">
                                {{ flightStatusChart.cancelled }}
                            </span>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>

        <Card class="h-full">
            <CardContent class="p-0">
                <!-- Header -->

                <div class="flex items-center justify-between border-b p-8">
                    <div>
                        <h2 class="text-3xl font-bold">Live Monitoring</h2>
                    </div>

                    <div class="flex items-center gap-2">
                        <span
                            class="size-3 rounded-full bg-emerald-500 animate-pulse"
                        />

                        <span class="font-semibold text-emerald-600 uppercase">
                            Live
                        </span>
                    </div>
                </div>

                <!-- List -->

                <div class="space-y-4 p-6">
                    <div
                        v-for="flight in liveFlights"
                        :key="flight.id"
                        class="rounded-2xl bg-slate-50 p-5 transition hover:bg-slate-100"
                    >
                        <div class="flex items-center justify-between">
                            <!-- Left -->

                            <div class="flex items-center gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl"
                                    :class="
                                        flight.flight_status.status ===
                                        'delayed'
                                            ? 'bg-red-100'
                                            : 'bg-emerald-100'
                                    "
                                >
                                    <PlaneLanding
                                        class="size-6"
                                        :class="
                                            flight.flight_status.status ===
                                            'delayed'
                                                ? 'text-red-600'
                                                : 'text-emerald-600'
                                        "
                                    />
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold">
                                        {{ flight.flight_number }}
                                    </h3>

                                    <p class="text-muted-foreground">
                                        {{
                                            flight.flight_status.status ===
                                            "boarding"
                                                ? "Boarding"
                                                : flight.flight_status
                                                        .status === "departed"
                                                  ? "Departed"
                                                  : flight.flight_status
                                                          .status === "arrived"
                                                    ? "Arrived"
                                                    : flight.flight_status
                                                            .status ===
                                                        "delayed"
                                                      ? "Delayed"
                                                      : "On Time"
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right -->

                            <div class="text-right">
                                <Badge
                                    :class="{
                                        'bg-emerald-100 text-emerald-700':
                                            flight.flight_status.status ===
                                            'on_time',

                                        'bg-yellow-100 text-yellow-700':
                                            flight.flight_status.status ===
                                            'boarding',

                                        'bg-red-100 text-red-700':
                                            flight.flight_status.status ===
                                            'delayed',

                                        'bg-slate-100 text-slate-700':
                                            flight.flight_status.status ===
                                            'arrived',
                                    }"
                                >
                                    {{
                                        flight.flight_status.status
                                            .replace("_", " ")
                                            .toUpperCase()
                                    }}
                                </Badge>

                                <p class="mt-3 font-semibold">
                                    Arr:
                                    {{
                                        new Date(
                                            flight.scheduled_arrival,
                                        ).toLocaleTimeString("id-ID", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                        })
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
