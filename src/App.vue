<template>
  <section class="shifts">
    <div class="row">
      <div class="col">
        <h1 class="text-center fw-bold">Ingreso de Turno</h1>
      </div>
    </div>

    <div class="row justify-content-center mt-4">
      <div class="col-md-7">
        <form>
          <div class="mb-3">
            <label for="id-journal" class="form-label">Jornada</label>
            <select name="id-journal" id="id-journal" class="form-control">
              <option value="">Seleccione una jornada</option>
              <option value="1">Jornada 1</option>
              <option value="2">Jornada 2</option>
            </select>
          </div>
        </form>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col">
        <table class="table table-striped table-bordered">
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
      </div>
    </div>
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
