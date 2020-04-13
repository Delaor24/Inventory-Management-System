<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>Today Orders</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control mr-50" placeholder="Search" v-model="searchCustomerName" @keyup="orderSerch">
                            </div>
                        </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>Customer Name</th>
                                    <th>Total Quantity</th>
                                    <th>Total Price</th>
                                    <th>Pay</th>
                                    <th>Due</th>
                                    <th>Pay By</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="order in orderSerch" :key="order.id">
                                    <td>{{order.name}}</td>
                                    <td>{{order.cart_quantity}}</td>
                                    <td>{{order.total}}</td>
                                    <td>{{order.pay}}</td>
                                    <td>{{order.due}}</td>
                                    <td>{{order.payby}}</td>
                                    <td>
                                        <router-link :to="{name:'orderDetails',params:{id:order.id}}" class="btn-sm btn-info">Order Details</router-link>
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
        name: "todayOrder",
        data(){
            return {
                orders:[],
                searchCustomerName:'',
            }
        },
        methods:{
            todayOrders(){
                axios.get('api/today-orders')
                    .then(res=>{
                        this.orders = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
        },
        created() {
            this.todayOrders();
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
            orderSerch(){
                return this.orders.filter(order=>{
                    return order.name.match(this.searchCustomerName);
                })
            }
        }
    }
</script>

<style scoped>

</style>
