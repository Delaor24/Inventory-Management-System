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
                            <div>
                                <router-link :to="{name:'salaryEmp'}" class="btn btn-success">Pay Salary</router-link>
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
                                        <a @click="salaryDel(salary.id)" class="btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
        name: "all_salary",
        data(){
            return {
                salaries:[],
                searchData:'',
            }
        },
        methods:{
            allsalaries(){
               let month = this.$route.params.month;
                axios.get('api/all-salary')
                    .then(res=>{
                        this.salaries = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
            salaryDel(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('api/salary/delete/'+id)
                            .then(()=>{
                                Notification.error();
                                this.salaries = this.salaries.filter(salary=>{
                                    return salary.id != id;
                                })
                            }).catch(()=>{
                            this.$router.push({name:'salaryIndex'})
                        })
                    }

                })
            }
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
