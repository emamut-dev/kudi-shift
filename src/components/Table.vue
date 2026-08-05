<template>
  <div class="table-responsive" v-if="tableRows.length">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Modelo</th>
          <th v-for="column in tableColumns" :key="column">
            {{ column }}
          </th>
          <th>Total modelo</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in tableRows" :key="index">
          <td>{{ row.model }}</td>
          <td
            class="text-center"
            v-for="column in tableColumns"
            :key="`${index}-${column}`"
          >
            {{ row[column] ?? '-' }}
          </td>
          <td class="text-center fw-bold">
            {{ getRowTotal(row) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  chartData: {
    type: Object,
    default: () => ({ data: [] }),
  },
});

const tableRows = computed(() => props.chartData?.data ?? []);

const tableColumns = computed(() => {
  const columns = new Set();

  tableRows.value.forEach((row) => {
    Object.keys(row).forEach((key) => {
      if (key !== 'model') {
        columns.add(key);
      }
    });
  });

  return Array.from(columns);
});

function getRowTotal(row) {
  return Object.values(row)
    .filter((value) => typeof value === 'number')
    .reduce((sum, value) => sum + value, 0);
}
</script>
