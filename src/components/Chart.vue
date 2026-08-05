<template>
  <div class="row justify-content-center mt-5">
    <div class="col">
      <div
        class="chart-container"
        style="position: relative; height: 400px; width: 100%"
      >
        <Line
          v-if="chartSeries.datasets?.length"
          :data="chartSeries"
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
import { computed } from 'vue';
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

const props = defineProps({
  chartData: {
    type: Object,
    default: () => ({ labels: [], datasets: [] }),
  },
});

const chartSeries = computed(
  () => props.chartData ?? { labels: [], datasets: [] },
);

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
</script>
