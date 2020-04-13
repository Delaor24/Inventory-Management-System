<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Add Employee</h4>
                            </div>
                            <div>
                                <router-link :to="{name:'productIndex'}" class="btn btn-success">All Products</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="productAdd">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name <span class="text-danger">*</span></label>
                                        <input v-model="form.p_name" type="text" class="form-control" placeholder="Product Name">
                                        <small class="text-danger" v-if="errors.p_name">{{errors.p_name[0]}}</small>
                                    </div>
                                </div>

                              <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Code</label>
                                        <input v-model="form.p_code" type="text" class="form-control" placeholder="Product Code">
                                        <small class="text-danger" v-if="errors.p_code">{{errors.p_code[0]}}</small>
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select v-model="form.category_id" class="form-control">
                                            <option value="">--select category--</option>

                                            <option v-for="category in categories" :value="category.id">{{category.name}}</option>

                                        </select>
                                         <small class="text-danger" v-if="errors.category_id">{{errors.category_id[0]}}</small>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <select v-model="form.supplier_id" class="form-control">
                                            <option value="">--select supplier--</option>
                                             <option v-for="supplier in suppliers" :value="supplier.id">{{supplier.name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Selling Price <span class="text-danger">*</span></label>
                                        <input v-model="form.selling_price" type="number" class="form-control" placeholder="Selling Price">
                                        <small class="text-danger" v-if="errors.selling_price">{{errors.selling_price[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Buying Price</label>
                                        <input v-model="form.buying_price" type="number" class="form-control" placeholder="Buying Price">
                                        <small class="text-danger" v-if="errors.buying_price">{{errors.buying_price[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Quantity <span class="text-danger">*</span></label>
                                        <input v-model="form.p_quantity" type="number" class="form-control" placeholder="Product Quantity">
                                        <small class="text-danger" v-if="errors.p_quantity">{{errors.p_quantity[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Buying Date</label>
                                        <input v-model="form.buying_date" type="date" class="form-control" placeholder="MM/DD/YYYY">
                                        <small class="text-danger" v-if="errors.buying_date">{{errors.buying_date[0]}}</small>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product Location</label>
                                        <textarea v-model="form.root" cols="10" rows="3" type="text" class="form-control" placeholder="Root"></textarea>
                                        <small class="text-danger" v-if="errors.root">{{errors.root[0]}}</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Product Image</label>
                                        <input type="file" class="form-control" @change="onSelectFile">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <img :src="form.image" id="imgHide" style="width:80px;height:100px;display:none" class="image-fluid mb-1">
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fas fa-plus"></i> Add Product</button>
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
        data(){
            return {
                form:{
                    p_name:'',
                    p_code:'',
                    category_id:'',
                    supplier_id:'',
                    buying_price:'',
                    selling_price:'',
                    image:'',
                    buying_date:'',
                    p_quantity:'',
                    root:'',

                },
                errors:{},
                categories:{},
                suppliers:{},
            }
        },
        created(){
            axios.get('api/categories')
            .then(res=>{this.categories = res.data})

            axios.get('api/suppliers')
            .then(res=>{this.suppliers = res.data})
        },
        methods:{
            productAdd(){
                axios.post('api/products',this.form)
                .then(res=>{
                    Notification.success();
                    this.$router.push({name:'productIndex'})
                })
                .catch(error=>{
                    this.errors = error.response.data.errors;
                    console.log(error.response.data.errors)
                })
            },
            onSelectFile(e){
                let file = e.target.files[0];
                if(file.size > 2091540){
                    Notification.imageValidation();
                }else{
                    let reader = new FileReader();
                    reader.onload = e=>{
                        $("#imgHide").show()
                        this.form.image = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            }

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
