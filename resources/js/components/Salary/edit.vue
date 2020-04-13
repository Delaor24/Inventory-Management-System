<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Update Salary</h4>
                            </div>
                        
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="salaryEdit">
                            <div class="row">
                            
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount <span class="text-danger">*</span></label>
                                        <input v-model="form.amount" type="number" class="form-control" placeholder="Amount">
                                        <small class="text-danger" v-if="errors.amount">{{errors.amount[0]}}</small>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Month <span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.salary_month">
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
                                        <small class="text-danger" v-if="errors.salary_month">{{errors.salary_month[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fas fa-edit"></i> Update Salary</button>
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
        name: "edit",
        data(){
            return {
                form:{
                    amount:'',
                    salary_month:'',

                },  
                errors:{},
            }
        },
        created() {
            let id = this.$route.params.id;
            axios.get('api/salary/edit/'+id)
                .then(res=>{
                    this.form = res.data;
                })
                .catch(error=>{})
        },
        methods:{
            salaryEdit(){
                let id = this.$route.params.id;
                axios.patch('api/salary/update/'+id,this.form)
                    .then(res=>{
                    console.log(res.data.success);
                       Toast.fire({
                            icon: 'success',
                            title: 'Salary Updated!',
                        })
                    
                        this.$router.push({name:'all_salary'})
                        
                    })
                    .catch(error=>{
                        this.errors = error.response.data.errors;
                        console.log(error.response.data.errors)
                    })
            },
           
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
    }
</script>

<style scoped>

</style>
