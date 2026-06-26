<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";

import { Card, CardContent } from "@/Components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";

import {
    IconLayoutDashboard,
    IconMapPin,
    IconPlane,
    IconPlaneDeparture,
    IconTicket,
    IconRobot,
    IconHistory,
} from "@tabler/icons-vue";

defineProps({
    auth: {
        type: Object,
        required: true,
    },
    url: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <nav class="flex flex-1 flex-col gap-y-6 overflow-y-auto scrollbar-none">
        <ApplicationLogo url="#" />

        <Card>
            <CardContent class="flex items-center gap-3 p-3">
                <Avatar>
                    <AvatarImage :src="auth?.avatar" />
                    <AvatarFallback>
                        {{ auth?.name?.substring(0, 1) }}
                    </AvatarFallback>
                </Avatar>

                <div class="flex flex-col">
                    <span
                        class="line-clamp-1 text-sm font-medium tracking-tight"
                    >
                        {{ auth?.name }}
                    </span>

                    <span class="text-xs text-muted-foreground">
                        {{ auth?.id }}
                    </span>
                </div>
            </CardContent>
        </Card>

        <ul role="list" class="flex flex-1 flex-col gap-y-2">
            <!-- Dashboard -->
            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                General
            </div>

            <NavLink
                title="Dashboard"
                :url="route('dashboard')"
                :active="url.startsWith('/dashboard')"
                :icon="IconLayoutDashboard"
            />

            <!-- Master -->
            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Master Data
            </div>

            <NavLink
                title="Airports"
                :url="route('airports.index')"
                :active="url.startsWith('/airports')"
                :icon="IconMapPin"
            />

            <NavLink
                title="Airlines"
                :url="route('airlines.index')"
                :active="url.startsWith('/airlines')"
                :icon="IconPlane"
            />

            <NavLink
                title="Flights"
                :url="route('flights.index')"
                :active="url.startsWith('/flights')"
                :icon="IconPlaneDeparture"
            />

            <!-- Transaction -->
            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Transactions
            </div>

            <NavLink
                title="Bookings"
                :url="route('bookings.index')"
                :active="url.startsWith('/bookings')"
                :icon="IconTicket"
            />

            <!-- Agent -->
            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Agentic AI
            </div>

            <NavLink
                title="Recommendations"
                :url="route('agent-recommendations.index')"
                :active="url.startsWith('/agent-recommendations')"
                :icon="IconRobot"
            />

            <NavLink
                title="Alternative Flight"
                :url="route('alternatives.index')"
                :active="url.startsWith('/alternatives')"
                :icon="IconRobot"
            />

            <NavLink
                title="Activity Logs"
                :url="route('agent-logs.index')"
                :active="url.startsWith('/agent-logs')"
                :icon="IconHistory"
            />
        </ul>
    </nav>
</template>
