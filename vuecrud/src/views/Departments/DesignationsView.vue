<template>
  <div class="container">
    <div class="card mb-5">
      <div class="card-header">
        <h4>
          Designations
          <button class="btn btn-primary float-end mb-2" @click="showAddForm = !showAddForm">
            {{ showAddForm ? 'Close' : 'Add Designation' }}
          </button>
        </h4>
      </div>
      <div class="card-body">
        <div v-if="showAddForm">
          <div class="card mb-4">
            <div class="card-body">
              <ul class="alert alert-warning" v-if="Object.keys(errorList).length > 0">
                <li class="mb-0 ms-3" v-for="(error, index) in errorList" :key="index">
                  {{ error[0] }}  
                </li>
              </ul>
              <div class="mb-3">
                <label for="">Name</label>
                <input type="text" v-model="model.designation.designation_name" class="form-control">
              </div>
              <div class="mb-3">
                <label for="">Department ID</label>
                <select v-model="model.designation.department_id" class="form-control">
                  <option v-for="department in departments" :value="department.id" :key="department.id">{{ department.id }}</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="">Status</label>
                <select v-model="model.designation.status" class="form-control">
                  <option value="ACTIVE">ACTIVE</option>
                  <option value="INACTIVE">INACTIVE</option>
                </select>
              </div>
              <div class="mb-3">
                <button type="button" @click="saveDesignation" class="btn btn-primary">Add</button>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Department ID</th>
              <th>Status</th>
              <th>Date Added</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="designations.length > 0">
            <tr v-for="(designation, index) in designations" :key="index">
              <td>{{ designation.id }}</td>
              <td>{{ designation.designation_name }}</td>
              <td>{{ designation.department_id }}</td>
              <td>{{ designation.status }}</td>
              <td>{{ designation.created_at }}</td>
              <td>
                <RouterLink :to="{ path: `/designation/${designation.id}/edit` }" class="btn btn-success">Edit</RouterLink>
                <button type="button" @click="deleteDesignation(designation.id)" class="btn btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="6">↺</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { RouterLink } from 'vue-router'
export default {
  name: 'DesignationsView',
  components: { RouterLink },
  data() {
    return {
      designations: [],
      departments: [],
      showAddForm: false,
      errorList: {},
      model: {
        designation: {
          designation_name: '',
          department_id: '',
          status: ''
        }
      }
    }
  },
  mounted() {
    this.getDesignations();
    this.getDepartments();
  },
  methods: {
    getDesignations() {
      axios.get('http://localhost:8000/api/designation')
      .then(res => {
        this.designations = res.data.designations;
      })
      .catch(error => {
        console.error('Error fetching designations:', error);
      });
    },
    getDepartments() {
      axios.get('http://localhost:8000/api/departments')
      .then(res => {
        this.departments = res.data.departments;
      })
      .catch(error => {
        console.error('Error fetching departments:', error);
      });
    },
    saveDesignation() {
      axios.post('http://localhost:8000/api/designation', this.model.designation)
      .then(res => {
        alert(res.data.message);
        this.model.designation = { designation_name: '', department_id: '', status: '' };
        this.errorList = {};
        this.showAddForm = false;
        this.getDesignations();
      })
      .catch(error => {
        if (error.response && error.response.status == 422) {
          this.errorList = error.response.data.errors;
        } else {
          console.error('Error saving designation:', error);
        }
      });
    },
    deleteDesignation(designationId) {
      if (confirm('Confirm action: DELETE')) {
        axios.delete(`http://localhost:8000/api/designation/${designationId}/delete`)
        .then(res => {
          alert(res.data.message);
          this.getDesignations();
        })
        .catch(error => {
          if (error.response && error.response.status === 404) {
            alert(error.response.data.message);
          } else {
            console.error('Error deleting designation:', error);
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