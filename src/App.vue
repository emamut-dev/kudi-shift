<!-- src/App.vue -->
<template>
  <form @submit.prevent="enviar">
    <input v-model="form.titulo" placeholder="Título" required />
    <input v-model="form.email" type="email" placeholder="Email" required />
    <textarea v-model="form.mensaje" placeholder="Mensaje"></textarea>
    <button type="submit" :disabled="cargando">
      {{ cargando ? 'Enviando...' : 'Enviar' }}
    </button>
    <p v-if="resultado">{{ resultado }}</p>
  </form>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({ titulo: '', email: '', mensaje: '' });
const cargando = ref(false);
const resultado = ref('');

async function enviar() {
  cargando.value = true;
  try {
    const res = await fetch(mpvsData.restUrl + 'submit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': mpvsData.nonce, // necesario si el endpoint requiere auth
      },
      body: JSON.stringify(form.value),
    });
    const data = await res.json();
    resultado.value = data.success ? '¡Guardado correctamente!' : data.error;
  } catch (e) {
    resultado.value = 'Error de red';
  } finally {
    cargando.value = false;
  }
}
</script>
