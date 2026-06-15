<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { Moon } from "lucide-vue-next";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"));
};
</script>

<template>
    <Head title="Login" />

    <div
        class="min-h-screen bg-[#edf2f8] flex flex-col items-center justify-center px-4"
    >
        <div
            class="w-full max-w-5xl overflow-hidden rounded-2xl border bg-white shadow-sm grid md:grid-cols-2"
        >
            <!-- LEFT -->
            <div class="p-10 md:p-12 flex flex-col justify-center">
                <div class="mb-8 flex items-center justify-center gap-3">
                    <div
                        class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-yellow-200 flex items-center justify-center text-white"
                    >
                        💳
                    </div>
                    <h1 class="text-2xl font-semibold">
                        Smart Hub <span class="text-emerald-500">+</span>
                    </h1>
                </div>

                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-950">
                        Selamat Datang
                    </h2>
                    <p class="mt-3 text-gray-500 leading-relaxed">
                        Masuk ke platform Smart Hub untuk mengelola peminjaman
                        ruang kerja dan peralatan studio secara mandiri
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="test@example.com"
                            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-4 outline-none focus:ring-2 focus:ring-emerald-400"
                        />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium">Password</label>
                            <Link
                                :href="route('password.request')"
                                class="text-sm font-medium hover:underline"
                            >
                                Lupa Password
                            </Link>
                        </div>

                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="********"
                            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-4 outline-none focus:ring-2 focus:ring-emerald-400"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-emerald-500 py-4 font-semibold text-white hover:bg-emerald-600 transition"
                    >
                        Login
                    </button>
                </form>

                <p class="mt-8 text-center text-sm">
                    Tidak memiliki akun ?
                    <Link
                        :href="route('register')"
                        class="underline font-medium"
                    >
                        Daftar
                    </Link>
                </p>
            </div>

            <!-- RIGHT -->
            <div
                class="hidden md:flex items-center justify-center bg-[#f7f7f8]"
            >
                <img
                    src="/images/login-illustration.png"
                    alt="Login Illustration"
                    class="h-full w-full object-cover"
                />
            </div>
        </div>

        <p class="mt-8 text-sm text-gray-500 text-center">
            Dengan mengklik lanjutkan, anda menyetujui
            <a href="#" class="underline">Persyaratan Layanan</a>
            dan
            <a href="#" class="underline">Kebijakan Privasi Kami</a>
        </p>

        <button
            class="fixed bottom-8 right-8 h-14 w-20 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg"
        >
            <Moon class="h-5 w-5" />
        </button>
    </div>
</template>
