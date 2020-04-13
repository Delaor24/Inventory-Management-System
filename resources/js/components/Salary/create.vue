<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Pay Salary</h4>
                            </div>
                          
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="salaryAdd">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employee Name <span class="text-danger">*</span></label>
                                        <input v-model="form.name" type="text" class="form-control" placeholder="Employee Name">
                                        <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                    </div>
                                </div>

                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input v-model="form.email" type="email" class="form-control" placeholder="Email">
                                        <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Month <span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.month">
                                          <option value="">--select month--</option>

                                          <option value="January">January</option>
                                          <option value="February">February</option>
                                          <option value="March">March</option>
                                          <option value="April">April</option>
                                          <option value="May">May</option>
                                          <option value="June">June</option>
                                          <option value="July">July</option>
                                          <option value="August">August</option>
                                          <option value="September">September</option>
                                          <option value="October">October</option>
                                          <option value="November">November</option>
                                          <option value="December">December</option>

                                        </select>
                                        <small class="text-danger" v-if="errors.month">{{errors.month[0]}}</small>
                                    </div>
                                </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Salary <span class="text-danger">*</span></label>
                                        <input v-model="form.salary" type="number" class="form-control" placeholder="Salary">
                                        <small class="text-danger" v-if="errors.salary">{{errors.salary[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fas fa-plus"></i> Pay Salary</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "create",
        data() {
            return {
                form: {
                    name: '',
                    salary: '',
                    month:'',
                    email:'',
                },
                errors: {},
            }
        },
        created(){

         let id = this.$route.params.id;
         axios.get('api/employees/'+id)
            .then(res=>{this.form = res.data})
            },
        mounted() {
        if(!User.loggedIn()){
            Toast.fire({
                icon: 'warning',
                title: 'Login First!',
            });
            this.$router.push({name:'login'})
        }
    },
        methods:{
            salaryAdd(){
                let id = this.$route.params.id;
                axios.post('api/salary-pay/'+id,this.form)
                    .then(res=>{
                   
                        if(res.data.error){
                           Toast.fire({
                            icon: 'warning',
                            title: 'Salary Already Paid For This month!',
                        })
                        }else{
                        Notification.success();
                        this.$router.push({name:'salaryEmp'})
                        }
                        
                    })
                    .catch(error=>{
                        this.errors = error.response.data.errors;
                        console.log(error.response.data.errors)
                    })
            },
    
        }
    }
</script>

<style scoped>

</style>
