<script setup>
import { reactive, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import Banner from "@/Components/Banner.vue";
import BreadcrumbHeader from "@/Components/BreadcrumbHeader.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import Filter from "@/Components/Datatable/Filter.vue";
import ShowFilter from "@/Components/Datatable/ShowFilter.vue";

import { Button } from "@/Components/ui/button";
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from "@/Components/ui/card";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";

import {
    IconArrowsDownUp,
    IconPencil,
    IconPlane,
    IconPlus,
    IconTrash,
} from "@tabler/icons-vue";

import EmptyState from "@/Components/EmptyState.vue";
import PaginationTable from "@/Components/Datatable/PaginationTable.vue";
import { deleteAction } from "@/lib/utils";
import AlertAction from "@/Components/AlertAction.vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    flights: Object,
    pageSettings: Object,
    items: Array,
    state: Object,
});

const flights = computed(() => props.flights.data);
const meta = computed(() => props.flights.meta);
const links = computed(() => props.flights.links);

const params = reactive({
    ...props.state,
});

const onSortTable = (field) => {
    params.field = field;
    params.direction = params.direction === "asc" ? "desc" : "asc";

    router.get(route("flights.index"), params, {
        preserveState: true,
        preserveScroll: true,
        only: ["flights"],
    });
};

const handleDelete = (id) => {
    console.log("Delete:", id);

    deleteAction(route("flights.destroy", id));
};
</script>

<template>
    <div class="flex flex-col w-full gap-y-6 pb-32">
        <BreadcrumbHeader :items="items" />

        <Banner
            :title="pageSettings.banner.title"
            :sub-title="pageSettings.banner.subtitle"
        />

        <Card>
            <CardHeader class="p-0">
                <div
                    class="flex flex-col items-start justify-between p-4 gap-y-4 lg:flex-row lg:items-center"
                >
                    <HeaderTitle
                        :title="pageSettings.title"
                        :sub-title="pageSettings.subtitle"
                        :icon="IconPlane"
                    />

                    <Button variant="red" size="xl" as-child>
                        <Link :href="route('flights.create')">
                            <IconPlus class="size-4" />
                            Tambah Flight
                        </Link>
                    </Button>
                </div>

                <Filter v-model:params="params" :state="state" />
                <ShowFilter :params="params" />
            </CardHeader>

            <CardContent
                class="p-0 [&_td]:whitespace-nowrap [&_td]:px-6 [&_th]:px-6"
            >
                <EmptyState
                    v-if="flights.length === 0"
                    :icon="IconPlane"
                    title="Tidak ada Flight"
                    subtitle="Mulailah dengan menambahkan data flight"
                />

                <Table v-else class="w-full">
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>

                            <TableHead>
                                <Button
                                    variant="ghost"
                                    class="inline-flex group"
                                    @click="onSortTable('flight_number')"
                                >
                                    Flight Number
                                    <IconArrowsDownUp class="ml-2 size-4" />
                                </Button>
                            </TableHead>

                            <TableHead>Airline</TableHead>

                            <TableHead>Departure</TableHead>

                            <TableHead>Arrival</TableHead>

                            <TableHead>
                                <Button
                                    variant="ghost"
                                    class="inline-flex group"
                                    @click="onSortTable('scheduled_departure')"
                                >
                                    Departure Time
                                    <IconArrowsDownUp class="ml-2 size-4" />
                                </Button>
                            </TableHead>

                            <TableHead>Arrival Time</TableHead>

                            <TableHead>Price</TableHead>

                            <TableHead>Status</TableHead>

                            <TableHead>Aksi</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(flight, index) in flights"
                            :key="flight.id"
                        >
                            <TableCell>
                                {{
                                    index +
                                    1 +
                                    (meta.current_page - 1) * meta.per_page
                                }}
                            </TableCell>

                            <TableCell class="font-medium">
                                {{ flight.flight_number }}
                            </TableCell>

                            <TableCell>
                                {{ flight.airline?.name }}
                            </TableCell>

                            <TableCell>
                                {{ flight.departure_airport?.code }}
                                -
                                {{ flight.departure_airport?.city }}
                            </TableCell>

                            <TableCell>
                                {{ flight.arrival_airport?.code }}
                                -
                                {{ flight.arrival_airport?.city }}
                            </TableCell>

                            <TableCell>
                                {{ flight.scheduled_departure }}
                            </TableCell>

                            <TableCell>
                                {{ flight.scheduled_arrival }}
                            </TableCell>

                            <TableCell>
                                Rp
                                {{
                                    Number(flight.price).toLocaleString("id-ID")
                                }}
                            </TableCell>

                            <TableCell>
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700"
                                >
                                    {{
                                        flight.flight_status?.status ??
                                        "Unknown"
                                    }}
                                </span>
                            </TableCell>

                            <TableCell>
                                <div class="flex items-center gap-x-1">
                                    <Button variant="blue" size="sm" as-child>
                                        <Link
                                            :href="
                                                route('flights.edit', flight.id)
                                            "
                                        >
                                            <IconPencil class="size-4" />
                                        </Link>
                                    </Button>

                                    <AlertAction
                                        :action="
                                            () =>
                                                deleteAction(
                                                    route(
                                                        'flights.destroy',
                                                        flight.id,
                                                    ),
                                                )
                                        "
                                    >
                                        <Button variant="red" size="sm">
                                            <IconTrash class="size-4" />
                                        </Button>
                                    </AlertAction>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>

            <CardFooter
                class="flex flex-col items-center justify-between w-full py-3 border-t gap-y-2 lg:flex-row"
            >
                <p class="text-sm text-muted-foreground">
                    Menampilkan
                    <span class="font-medium text-emerald-600">
                        {{ meta.from ?? 0 }}
                    </span>
                    dari {{ meta.total }} Flight
                </p>

                <div class="overflow-x-auto">
                    <PaginationTable
                        v-if="meta.has_pages"
                        :meta="meta"
                        :links="links"
                    />
                </div>
            </CardFooter>
        </Card>
    </div>
</template>
