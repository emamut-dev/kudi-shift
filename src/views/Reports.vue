<template>
  <div class="row justify-content-center mt-5">
    <div class="col-md-8">
      <div
        class="chart-container"
        style="position: relative; height: 400px; width: 100%"
      >
        <Line
          v-if="chartData.datasets?.length"
          :data="chartData"
          :options="chartOptions"
        />
        <div v-else class="text-center text-muted py-4">
          No hay datos para mostrar.
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, inject, onMounted } from 'vue';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';

const fetchCollection = inject('fetchCollection');
const shiftsArray = ref([]);
const chartData = ref({ labels: [], datasets: [] });
const errorMessage = ref('');

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
);

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
};

function getChartData(data) {
  const shiftItems = Array.isArray(data) ? data : [];
  const labels = shiftItems.map((shift) => shift.journal_date || 'Sin fecha');
  const values = shiftItems.map((shift) => {
    const totalValue = shift?.total_shift ?? shift?.contenido?.data?.total ?? 0;
    return Number(totalValue) || 0;
  });

  chartData.value = {
    labels,
    datasets: [
      {
        label: 'Tokens',
        borderColor: '#41B883',
        backgroundColor: 'rgba(65, 184, 131, 0.2)',
        fill: true,
        tension: 0.3,
        pointRadius: 4,
        pointHoverRadius: 6,
        data: values,
      },
    ],
  };
}

async function getShifts() {
  await fetchCollection(
    'shifts',
    shiftsArray,
    'No se pudieron cargar los turnos.',
  );

  getChartData(shiftsArray.value);
}

onMounted(async () => {
  try {
    await getShifts();
  } catch (error) {
    errorMessage.value = error.message;
    console.error(error);
  }
});
</script>
