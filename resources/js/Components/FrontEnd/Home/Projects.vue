<script setup>
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    projects: Array,
});

// filter active projects once, then make them reactive
const activeprojects = ref(
    props.projects
        .filter((project) => project.is_active)
        .map((p) => ({ ...p, currentNumber: 0 })),
);

function animateCount(project) {
    let start = 0;
    const end = project.number;
    const duration = 2000; // 2 seconds
    const stepTime = Math.max(Math.floor(duration / end), 20);

    const timer = setInterval(() => {
        start += 1;
        project.currentNumber = start;
        if (start >= end) {
            clearInterval(timer);
        }
    }, stepTime);
}

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const index = entry.target.getAttribute("data-index");
                    animateCount(activeprojects.value[index]);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.3 },
    );

    document.querySelectorAll(".projects").forEach((el, index) => {
        el.setAttribute("data-index", index);
        observer.observe(el);
    });
});
</script>

<template>
    <div class="relative">
        <!-- Background -->
        <div class="absolute inset-0 -z-10">
            <!-- image -->
            <div
                class="absolute inset-0 bg-cover bg-center"
                :style="{
                    backgroundImage: `url(/storage/${$page.props.banner?.project_image})`,
                }"
            ></div>

            <!-- overlay -->
            <div class="absolute inset-0 bg-blue-500 opacity-70"></div>
        </div>

        <!-- CONTENT -->
        <div class="container py-10 text-white">
            <div class="container relative z-10">
                <div
                    class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-6"
                >
                    <div
                        v-for="(project, index) in activeprojects"
                        :key="index"
                        class="shadow-lg text-center text-white"
                    >
                        <div
                            class="border-white border-2 px-5 py-10 rounded projects"
                        >
                            <i :class="project.icon + ' text-6xl mb-3'"></i>
                            <h3 class="font-bold text-3xl mb-2">
                                {{ project.currentNumber }}
                            </h3>
                            <p
                                class="text-gray-200 leading-7 text-xl font-bold"
                            >
                                {{ project.name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.projects {
    position: relative;
    overflow: hidden;
}
.projects::after,
.projects::before {
    content: "";
    position: absolute;
    width: 50%;
    height: 5px;
    background-color: white;
    transition: transform 0.8s ease-in-out;
}
.projects::after {
    top: 0;
    left: 0;
    transform: translateX(0);
}
.projects::before {
    bottom: 0;
    right: 0;
    transform: translateX(0);
}
.projects:hover::after {
    transform: translateX(100%);
}
.projects:hover::before {
    transform: translateX(-100%);
}
</style>
