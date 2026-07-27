<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <h1 class="text-center fw-bold">Ingreso de Turno</h1>
      </div>
    </div>

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
        <div class="col-md-8 table-responsive" v-if="selectedJournal">
          <table class="table table-bordered table-striped">
            <thead>
              <th class="text-center">Modelos</th>
              <th
                class="text-center"
                style="width: 20px"
                v-for="sitio in sitiosArray"
                :key="sitio.id"
              >
                {{ sitio.name }}
              </th>
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

          <button
            type="submit"
            class="btn btn-success btn-lg mt-3 mx-auto d-block"
          >
            Guardar Turno <BiFloppy class="ms-2" />
          </button>
        </div>
      </div>
    </form>

    <div class="row justify-content-center mt-4">
      <div class="col-md-8">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">Fecha del turno</th>
              <th scope="col" class="w-25">Total del turno</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="shift in shiftsArray" :key="shift.id">
              <td>{{ shift.journal_date }}</td>
              <td>{{ shift.total_shift }} Tks</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import BiFloppy from '~icons/bi/floppy';

const shiftsArray = ref([]);
const journalsArray = ref([]);
const sitiosArray = ref([]);
const selectedJournal = ref(null);
const selectedDate = ref(new Date().toISOString().split('T')[0]);
const formData = reactive({});

const requestHeaders = {
  Accept: 'application/json',
  'Content-Type': 'application/json',
  'X-WP-Nonce': kudiShiftData.nonce,
};

async function fetchCollection(endpoint, targetArray, errorText) {
  const response = await fetch(`${kudiShiftData.restUrl}${endpoint}`, {
    method: 'GET',
    headers: requestHeaders,
  });

  if (!response.ok) {
    throw new Error(errorText);
  }

  targetArray.value = await response.json();
}

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
}

async function submitForm() {
  const sendData = {
    journal_date: selectedDate.value``,
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

    // Clear form data after successful submission
    Object.keys(formData).forEach((key) => delete formData[key]);
    await getShifts(); // Refresh shifts list
  } catch (error) {
    console.error(error);
  }
}

onMounted(async () => {
  try {
    await Promise.all([getJournals(), getSitios(), getShifts()]);
  } catch (error) {
    errorMessage.value = error.message;
  }
});
</script>
