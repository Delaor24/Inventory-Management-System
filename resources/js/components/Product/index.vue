<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>All Products</h4>
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
                                    <th>Quantity</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Selling Price</th>
                                    <th>Buying Date</th>
                                    <th>Root</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                <tr v-for="product in searchProduct" :key="product.id">

                                    <td><img :src="product.image" alt="image" style="width:60px;height:50px"></td>
                                    <td>{{product.p_name}}</td>
                                    <td>{{product.p_quantity}}</td>
                                    <td>{{product.category.name}}</td>
                                    <td v-if="product.supplier != null">{{product.supplier.name}}</td>
                                    <td v-else=""></td>
                                    <td>{{product.selling_price}} Tk</td>
                                    <td>{{product.buying_date}}</td>
                                    <td>{{product.root}}</td>


                                    <td colspan="1">
                                        <router-link :to="{name:'productEdit',params:{id:product.id}}" class="btn-sm btn-info"><i class="fas fa-edit"></i></router-link>
                                    </td>
                                    <td colspan="1">
                                        <a @click="productDel(product.id)" class="btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
                products:[],
                searchFillter:'',
            }
        },
        methods:{
            allProduct(){
                axios.get('api/products')
                    .then(res=>{
                        this.products = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            productDel(id){
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
                        axios.delete('api/products/'+id)
                            .then(()=>{
                                Notification.error();
                                this.products = this.products.filter(product=>{
                                    return product.id != id;
                                })
                            }).catch(()=>{
                            this.$router.push({name:'productIndex'})
                        })
                        }

                })
            }
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
