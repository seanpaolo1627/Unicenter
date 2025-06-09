<template>
  <div class="container mt-5">  
    <div class="card mb-5">
      <div class="card-header">
        <h4>Edit</h4>
      </div>
      <div class="card-body">

        <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
          <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
            {{ error[0] }}  
          </li>
        </ul>

        <div class="mb-3">
          <label for="">Name</label>
          <input type="text" v-model="model.department.dept_name" class="form-control">
        </div>
        <div class="mb-3">
          <label for="">Status</label>
          <select v-model="model.department.status" class="form-control">
            <option value="ACTIVE">Active</option>
            <option value="INACTIVE">Inactive</option>
          </select>
        </div>
        <div class="mb-3">
          <button type="button" @click="updateDepartment" class="btn btn-primary">Done</button>
          <RouterLink to="/departments" class="btn btn-primary float-end">Back</RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'departmentEdit',
  data() {
    return {
      departmentId: '',
      errorList: '',
      model: {
        department: {
          dept_name: '',
          status: ''
        }
      }
    }
  },
  mounted() {
    this.departmentId = this.$route.params.id;
    this.getDepartmentData(this.$route.params.id);
  },
  methods: {
    getDepartmentData(departmentId) {
      axios.get(`http://localhost:8000/api/departments/${departmentId}/edit`)
        .then(res => {

          this.model.department.dept_name = res.data.department.dept_name;
          this.model.department.status = res.data.department.status;
        })
        .catch(error => {
          if (error.response && error.response.status === 404) {
            alert(error.response.data.message);
          }
        });
    },
    updateDepartment() {
      axios.put(`http://localhost:8000/api/departments/${this.departmentId}/edit`, this.model.department)
        .then(res => {
          alert(res.data.message);
          this.errorList = '';
          this.$router.push('/departments');
        })
        .catch(error => {
          if (error.response) {
            if (error.response.status === 404) {
              alert(error.response.data.message);
            } else if (error.response.status === 422) {
              this.errorList = error.response.data.errors;
            }
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log('Error', error.message);
          }
        });
    }
  }
}
</script>