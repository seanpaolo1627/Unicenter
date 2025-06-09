<template>
  <div class="container">
    <div class="card mb-5">
      <div class="card-header">
        <h4>Edit Payroll</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="updatePayroll">
          <!-- Employee Selection -->
          <div class="mb-3">
            <label for="employee_id" class="form-label">Employee</label>
            <select v-model="payroll.employee_id" class="form-control" disabled>
              <option v-for="employee in employees" :key="employee.id" :value="employee.id">
                {{ employee.lastname }} {{ employee.firstname }} {{ employee.middlename }} 
              </option>
            </select>
          </div>

          <!-- Salary Inputs -->
          <div class="mb-3">
            <label for="basic_salary" class="form-label">Basic Salary</label>
            <input type="number" v-model.number="payroll.basic_salary" class="form-control">
          </div>

          <div class="mb-3">
            <label for="additionals" class="form-label">Additionals</label>
            <input type="number" v-model.number="payroll.additionals" class="form-control">
          </div>

          <div class="mb-3">
            <label for="deductions" class="form-label">Deductions</label>
            <input type="number" v-model.number="payroll.deductions" class="form-control">
          </div>

          <div class="mb-3">
            <label for="government_contributions" class="form-label">Government Contributions</label>
            <input type="number" v-model.number="payroll.government_contributions" class="form-control">
          </div>

          <div class="mb-3">
            <label for="professional_tax" class="form-label">Professional Tax</label>
            <input type="number" v-model.number="payroll.professional_tax" class="form-control">
          </div>

          <div class="mb-3">
            <label for="loans" class="form-label">Loans</label>
            <input type="number" v-model.number="payroll.loans" class="form-control">
          </div>

          <!-- Date Inputs -->
          <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" v-model="payroll.start_date" class="form-control">
          </div>

          <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" v-model="payroll.end_date" class="form-control">
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Update Payslip</button>
          <button type="button" @click="deletePayroll" class="btn btn-danger float-end">Delete Payslip</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      payrollId: '',
      payroll: {
        employee_id: '',
        basic_salary: 0,
        additionals: 0,
        deductions: 0,
        government_contributions: 0,
        professional_tax: 0,
        loans: 0,
        start_date: '',
        end_date: ''
      },
      employees: []
    };
  },

  mounted() {
    this.payrollId = this.$route.params.id;
    this.fetchPayrollData();
    this.fetchEmployees();
  },

  methods: {
    fetchEmployees() {
      axios.get('http://localhost:8000/api/employees')
        .then(response => {
          this.employees = response.data.employees;
        })
        .catch(error => {
          console.error('Error fetching employees:', error);
        });
    },

    fetchPayrollData() {
      axios.get(`http://localhost:8000/api/payrolls/${this.payrollId}`)
        .then(response => {
          this.payroll = response.data.payroll;
        })
        .catch(error => {
          console.error('Error fetching payroll data:', error);
        });
    },

    updatePayroll() {
      axios.put(`http://localhost:8000/api/payrolls/${this.payrollId}`, this.payroll)
        .then(response => {
          alert('Payroll updated successfully!');
          this.$router.push('/payrolls');
        })
        .catch(error => {
          console.error('Error updating payroll:', error);
          alert('Failed to update payroll.');
        });
    },

    deletePayroll() {
      if (confirm('Are you sure you want to delete this payroll?')) {
        axios.delete(`http://localhost:8000/api/payrolls/${this.payrollId}`)
          .then(response => {
            alert('Payroll deleted successfully!');
            this.$router.push('/payrolls');
          })
          .catch(error => {
            console.error('Error deleting payroll:', error);
            alert('Failed to delete payroll.');
          });
      }
    }
  }
}
</script>
