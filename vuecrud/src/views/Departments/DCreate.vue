<template>
	<div class="container mt-5">	
		<div class ="card mb-5">
			<div class ="card-header">
				<h4>New Designation</h4>
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
						<option value="ACTIVE">ACTIVE</option>
						<option value="INACTIVE">INACTIVE</option>
					</select>
				</div>
				<div class ="mb-3">
					<button type="button" @click="saveDesignation" class="btn btn-primary">Add</button>
					<RouterLink to="/departments" class="btn btn-primary float-end">Back</RouterLink>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import axios from 'axios'
	export default{
		name: 'designationCreate',
		data(){
			return{
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
			this.getDepartments();
		},
		methods: {
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
				var mythis = this;
				axios.post('http://localhost:8000/api/designation', this.model.designation)
				.then(res => {
					console.log(res.data)
					alert(res.data.message);

					this.model.designation = {
						designation_name: '',
						department_id: '',
						status: ''
					}
					this.errorList = '';

					this.$router.push('/departments');
				})
				.catch(function (error) {
					if(error.response){
						if (error.response.status == 422){
							mythis.errorList = error.response.data.errors;
						} else if (error.request) {
							console.log(error.request);
						} else {
							console.log('Error', error.message);
						}
					}
				});
			}
		},
	}
</script>