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
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchData" @keyup="searchFillter">
                            </div>
                        
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Salary</th>
                                    <th>Date</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="salary in searchFillter" :key="salary.id">
                                    <td>{{salary.employee.name}}</td>
                                    <td>{{salary.amount}}</td>
                                    <td>{{salary.salary_date}}</td>
                                    <td>{{salary.salary_month}}</td>
                                    <td>{{salary.salary_year}}</td>
                                    <td>
                                        <router-link :to="{name:'salaryEdit',params:{id:salary.id}}" class="btn-sm btn-info"><i class="fas fa-edit"></i></router-link>
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
        name: "index",
        data(){
            return {
                salaries:[],
                searchData:'',
            }
        },
        methods:{
            allsalaries(){
               let month = this.$route.params.month;
                axios.get('api/salaries/'+month)
                    .then(res=>{
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
        computed:{
            searchFillter(){
                return this.salaries.filter(salary=>{
                    return salary.salary_date.match(this.searchData);

                })
            }
        }
    }
</script>

<style scoped>

</style>
