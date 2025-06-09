<script setup>
  import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    <div class="wrapper">
      <nav class="navbar mb-5 navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <RouterLink class="navbar-brand" to="/employee">Unicenter Communications</RouterLink>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-3 mb-lg-0">
              <li class="nav-item">
                <RouterLink class="nav-link" to="/employee">Employees</RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" to="/departments">Departments</RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" to="/designation">Designations</RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" to="/attendance">Attendance</RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" to="/assign">Roles</RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" to="/Payrolls">Payroll</RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" to="/payrolls/Report">Payroll Overall Report</RouterLink>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <RouterView />
</template>

<style scoped>
.nav-item {
  display: inline-block;
  margin-right: 10px;
}
</style>
