<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <button class="btn btn-primary" @click="toggleFormVisibility">Add Payslip</button>
      </div>
      <div class="card-body" v-if="isFormVisible">
        <form @submit.prevent="submitPayroll">
          <!-- Employee Selection -->
          <div class="mb-3">
            <label for="employee_id" class="form-label">Employee</label>
            <select v-model="payroll.employee_id" class="form-control">
              <option disabled value="">Select an employee</option>
              <option v-for="employee in employees" :key="employee.id" :value="employee.id">
                {{ employee.lastname }}, {{ employee.firstname }} {{ employee.middlename }}
              </option>
            </select>
          </div>

          <!-- Salary Inputs -->
          <div class="mb-3" v-for="(input, label) in payrollInputs" :key="label">
            <label :for="label" class="form-label">{{ label }}</label>
            <input :type="input.type" v-model.number="payroll[input.model]" :class="input.class">
          </div>

          <!-- Date Inputs -->
          <div class="mb-3" v-for="(input, label) in dateInputs" :key="label">
            <label :for="label" class="form-label">{{ label }}</label>
            <input :type="input.type" v-model="payroll[input.model]" :class="input.class">
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Generate Payslip</button>
        </form>
      </div>
    </div>
    <!-- Payroll Table -->
    <div v-if="payrolls.length > 0">
      <h3>Generated Payslips</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Employee Name</th>
            <th v-for="item in tableHeaders" :key="item">{{ item }}</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in payrolls" :key="index">
            <td>{{ item.employeeName }}</td>
            <td>{{ item.basic_salary }}</td>
            <td>{{ item.additionals }}</td>
            <td>{{ item.deductions }}</td>
            <td>{{ item.government_contributions }}</td>
            <td>{{ item.professional_tax }}</td>
            <td>{{ item.loans }}</td>
            <td>{{ item.totalNetPay }}</td>
            <td>{{ item.start_date }}</td>
            <td>{{ item.end_date }}</td>
            <td>
              <button @click="editPayroll(item, index)" class="btn btn-success">Edit</button>
              <button @click="deletePayroll(index)" class="btn btn-danger">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
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
      employees: [],
      payrolls: [],
      isFormVisible: false,
      payrollInputs: {
        'Basic Salary': { type: 'number', model: 'basic_salary', class: 'form-control' },
        'Additionals': { type: 'number', model: 'additionals', class: 'form-control' },
        'Deductions': { type: 'number', model: 'deductions', class: 'form-control' },
        'Loans': { type: 'number', model: 'loans', class: 'form-control' }
      },
      dateInputs: {
        'Start Date': { type: 'date', model: 'start_date', class: 'form-control' },
        'End Date': { type: 'date', model: 'end_date', class: 'form-control' }
      },
      tableHeaders: ['Basic Salary', 'Additionals', 'Deductions', 'Government Contributions', 'Professional Tax', 'Loans', 'Total Net Pay', 'Start Date', 'End Date']
    };
  },
  computed: {
    calculateGovernmentContributions() {
      const sss = this.payroll.basic_salary * 0.0363;
      const pagibig = 100;
      const philhealth = this.payroll.basic_salary * 0.03;
      return sss + pagibig + philhealth;
    },
    calculateProfessionalTax() {
      const annualSalary = this.payroll.basic_salary * 12;
      let tax = 0;
      if (annualSalary <= 250000) tax = 0;
      else if (annualSalary <= 400000) tax = (annualSalary - 250000) * 0.20 / 12;
      else if (annualSalary <= 800000) tax = (30000 + (annualSalary - 400000) * 0.25) / 12;
      else if (annualSalary <= 2000000) tax = (130000 + (annualSalary - 800000) * 0.30) / 12;
      else if (annualSalary <= 8000000) tax = (490000 + (annualSalary - 2000000) * 0.32) / 12;
      else tax = (2410000 + (annualSalary - 8000000) * 0.35) / 12;
      return parseFloat(tax.toFixed(2)); // Round to two decimal places and convert back to number
    }
  },
  mounted() {
    this.fetchEmployees();
    this.loadPayrolls();
  },
  methods: {
    toggleFormVisibility() {
      this.isFormVisible = !this.isFormVisible;
    },
    fetchEmployees() {
      axios.get('http://localhost:8000/api/employees')
        .then(response => {
          this.employees = response.data.employees;
        })
        .catch(error => {
          console.error('Error fetching employees:', error);
        });
    },
    submitPayroll() {
      this.payroll.government_contributions = this.calculateGovernmentContributions;
      this.payroll.professional_tax = this.calculateProfessionalTax;
      const totalNetPay = this.payroll.basic_salary + this.payroll.additionals - this.payroll.deductions - this.payroll.deductions - this.payroll.government_contributions - this.payroll.professional_tax - this.payroll.loans;
      axios.post('http://localhost:8000/api/payrolls', this.payroll)
        .then(response => {
          const newPayroll = {
            ...this.payroll,
            employeeName: this.employees.find(emp => emp.id === this.payroll.employee_id).lastname + ' ' + this.employees.find(emp => emp.id === this.payroll.employee_id).firstname,
            totalNetPay: totalNetPay
          };
          this.payrolls.push(newPayroll);
          localStorage.setItem('payrolls', JSON.stringify(this.payrolls));
          alert('Payroll generated successfully!');
          this.toggleFormVisibility();
        })
        .catch(error => {
          console.error('Error submitting payroll:', error);
          alert('Failed to generate payslip.');
        });
    },
    loadPayrolls() {
      const savedPayrolls = localStorage.getItem('payrolls');
      if (savedPayrolls) {
        this.payrolls = JSON.parse(savedPayrolls);
      }
    },
    editPayroll(payroll, index) {
      this.payroll = {...payroll};
      this.payroll.index = index; // Store index to know where to replace in the array
      this.toggleFormVisibility();
    },
    deletePayroll(index) {
      if (confirm('Are you sure you want to delete this payroll?')) {
        this.payrolls.splice(index, 1);
        localStorage.setItem('payrolls', JSON.stringify(this.payrolls));
        alert('Payroll deleted successfully!');
      }
    }
  }
}
</script>
