<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-group">
                                    <a class="list-group-item list-group-item-action active">
                                        Customer Info
                                    </a>
                                    <a  class="list-group-item list-group-item-action"><strong>Name:</strong> {{orders.name}}</a>
                                    <a  class="list-group-item list-group-item-action" v-if="orders.image"><img :src="orders.image" width="80px" height="70px"></a>
                                    <a  class="list-group-item list-group-item-action"><strong>Phone:</strong> {{orders.phone}}</a>
                                    <a  class="list-group-item list-group-item-action" v-if="orders.email"><strong>Email:</strong> {{orders.email}}</a>
                                    <a class="list-group-item list-group-item-action"><strong>Address:</strong> {{orders.address}}</a>
                                    <a  class="list-group-item list-group-item-action"><strong>Date:</strong> {{orders.order_date}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-group">
                                    <a class="list-group-item list-group-item-action active">
                                        Order Info
                                    </a>
                                    <a  class="list-group-item list-group-item-action"><strong>Product Quantity:</strong> {{orders.cart_quantity}}</a>
                                    <a  class="list-group-item list-group-item-action"><strong>Sub Total:</strong> {{orders.sub_total}} Tk</a>
                                    <a  class="list-group-item list-group-item-action"><strong>Vat:</strong> 5%</a>
                                    <a class="list-group-item list-group-item-action"><strong>Total:</strong> {{orders.total}} Tk</a>
                                    <a  class="list-group-item list-group-item-action"><strong>Pay:</strong> {{orders.pay}} Tk</a>
                                    <a  class="list-group-item list-group-item-action"><strong>Due: </strong>{{orders.due}} Tk</a>
                                    <a  class="list-group-item list-group-item-action"><strong>Payby: </strong>{{orders.payby}} Tk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>Product Details</h4>
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>Photo</th>
                                    <th>Product Name</th>
                                    <th>Code</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                                <tr v-for="product in details" :key="product.id">
                                    <td><img :src="product.image" alt="image" style="width:60px;height:50px"></td>
                                    <td>{{product.p_name}}</td>
                                    <td>{{product.p_code}}</td>
                                    <td>{{product.product_quantity}}</td>
                                    <td>{{product.product_price}} Tk</td>
                                    <td>{{product.sub_total}}</td>
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
        name: "orderDetails",
        data(){
            return {
                orders:[],
                details:[],
                searchFillter:'',
            }
        },
        methods:{
            orderInfo(){
                let id = this.$route.params.id;
                axios.get('api/order-info/'+id)
                    .then(res=>{
                        this.orders = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            orderDetails(){
                let id = this.$route.params.id;
                axios.get('api/order-details/'+id)
                    .then(res=>{
                        this.details = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
        },
        created() {
            this.orderInfo();
            this.orderDetails();
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
