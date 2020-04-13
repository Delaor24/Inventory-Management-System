<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>All Employees</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchEmpData" @keyup="searchEmp">
                            </div>
                            <div>
                                <router-link :to="{name:'empAdd'}" class="btn btn-success">Add Employee</router-link>
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th>Joining Date</th>
                                    <th>Status</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                <tr v-for="employee in searchEmp" :key="employee.id">
                                    <td>{{employee.id}}</td>
                                    <td><img :src="employee.image" alt="image" style="width:60px;height:50px"></td>
                                    <td>{{employee.name}}</td>
                                    <td>{{employee.phone}}</td>
                                    <td>{{employee.email}}</td>
                                    <td>{{employee.position}}</td>
                                    <td>{{employee.joiningDate}}</td>
                                    <td>
                                        <div v-if="employee.status == 1" class="badge badge-success">Active</div>
                                        <div v-else class="badge badge-danger">Inactive</div>
                                    </td>
                                    <td colspan="1">
                                        <router-link :to="{name:'empEdit',params:{id:employee.id}}" class="btn-sm btn-info"><i class="fas fa-edit"></i></router-link>
                                    </td>
                                    <td colspan="1">
                                        <a @click="empDel(employee.id)" class="btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
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
                employees:[],
                searchEmpData:'',
            }
        },
        methods:{
            allEmp(){
                axios.get('api/employees')
                    .then(res=>{
                        this.employees = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
            empDel(id){
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
                        axios.delete('api/employees/'+id)
                            .then(()=>{
                                Notification.error();
                                this.employees = this.employees.filter(emp=>{
                                    return emp.id != id;
                                })
                            }).catch(()=>{
                            this.$router.push({name:'empIndex'})
                        })
                        }

                })
            }
        },
        created() {
            this.allEmp();
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
            searchEmp(){
                return this.employees.filter(emp=>{
                    return emp.name.match(this.searchEmpData);
                })
            }
        }
    }
</script>

<style scoped>

</style>
