<template>
    <div class="container-fluid py-4">
        <!-- <h3 class="mb-4 fw-bold text-primary">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard de Tickets
        </h3> -->

        <!-- Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3" v-for="card in cards" :key="card.title">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i :class="card.icon" class="fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-uppercase mb-1">{{ card.title }}</h6>
                        <h3 class="fw-bold mb-0 text-primary">{{ card.value }}</h3>
                        <small class="text-muted">{{ card.subtitle }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="fw-bold text-secondary mb-3">
                            <i class="bi bi-pie-chart-fill me-2"></i>Status dos Tickets
                        </h6>
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="fw-bold text-secondary mb-3">
                            <i class="bi bi-bar-chart-fill me-2"></i>Prioridades dos Tickets
                        </h6>
                        <canvas id="chartPrioridades"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import Chart from 'chart.js/auto'

const cards = ref([
    {
        title: 'Tickets Totais',
        value: 128,
        subtitle: 'em todos os sistemas',
        icon: 'bi bi-collection-fill text-primary',
    },
    {
        title: 'Tickets Abertos',
        value: 45,
        subtitle: 'aguardando atendimento',
        icon: 'bi bi-envelope-open text-warning',
    },
    {
        title: 'Em Atendimento',
        value: 30,
        subtitle: 'designados a agentes',
        icon: 'bi bi-person-workspace text-info',
    },
    {
        title: 'Concluídos',
        value: 53,
        subtitle: 'resolvidos com sucesso',
        icon: 'bi bi-check2-circle text-success',
    },
])

onMounted(() => {
    // Gráfico de Pizza - Status
    const ctx1 = document.getElementById('chartStatus')
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Aberto', 'Em Atendimento', 'Concluído', 'Cancelado'],
            datasets: [
                {
                    data: [45, 30, 53, 12],
                    backgroundColor: ['#ffc107', '#0dcaf0', '#198754', '#6c757d'],
                },
            ],
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                },
            },
        },
    })

    // Gráfico de Barras - Prioridades
    const ctx2 = document.getElementById('chartPrioridades')
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Baixa', 'Média', 'Alta', 'Crítica'],
            datasets: [
                {
                    label: 'Quantidade',
                    data: [15, 40, 50, 23],
                    backgroundColor: ['#6c757d', '#0d6efd', '#ffc107', '#dc3545'],
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    })
})
</script>

<style scoped>
/* .card {
    border-radius: 1rem;
    transition: all 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
} */
</style>
