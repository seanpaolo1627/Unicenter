<template>
  <div class="container">
    <div class="card mb-5">
      <div class="card-header">
        <h4>
          Role Assignments
          <RouterLink to="/assign/create" class="btn btn-primary float-end">Add</RouterLink>
        </h4>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Employee </th>
              <th>Designation ID</th>
              <th>Employee Type</th>
              <th>Probationary Period (in days)</th>
              <th>Daily Role</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="assigns.length > 0">
            <tr v-for="(assign, index) in assigns" :key="index">
              <td>{{ assign.id }}</td>
              <td>{{ assign.emp_num }}<span v-if="assign.firstname && assign.lastname"> - {{ assign.firstname }} {{ assign.lastname }}</span></td>
              <td>{{ assign.designation_id }}</td>
              <td>{{ assign.employee_type}}</td>
              <td>{{ assign.probationary}}</td>
              <td>{{ assign.daily_role}}</td>
              <td>{{ assign.status }}</td>
              <td>
                <RouterLink :to="{ path: '/assign/' + assign.id + '/edit' }" class="btn btn-success">Edit</RouterLink>
                <button type="button" @click="deleteAssign(assign.id)" class="btn btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="6">↺</td>
            </tr>
          </tbody>
        </table>
        <RouterLink to="/departments" class="btn btn-primary float-end">Departments</RouterLink>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Assignments',
  data() {
    return {
      assigns: [],
    };
  },
  mounted() {
    this.getAssignments();
  },
  methods: {
    getAssignments() {
      axios.get('http://localhost:8000/api/assign_designations')
        .then(res => {
          this.assigns = res.data.assigns;
        })
        .catch(error => {
          console.error('Error fetching assignments:', error);
        });
    },
    deleteAssign(id) {
      if (confirm('Confirm action: DELETE')) {
        axios.delete(`http://localhost:8000/api/assign_designations/${id}/delete`)
          .then(res => {
            alert(res.data.message);
            this.getAssignments();
          })
          .catch(error => {
            console.error('Error deleting assignment:', error);
          });
      }
    },
  },
};
</script>