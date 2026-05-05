<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { onMounted, ref } from "vue";
import Chart from "chart.js/auto";

const chartRef = ref(null);

onMounted(() => {
    new Chart(chartRef.value, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [
                {
                    label: "Sales",
                    data: [12, 19, 8, 15, 22, 30],
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    });
});
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div class="p-6 space-y-6">
            <!-- ================= CARDS ================= -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- CARD 1 -->
                <div
                    class="p-6 rounded-2xl text-white shadow-lg bg-gradient-to-r from-blue-500 to-blue-700"
                >
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm">Total Services</p>
                            <h2 class="text-3xl font-bold">25</h2>
                        </div>
                        <i class="fa-solid fa-gear text-3xl"></i>
                    </div>
                </div>

                <!-- CARD 2 -->
                <div
                    class="p-6 rounded-2xl text-white shadow-lg bg-gradient-to-r from-green-500 to-green-700"
                >
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm">Total Portfolio</p>
                            <h2 class="text-3xl font-bold">48</h2>
                        </div>
                        <i class="fa-solid fa-briefcase text-3xl"></i>
                    </div>
                </div>

                <!-- CARD 3 -->
                <div
                    class="p-6 rounded-2xl text-white shadow-lg bg-gradient-to-r from-purple-500 to-purple-700"
                >
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm">Total Comments</p>
                            <h2 class="text-3xl font-bold">120</h2>
                        </div>
                        <i class="fa-solid fa-comments text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- ================= CHART ================= -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-xl font-bold mb-4">Monthly Overview</h2>

                <canvas ref="chartRef" height="100"></canvas>
            </div>
        </div>
    </Layout>
</template>
