<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Update Supplier</h4>
                            </div>
                            <div>
                                <router-link :to="{name:'supIndex'}" class="btn btn-success">All Suppliers</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="supEdit" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input v-model="form.name" type="text" class="form-control" placeholder="Full Name">
                                        <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shop Name</label>
                                        <input v-model="form.shopName" type="text" class="form-control" placeholder="Shop Name">
                                        <small class="text-danger" v-if="errors.shopName">{{errors.shopName[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input v-model="form.phone" type="number" min="0" class="form-control" placeholder="Phone Number">
                                        <small class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input v-model="form.email" type="email" class="form-control" placeholder="Email">
                                        <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <textarea v-model="form.address" cols="10" rows="3" type="email" class="form-control" placeholder="Address"></textarea>
                                        <small class="text-danger" v-if="errors.address">{{errors.address[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control" @change="onSelectFile">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <img :src="form.image" id="imgHide" style="width:80px;height:100px; display:none" class="image-fluid mb-1">
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fas fa-plus"></i> Add Supplier</button>
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
                    name:'',
                    phone:'',
                    email:'',
                    newImage:'',
                    shopName:'',
                    address:'',
                },
                errors:{},
            }
        },
        created() {
            let id = this.$route.params.id;
            axios.get('api/suppliers/'+id)
                .then(res=>{
                    this.form = res.data;
                })
                .catch(error=>{})
        },
        methods:{
            supEdit(){
                let id = this.$route.params.id;
                axios.patch('api/suppliers/'+id,this.form)
                    .then(res=>{
                        Notification.success();
                        this.$router.push({name:'supIndex'})
                    })
                    .catch(error=>{
                        this.errors = error.response.data.errors;
                        console.log(error.response.data.errors)
                    })
            },
            onSelectFile(e){
                let file = e.target.files[0];
                if(file.size > 1048770){
                    Notification.imageValidation();
                }else{
                    let reader = new FileReader();
                    reader.onload = e=>{
                        $("#imgHide").show()
                        this.form.newImage = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
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
    }
</script>

<style scoped>

</style>
