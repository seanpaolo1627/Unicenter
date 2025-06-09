<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h4>Create Payroll</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitPayroll">
          <div class="mb-3">
            <label for="employee_id" class="form-label">Employee</label>
            <select v-model="payroll.employee_id" class="form-control">
              <option disabled value="">Please select one</option>
              <option v-for="employee in employees" :key="employee.id" :value="employee.id">
                {{ employee.lastname }} {{ employee.firstname }} {{ employee.middlename }} 
              </option>
            </select>
          </div>

          <div class="mb-3">
            <label for="basic_salary" class="form-label">Basic Salary</label>
            <input type="number" v-model.number="payroll.basic_salary" class="form-control" required>
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
            <label for="loans" class="form-label">Loans</label>
            <input type="number" v-model.number="payroll.loans" class="form-control">
          </div>

          <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" v-model="payroll.start_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" v-model="payroll.end_date" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Create Payroll</button>
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

  computed: {
    governmentContributions() {
      const sss = this.payroll.basic_salary * 0.0363;
      const pagibig = 100; 
      const philhealth = this.payroll.basic_salary * 0.03;
      return sss + pagibig + philhealth;
    },
    professionalTax() {
      const annualSalary = this.payroll.basic_salary * 12;
      if (annualSalary <= 250000) return 0;
      if (annualSalary <= 400000) return (annualSalary - 250000) * 0.20 / 12;
      if (annualSalary <= 800000) return (30000 + (annualSalary - 400000) * 0.25) / 12;
      if (annualSalary <= 2000000) return (130000 + (annualSalary - 800000) * 0.30) / 12;
      if (annualSalary <= 8000000) return (490000 + (annualSalary - 2000000) * 0.32) / 12;
      return (2410000 + (annualSalary - 8000000) * 0.35) / 12;
    }
  },

  mounted() {
    this.fetchEmployees();
  },

  methods: {
    fetchEmployees() {
      axios.get('http://localhost:8000/api/employees')
        .then(response => {
          this.employees = response.data.employees.filter(emp => emp.status !== 'AWOL' && emp.status !== 'RESIGNED');
        })
        .catch(error => {
          console.error('Error fetching employees:', error);
        });
    },

    submitPayroll() {
      this.payroll.government_contributions = this.governmentContributions;
      this.payroll.professional_tax = this.professionalTax;

      axios.post('http://localhost:8000/api/payrolls', this.payroll)
        .then(response => {
          alert('Payroll created successfully!');
          this.$router.push('/payrolls');
        })
        .catch(error => {
          console.error('Error creating payroll:', error);
          alert('Failed to create payroll.');
        });
    }
  }
}
</script>
