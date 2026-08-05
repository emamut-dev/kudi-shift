<template>
  <form @submit.prevent="submitForm">
    <div class="row justify-content-center mt-5">
      <div class="col-md-4">
        <label for="id-journal" class="form-label">Jornada</label>
        <select v-model="selectedJournal" id="id-journal" class="form-select">
          <option :value="null">Seleccione una jornada</option>
          <option v-for="journal in journalsArray" :value="journal">
            {{ journal.name }} - {{ journal.monitor.data.display_name }}
          </option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="id-date" class="form-label">Fecha</label>
        <input
          type="date"
          v-model="selectedDate"
          id="id-date"
          class="form-control"
        />
      </div>
    </div>

    <div class="row justify-content-center mt-4">
      <div class="col-md-8" v-if="selectedJournal">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center">Modelos</th>
                <th
                  class="text-center"
                  v-for="sitio in sitiosArray"
                  :key="sitio.id"
                >
                  {{ sitio.name }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="modelo in selectedJournal.models" :key="modelo.ID">
                <td>{{ modelo.data.display_name }}</td>
                <td
                  v-for="sitio in sitiosArray"
                  :key="sitio.id"
                  class="text-center"
                >
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

        <button
          type="submit"
          class="btn btn-success btn-lg mt-3 mx-auto d-block"
        >
          Guardar Turno <BiFloppy class="ms-2" />
        </button>
      </div>
    </div>
  </form>

  <div class="row justify-content-center mt-5" v-if="lastShift?.data?.length">
    <div class="col-md-8">
      <h4 class="text-center fw-bold mb-3">
        Último turno: {{ lastShift['journal_date'] }}
      </h4>
      <Table :chart-data="lastShift" />
      <h4 class="text-center fw-bold">
        Total del turno: {{ lastShift.total_shift }} Tks
      </h4>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, inject, ref } from 'vue';
import BiFloppy from '~icons/bi/floppy';

import Table from '../components/Table.vue';

const shiftsArray = ref([]);
const journalsArray = ref([]);
const sitiosArray = ref([]);
const selectedJournal = ref(null);
const selectedDate = ref(new Date().toISOString().split('T')[0]);
const lastShift = ref(null);
const formData = reactive({});
const errorMessage = ref('');

const fetchCollection = inject('fetchCollection');
const requestHeaders = inject('requestHeaders', {});

async function getJournals() {
  await fetchCollection(
    'journals',
    journalsArray,
    'No se pudieron cargar las jornadas.',
  );
}

async function getSitios() {
  await fetchCollection(
    'sitios',
    sitiosArray,
    'No se pudieron cargar los sitios.',
  );
}

async function getShifts() {
  await fetchCollection(
    'shifts',
    shiftsArray,
    'No se pudieron cargar los turnos.',
  );

  await getLastShift();
}

async function getLastShift() {
  await fetchCollection(
    'shifts/last',
    lastShift,
    'No se pudo cargar el ultimo turno.',
  );
}

async function submitForm() {
  const sendData = {
    journal_date: selectedDate.value,
    contenido: {
      id_journal: selectedJournal.value.id,
      data: { ...formData },
    },
  };

  try {
    const response = await fetch(`${kudiShiftData.restUrl}shifts`, {
      method: 'POST',
      headers: requestHeaders,
      body: JSON.stringify(sendData),
    });

    if (!response.ok) {
      throw new Error(response.statusText || 'Error al guardar el turno.');
    }

    Object.keys(formData).forEach((key) => delete formData[key]);
    await getShifts();
  } catch (error) {
    console.error(error);
  }
}

onMounted(async () => {
  try {
    await Promise.all([getJournals(), getSitios(), getShifts()]);
  } catch (error) {
    errorMessage.value = error.message;
    console.error(error);
  }
});
</script>
