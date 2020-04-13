<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Add Supplier</h4>
                            </div>
                            <div>
                                <router-link :to="{name:'categoryIndex'}" class="btn btn-success">All Categories</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="categoryAdd">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Category Name <span class="text-danger">*</span></label>
                                        <input v-model="form.name" type="text" class="form-control" placeholder="Category Name">
                                        <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fas fa-plus"></i> Add Category</button>
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
                },
                errors: {},
            }
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
            categoryAdd(){
                axios.post('api/categories',this.form)
                    .then(res=>{
                        Notification.success();
                        this.$router.push({name:'categoryIndex'})
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
