<template>
  <section class="shifts">
    <h1>Turnos</h1>

    <p v-if="isLoading">Cargando turnos...</p>
    <p v-else-if="errorMessage" role="alert">{{ errorMessage }}</p>
    <p v-else-if="shiftsArray.length === 0">No hay turnos disponibles.</p>
    <table v-else>
      <thead>
        <tr>
          <th scope="col">Fecha del turno</th>
          <th scope="col">Contenido</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="shift in shiftsArray" :key="shift.id">
          <td>{{ shift.fecha_turno }}</td>
          <td>{{ shift.contenido }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const shiftsArray = ref([]);
const isLoading = ref(true);
const errorMessage = ref('');

async function getShifts() {
  try {
    const res = await fetch(kudiShiftData.restUrl + 'shifts', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': kudiShiftData.nonce,
      },
    });
    const data = await res.json();
    shiftsArray.value = data;
  } catch (e) {
    errorMessage.value = 'No se pudieron cargar los turnos.';
  } finally {
    isLoading.value = false;
  }
}

onMounted(getShifts);
</script>
