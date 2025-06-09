<template>
	<div class="container mt-5">	
		<div class ="card mb-5">
			<div class ="card-header">
				<h4>Edit</h4>
			</div>
			<div class = "card-body">

				<ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
					<li class ="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
						{{ error[0] }}	
					</li>
				</ul>

				<div class ="mb-3">
					<label for="">Name</label>
					<input type="text" v-model="model.designation.designation_name" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">Department ID</label>
					<select v-model="model.designation.department_id" class="form-control">
						<option v-for="department in departments" :value="department.id" :key="department.id">{{ department.id }}</option>
					</select>
				</div>
				<div class ="mb-3">
					<label for="">Status</label>
					<select v-model="model.designation.status" class="form-control">
						<option value="ACTIVE">Active</option>
						<option value="INACTIVE">Inactive</option>
					</select>
				</div>
				<div class ="mb-3">
					<button type="button" @click="updateDesignation" class="btn btn-primary">Done</button>
					<RouterLink to="/departments" class="btn btn-primary float-end">Back</RouterLink>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import axios from 'axios'
	export default{
		name: 'designationEdit',
		data(){
			return{
				designationId: '',
				errorList: '',
				model: {
					designation: {
						designation_name: '',
						department_id: '',
						status: ''
					}
				},
				departments: []
			}
		},
		mounted() {
			this.designationId = this.$route.params.id;
			this.getDesignationData();
			this.getDepartments();
		},
		methods: {
			getDesignationData() {
				axios.get(`http://localhost:8000/api/designation/${this.designationId}/edit`)
				.then(res => {
					this.model.designation = res.data.designation;
				})
				.catch(error => {
					console.error('Error fetching designation data:', error);
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
			updateDesignation() {
				axios.put(`http://localhost:8000/api/designation/${this.designationId}/edit`, this.model.designation)
				.then(res => {
					alert(res.data.message);
					this.errorList = '';
					this.$router.push('/departments');
				})
				.catch(error => {
					if (error.response && error.response.status === 422) {
						this.errorList = error.response.data.errors;
					} else {
						console.error('Error updating designation:', error);
					}
				});
			}
		},
	}
</script>