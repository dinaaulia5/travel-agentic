<script setup>
import { watch } from "vue";
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";

import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog";

const props = defineProps({
    open: Boolean,

    mode: {
        type: String,
        default: "create",
    },

    airport: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["update:open"]);

const form = useForm({
    code: "",
    name: "",
    city: "",
    country: "",
    image: null,
    _method: "POST",
});

watch(
    () => props.airport,
    (airport) => {
        form.clearErrors();

        if (props.mode === "edit" && airport) {
            form.code = airport.code;
            form.name = airport.name;
            form.city = airport.city;
            form.country = airport.country;
            form.image = null;
            form._method = "PUT";
        } else {
            form.reset();
            form._method = "POST";
        }
    },
    { immediate: true },
);

const onChangeImage = (event) => {
    const file = event.target.files[0];

    if (file) {
        form.image = file;
    }
};

const submit = () => {
    const url =
        props.mode === "create"
            ? route("airports.store")
            : route("airports.update", props.airport.id);

    form.post(url, {
        forceFormData: true,
        preserveScroll: true,

        onSuccess: () => {
            form.reset();

            emit("update:open", false);
        },
    });
};
</script>
<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="sm:max-w-2xl">
            <DialogHeader>
                <DialogTitle>
                    {{ mode === "create" ? "Tambah Bandara" : "Edit Bandara" }}
                </DialogTitle>

                <DialogDescription>
                    Lengkapi informasi bandara.
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- CODE -->
                    <div class="space-y-2">
                        <Label>Kode Bandara</Label>

                        <Input v-model="form.code" placeholder="Contoh: CGK" />

                        <InputError :message="form.errors.code" />
                    </div>

                    <!-- CITY -->
                    <div class="space-y-2">
                        <Label>Kota</Label>

                        <Input
                            v-model="form.city"
                            placeholder="Contoh: Tangerang"
                        />

                        <InputError :message="form.errors.city" />
                    </div>

                    <!-- NAME -->
                    <div class="space-y-2 md:col-span-2">
                        <Label>Nama Bandara</Label>

                        <Input
                            v-model="form.name"
                            placeholder="Contoh: Soekarno Hatta International Airport"
                        />

                        <InputError :message="form.errors.name" />
                    </div>

                    <!-- COUNTRY -->
                    <div class="space-y-2">
                        <Label>Negara</Label>

                        <Input v-model="form.country" placeholder="Indonesia" />

                        <InputError :message="form.errors.country" />
                    </div>
                    <!-- IMAGE -->
                    <div class="space-y-2 md:col-span-2">
                        <Label>Gambar Bandara</Label>

                        <Input
                            type="file"
                            accept="image/png,image/jpg,image/jpeg,image/webp"
                            @change="onChangeImage"
                        />

                        <InputError :message="form.errors.image" />
                    </div>

                    <div
                        v-if="mode === 'edit' && airport?.image"
                        class="space-y-2 md:col-span-2"
                    >
                        <Label>Gambar Saat Ini</Label>

                        <img
                            :src="airport.image"
                            class="h-32 rounded-lg border object-cover"
                        />
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t pt-4">
                    <Button
                        type="button"
                        variant="outline"
                        @click="emit('update:open', false)"
                    >
                        Batal
                    </Button>

                    <Button
                        type="submit"
                        variant="emerald"
                        :disabled="form.processing"
                    >
                        {{ mode === "create" ? "Simpan" : "Update" }}
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
