<template>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <th class="text-center">Modelos</th>
        <th class="text-center" v-for="sitio in sitiosArray" :key="sitio.id">
          {{ sitio.name }}
        </th>
      </thead>
      <tbody>
        <tr v-for="modelo in selectedJournal.models" :key="modelo.ID">
          <td>{{ modelo.data.display_name }}</td>
          <td v-for="sitio in sitiosArray" :key="sitio.id" class="text-center">
            <input
              type="number"
              min="0"
              class="form-control"
              :data-modelo-id="modelo.ID"
              :data-sitio-id="sitio.id"
              v-model="formData[`${modelo.ID}-${sitio.id}`]"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script setup>
const props = defineProps({
  chartData: {
    type: Object,
    default: () => ({ labels: [], datasets: [] }),
  },
});
</script>
