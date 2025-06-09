<template>
  <div class="container">
    <div class="card mb-5">
      <div class ="card-header">
        <h4>
          Employees
          <RouterLink to="/employee/create" class="btn btn-primary float-end">Add</RouterLink>
        </h4>
      </div>
      <div class="card-body">
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Employee No.</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Building / Street</th>
              <th>Barangay</th>
              <th>City</th>
              <th>Province</th>
              <th>ZIP Code</th>
              <th>Date Joined</th>
            </tr>
          </thead>
          <tbody v-if="this.employees.length > 0">
            <tr v-for="(employee, index) in this.employees" :key="index">
              <td>{{ employee.id }}</td>
              <td>{{ employee.emp_num }}</td>
              <td>{{ employee.lastname }}</td>
              <td>{{ employee.firstname }}</td>
              <td>{{ employee.middlename }}</td>
              <td>{{ employee.address_line }}</td>
              <td>{{ employee.brgy}}</td>
              <td>{{ employee.city }}</td>
              <td>{{ employee.province }}</td>
              <td>{{ employee.zipcode }}</td>
              <td>{{ employee.created_at }}</td>
              <td>
                <RouterLink :to="{ path: '/employee/'+employee.id+'/edit' }" class="btn btn-success">Edit
                </RouterLink>
                <button type ="button" @click="deleteEmployee(employee.id)" class="btn btn-danger">Delete
                </button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="8">↺</td>
            </tr>
          </tbody>
        </table>
                  <div class="row">
          <div class="col-md-6">
            <RouterLink to="/departments" class="btn btn-primary">Departments</RouterLink>
          </div>
          <div class="col-md-6">
            <RouterLink to="/assign" class="btn btn-primary float-end">Assign</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default{
  name: 'employees',
  data(){
    return{
      employees: []
    }
  },
  mounted(){

    this.getEmployees();

  },
  methods: {
    getEmployees(){

      axios.get('http://localhost:8000/api/employees').then(res => {
        this.employees = res.data.employees

      });
    },

    deleteEmployee(employeeId){

      if(confirm('Confirm action: DELETE')){

        axios.delete(`http://localhost:8000/api/employees/${employeeId}/delete`)
        .then(res => {

          alert(res.data.message);
          this.getEmployees();

        })
        .catch(function (error) {

          if(error.response){

            if (error.response.status == 404){
              alert(error.response.data.message);
            }
          }
        });

      }
    },

  }

}

</script>