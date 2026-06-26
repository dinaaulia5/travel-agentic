<script setup>
import { Link } from "@inertiajs/vue3";
import { IconCash, IconPlaneArrival } from "@tabler/icons-vue";

defineProps({
    url: {
        type: String,
        default: "#",
    },
});
</script>

<template>
    <Link :href="url" class="mt-6 flex items-center gap-x-2">
        <div
            class="rounded-xl bg-gradient-to-br from-emerald-400 via-emerald-500 to-yellow-200 p-2"
        >
            <IconPlaneArrival class="size-6 text-white" />
        </div>

        <span
            class="text-xl font-semibold leading-relaxed tracking-wide dark:text-emerald-500"
        >
            Travel Agentic
            <span class="text-lg text-emerald-500 dark:text-white"> + </span>
        </span>
    </Link>
</template>
