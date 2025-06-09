<template>
	<div class="container mt-4">
		<div class="card mb-5">
			<div class="card-header">
				<h4>New Assignment</h4>
			</div>
			<div class="card-body">
				<ul class="alert alert-warning" v-if="Object.keys(errorList).length > 0">
					<li class="mb-0 ms-3" v-for="(error, index) in errorList" :key="index">
						{{ error[0] }}  
					</li>
				</ul>

				<div class="mb-3">
					<label for="emp_num">Employee No.</label>
					<select v-model="model.emp_num" class="form-select">
						<option value="" disabled></option>
						<option v-for="employee in employees" :key="employee.emp_num" :value="employee.emp_num">{{ employee.emp_num }}</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="designation_id">Designation</label>
					<select v-model="model.designation_id" @change="updateDepartment" class="form-select">
						<option value="" disabled></option>
						<option v-for="designation in designations" :key="designation.id" :value="designation.id">{{ designation.id }}</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="department_id">Department</label>
					<input type="text" v-model="selectedDepartment" class="form-control" readonly>
				</div>
				<div class="mb-3">
					<label for="employee_type">Employee Type</label>
					<select v-model="model.employee_type" class="form-select">
						<option value="" disabled></option>
						<option value="REGULAR">REGULAR</option>
						<option value="PROJECT">PROJECT</option>
						<option value="SEASONAL">SEASONAL</option>
						<option value="FIXED-TERM">FIXED-TERM</option>
						<option value="CASUAL">CASUAL</option>
						<option value="PROBATIONARY">PROBATIONARY</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="probationary">Probationary Period (in days)</label>
					<input type="text" v-model="model.probationary" class="form-control">
				</div>
				<div class="mb-3">
					<label for="daily_role">Daily Role</label>
					<input type="text" v-model="model.daily_role" class="form-control">
				</div>
				<div class="mb-3">
					<label for="status">Status</label>
					<select v-model="model.status" class="form-select">
						<option value="" disabled></option>
						<option value="ACTIVE">ACTIVE</option>
						<option value="RESIGNED">RESIGNED</option>
						<option value="AWOL">AWOL</option>
					</select>
				</div>
				<div class="mb-3">
					<button type="button" @click="saveAssignment" class="btn btn-primary">Add</button>
					<RouterLink to="/assign" class="btn btn-primary float-end">Back</RouterLink>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import axios from 'axios';
	import { ref, onMounted } from 'vue'
	
	export default {
		name: 'AssignCreate',
		data() {
			return {
				errorList: {},
				model: {
					emp_num: '',
					designation_id: '',
					employee_type: '',
					probationary: '',
					daily_role: '',
					status: ''
				},
				employees: [],
				designations: [],
				departments: [],
				selectedDepartment: ''
			};
		},
		mounted() {
			this.getEmployees();
			this.getDesignations();

		},
		methods: {
			getEmployees() {
				axios.get('http://localhost:8000/api/employees')
				.then(res => {
					this.employees = res.data.employees;
				})
				.catch(error => {
					console.error('Error fetching employees:', error);
				});
			},
			getDesignations() {
				axios.get('http://localhost:8000/api/designation')
				.then(res => {
					console.log(res.data.designations);
					this.designations = res.data.designations;
				})
				.catch(error => {
					console.error('Error fetching designations:', error);
				});
			},
			updateDepartment() {
				console.log('Updating department...');
				console.log('Designation ID:', this.model.designation_id);
				console.log('Designations:', [...this.designations]);
				const designationId = this.model.designation_id;
				const designation = this.designations.find(designation => designation.id === designationId);
				console.log('Found Designation:', designation);
				if (designation) {
					const departmentId = designation.department_id;
					axios.get(`http://localhost:8000/api/departments/${departmentId}`)
					.then(response => {
						const department = response.data.department;
						console.log('Department:', department); // Log the department
						if (department) {
							this.selectedDepartment = department.dept_name;
							console.log('Selected Department:', this.selectedDepartment);
						}
					})
					.catch(error => {
						console.error('Error fetching department:', error);
					});
				}
			},
			saveAssignment() {
				const mythis = this;
				axios.post('http://localhost:8000/api/assign_designations', this.model)
				.then(res => {
					console.log(res.data);
					alert(res.data.message);

					this.model = {
						emp_num: '',
						designation_id: '',
						employee_type: '',
						probationary: '',
						daily_role: '',
						status: ''
					};
					this.errorList = {};

					this.$router.push('/assign');
				})
				.catch(function (error) {
					if (error.response) {
						if (error.response.status === 422) {
							mythis.errorList = error.response.data.errors;
						} else if (error.request) {
							console.log(error.request);
						} else {
							console.log('Error', error.message);
						}
					}
				});
			}
		}
	};
</script>