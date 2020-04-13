<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>All Prosucts</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchFillter" @keyup="searchProduct">
                            </div>
                            <div>
                                <router-link :to="{name:'productCreate'}" class="btn btn-success">Add Product</router-link>
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
            
                                    <th>Photo</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Quantity</th>
                                    <th>Category</th>
                                    <th>Buying Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="product in searchProduct" :key="product.id">
                                
                                    <td><img :src="product.image" alt="image" style="width:60px;height:50px"></td>
                                    <td>{{product.p_name}}</td>
                                    <td>{{product.p_code}}</td>
                                    <td>{{product.p_quantity}}</td>
                                    <td>{{product.category.name}}</td>
                                    <td>{{product.buying_price}} Tk</td>
                                    <td>
                                        <div v-if="product.p_quantity > 0" class="badge badge-success">Available</div>
                                        <div v-else="" class="badge badge-danger">Stock Out</div>
                                    </td>
                                
                                   
                                    <td>
                                        <router-link :to="{name:'productEdit',params:{id:product.id}}" class="btn-sm btn-info"><i class="fas fa-edit"></i></router-link>
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
        name: "stock",
        data(){
            return {
                products:[],
                searchFillter:'',
            }
        },
        methods:{
            allProduct(){
                axios.get('api/products')
                    .then(res=>{
                        this.products = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
          
        },
        created() {
            this.allProduct();
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
            searchProduct(){
                return this.products.filter(product=>{
                    return product.p_name.match(this.searchFillter);
                })
            }
        }
    }
</script>

<style scoped>

</style>
