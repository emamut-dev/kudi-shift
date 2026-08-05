<template>
  <nav
    class="navbar bg-secondary navbar-expand-lg sticky-top border-bottom border-body mt-0 nav-underline px-3"
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
          <router-link to="/" class="nav-link" active-class="active"
            >Inicio</router-link
          >
        </li>
        <li class="nav-item">
          <router-link to="/reports" class="nav-link" active-class="active"
            >Reportes</router-link
          >
        </li>
      </ul>
    </div>
  </nav>
</template>
