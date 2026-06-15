<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";

import { Card, CardContent } from "@/Components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";

import {
    IconBox,
    IconCalendarEvent,
    IconChartArrowsVertical,
    IconCreditCardPay,
    IconDoorEnter,
    IconDoorExit,
    IconLogout2,
    IconLogs,
    IconMenorah,
    IconMoneybag,
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
            <CardContent class="flex items-center gap-x-3 p-3">
                <Avatar>
                    <AvatarImage :src="auth?.avatar" />
                    <AvatarFallback>
                        {{ auth?.name?.substring(0, 1) }}
                    </AvatarFallback>
                </Avatar>

                <div class="flex flex-col">
                    <span
                        class="line-clamp-1 text-sm font-medium leading-relaxed tracking-tighter"
                    >
                        {{ auth?.name }}
                    </span>

                    <span class="line-clamp-1 text-xs font-light">
                        {{ auth?.id }}
                    </span>
                </div>
            </CardContent>
        </Card>

        <ul role="list" class="flex flex-1 flex-col gap-y-2">
            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                General
            </div>

            <NavLink
                title="Dashboard"
                url="#"
                :active="url.startsWith('/dashboard')"
                :icon="IconBox"
            />

            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Master
            </div>

            <NavLink
                title="Metode Pembayaran"
                url="#"
                :active="url.startsWith('/payments')"
                :icon="IconCreditCardPay"
            />

            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Rencana
            </div>

            <NavLink
                title="Data Peralatan"
                url="#"
                :active="url.startsWith('/goals')"
                :icon="IconMoneybag"
            />

            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Pelacakan
            </div>

            <NavLink
                title="Anggaran"
                url="#"
                :active="url.startsWith('/budgets')"
                :icon="IconChartArrowsVertical"
            />

            <NavLink
                title="Pemasukan"
                url="#"
                :active="url.startsWith('/incomes')"
                :icon="IconDoorEnter"
            />

            <NavLink
                title="Pengeluaran"
                url="#"
                :active="url.startsWith('/expenses')"
                :icon="IconDoorExit"
            />

            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Aset dan Kewajiban
            </div>

            <NavLink
                title="Kekayaan Bersih"
                url="#"
                :active="url.startsWith('/net-worths')"
                :icon="IconMenorah"
            />

            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Laporan
            </div>

            <NavLink
                title="Laporan Pelacakan"
                url="#"
                :active="url.startsWith('/report-trackings')"
                :icon="IconLogs"
            />

            <NavLink
                title="Laporan Tahunan"
                url="#"
                :active="url.startsWith('/annual-reports')"
                :icon="IconCalendarEvent"
            />

            <div class="px-3 py-2 text-sm font-medium text-muted-foreground">
                Lainnya
            </div>

            <NavLink
                as="button"
                method="post"
                title="Logout"
                :url="route('logout')"
                :active="url.startsWith('/logout')"
                :icon="IconLogout2"
                class="w-full"
            />
        </ul>
    </nav>
</template>
