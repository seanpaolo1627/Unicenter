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
					<label for="">Employee No.</label>
					<input type="text" v-model="model.employee.emp_num" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">Last Name</label>
					<input type="text" v-model="model.employee.lastname" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">First Name</label>
					<input type="text" v-model="model.employee.firstname" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">Middle Name</label>
					<input type="text" v-model="model.employee.middlename" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">Building / Street</label>
					<input type="text" v-model="model.employee.address_line" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">Barangay</label>
					<input type="text" v-model="model.employee.brgy" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">City</label>
					<input type="text" v-model="model.employee.city" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">Province</label>
					<input type="text" v-model="model.employee.province" class="form-control">
				</div>
				<div class ="mb-3">
					<label for="">ZIP Code</label>
					<input type="text" v-model="model.employee.zipcode" class="form-control">
				</div>
				<div class ="mb-3">
					<button type="button" @click="updateEmployee" class="btn btn-primary">Done</button>
					<RouterLink to="/employee" class="btn btn-primary float-end">Back</RouterLink>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	import axios from 'axios'

	export default{
		name: 'employeeEdit',
		data(){
			return{
				employeeId: '',
				errorList: '',
				model: {
					employee: {
						emp_num: '',
						firstname: '',
						middlename: '',
						lastname: '',
						address_line: '',
						brgy: '',
						city: '',
						province: '',
						zipcode: ''
					}
				}
			}
		},
		mounted(){

			//console.log(this.$route.params.id);
			this.employeeId = this.$route.params.id;
			this.getEmployeeData(this.$route.params.id);

		},
		methods: {

			getEmployeeData(employeeId){

				axios.get(`http://localhost:8000/api/employees/${employeeId}/edit`).then(res => {
					console.log(res.data.employee);

					this.model.employee = res.data.employee
				})
				.catch(function (error) {

					if(error.response){

						if (error.response.status == 404){

							alert(error.response.data.message);

						}	
					}

				});

			},

			updateEmployee(){

				var mythis = this;
				axios.put(`http://localhost:8000/api/employees/${this.employeeId}/edit`, this.model.employee)
				.then(res => {
					console.log(res.data)
					alert(res.data.message);

					this.errorList = '';

					this.$router.push('/employee');
				})
				.catch(function (error) {

					if(error.response){

						if (error.response.status == 404){

							alert(error.response.data.message);

						}if (error.response.status == 422){

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