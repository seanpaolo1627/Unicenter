<template>
  <div class="container">
    <div class="card mb-5">
      <div class ="card-header">
        <h4>
          Departments
          <RouterLink to="/departments/create" class="btn btn-primary float-end">Add Department</RouterLink>
        </h4>
      </div>
      <div class="card-body">
        <h5>Departments</h5>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Status</th>
              <th>Date Added</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="departments.length > 0">
            <tr v-for="(department, index) in departments" :key="index">
              <td>{{ department.id }}</td>
              <td>{{ department.dept_name }}</td>
              <td>{{ department.status }}</td>
              <td>{{ department.created_at }}</td>
              <td>
                <RouterLink :to="{ path: `/departments/${department.id}/edit` }" class="btn btn-success">Edit</RouterLink>
                <button type="button" @click="deleteDepartment(department.id)" class="btn btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="5">↺</td>
            </tr>
          </tbody>
        </table>
        <RouterLink to="/employee" class="btn btn-primary float-end">Employees</RouterLink>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: 'DepartmentView',
    data() {
      return {
        departments: []
      }
    },
    mounted() {
      this.getDepartments();
    },
    methods: {
      getDepartments() {
        axios.get('http://localhost:8000/api/departments')
        .then(res => {
          this.departments = res.data.departments;
        })
        .catch(error => {
          console.error('Error fetching departments:', error);
        });
      },
      deleteDepartment(departmentId) {
        if (confirm('Confirm action: DELETE')) {
          axios.delete(`http://localhost:8000/api/departments/${departmentId}/delete`)
          .then(res => {
            alert(res.data.message);
            this.departments = this.departments.filter(dep => dep.id !== departmentId);
          })
          .catch(error => {
            if (error.response && error.response.status === 404) {
              alert(error.response.data.message);
            } else {
              console.error('Error deleting department:', error);
            }
          });
        }
      }
    }
  }
</script>

<style scoped>
  .mb-3 {
    margin-bottom: 2rem;
  }
</style>