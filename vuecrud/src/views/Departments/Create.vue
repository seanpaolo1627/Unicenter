<template>
	<div class="container mt-5">	
		<div class ="card mb-5">
			<div class ="card-header">
				<h4>New Department</h4>
			</div>
			<div class = "card-body">

				<ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
					<li class ="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
						{{ error[0] }}	
					</li>
				</ul>

				<div class ="mb-3">
					<label for="">Name</label>
					<input type="text" v-model="model.department.dept_name" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">Status</label>
					<select v-model="model.department.status" class="form-control">
						<option value="ACTIVE">ACTIVE</option>
						<option value="INACTIVE">INACTIVE</option>
					</select>
				</div>
				<div class ="mb-3">
					<button type="button" @click="saveDepartment" class="btn btn-primary">Add</button>
					<RouterLink to="/departments" class="btn btn-primary float-end">Back</RouterLink>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import axios from 'axios'
	export default{
		name: 'departmentCreate',
		data(){
			return{
				errorList: '',
				model: {
					department: {
						dept_name: '',
						status: ''
					}
				}
			}
		},
		methods: {
			saveDepartment(){

				var mythis = this;
				axios.post('http://localhost:8000/api/departments', this.model.department)
				.then(res => {
					console.log(res.data)
					alert(res.data.message);

					this.model.department = {
						dept_name: '',
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