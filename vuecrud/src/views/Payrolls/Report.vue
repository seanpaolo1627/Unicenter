<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Overall Payroll Report</div>
      <div class="card-body">
        <table class="table">
          <tbody>
            <tr>
              <th>Total Employees:</th>
              <td>{{ totalEmployees }}</td>
            </tr>
            <tr>
              <th>Total Basic Salary Paid:</th>
              <td>Php {{ totalBasicSalary.toFixed(2) }}</td>
            </tr>
            <tr>
              <th>Total Additionals:</th>
              <td>Php {{ totalAdditionals.toFixed(2) }}</td>
            </tr>
            <tr>
              <th>Total Deductions:</th>
              <td>Php {{ totalDeductions.toFixed(2) }}</td>
            </tr>            
            <tr>
              <th>Total Government Contributions:</th>
              <td>Php {{ totalGovernmentContributions.toFixed(2) }}</td>
            </tr>
            <tr>
              <th>Total Professional Tax:</th>
              <td>Php {{ totalProfessionalTax.toFixed(2) }}</td>
            </tr>
            <tr>
              <th>Total Loans:</th>
              <td>Php {{ totalLoans.toFixed(2) }}</td>
            </tr>
            <tr>
              <th>Overall Total:</th>
              <td>Php {{ overallTotal.toFixed(2) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      totalEmployees: 0,
      totalBasicSalary: 0,
      totalAdditionals: 0,
      totalDeductions: 0,
      totalGovernmentContributions: 0,
      totalProfessionalTax: 0,
      totalLoans: 0,
      overallTotal: 0
    };
  },
  mounted() {
    this.fetchPayrollData();
  },
  methods: {
    fetchPayrollData() {
      axios.get('http://localhost:8000/api/payrolls')
        .then(response => {
          const payrolls = response.data.payrolls;
          this.totalEmployees = payrolls.length;
          payrolls.forEach(payroll => {
            this.totalBasicSalary += parseFloat(payroll.basic_salary);
            this.totalAdditionals += parseFloat(payroll.additionals);
            this.totalDeductions += parseFloat(payroll.deductions);
            this.totalGovernmentContributions += parseFloat(payroll.government_contributions);
            this.totalProfessionalTax += parseFloat(payroll.professional_tax);
            this.totalLoans += parseFloat(payroll.loans);
          });
          this.calculateOverallTotal();
        })
        .catch(error => {
          console.error('Error fetching payroll data:', error);
        });
    },
    calculateOverallTotal() {
      this.overallTotal = this.totalBasicSalary + this.totalAdditionals - this.totalDeductions - this.totalGovernmentContributions - this.totalProfessionalTax - this.totalLoans;
    }
  }
}
</script>