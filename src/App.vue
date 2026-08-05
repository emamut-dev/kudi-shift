<template>
  <Menu />
  <div class="container-fluid">
    <router-view />
  </div>
</template>

<script setup>
import { ref, provide } from 'vue';
import Menu from './components/Menu.vue';

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

provide('fetchCollection', fetchCollection);
</script>
