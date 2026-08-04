<template>
  <nav
    class="navbar bg-secondary navbar-expand-lg sticky-top border-bottom border-body mt-0"
    data-bs-theme="dark"
  >
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Turnos</a>
    </div>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link to="/" class="nav-link" aria-current="page"
            >Inicio</router-link
          >
        </li>
        <li class="nav-item">
          <router-link to="/reports" class="nav-link">Reportes</router-link>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container-fluid">
    <router-view />
  </div>
</template>

<script setup>
import { ref, provide } from 'vue';

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
