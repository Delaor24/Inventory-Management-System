<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>Salary List</h4>
                            </div>
                            
                        
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody>
                                <tr>
                                    <th>Month</th>
                                    <th>Details</th>   
                                </tr>
                                <tr v-for="salary in salaries" :key="salary.id">
                                    <td>{{salary.salary_month}}</td>
                                    <td>
                                        <router-link :to="{name:'salaryIndex',params:{month:salary.salary_month}}" class="btn-sm btn-info">View Salary</router-link>
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "salary_month",
        data(){
            return {
                salaries:[],
            }
        },
        methods:{
            allsalaries(){
                axios.get('api/salary/months')
                    .then(res=>{
                    console.log(res.data.success)
                        this.salaries = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
        
        },
        created() {
            this.allsalaries();
        }
        ,
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
