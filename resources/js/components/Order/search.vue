<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="orderDate">
                                    <label>Search For Date</label>
                                    <input type="date" class="form-control" v-model="form.date">
                                    <button class="btn btn-success mt-2" type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="orderMonth">
                                    <label>Search For Month</label>
                                    <select v-model="form.month" class="form-control" id="">
                                        <option value="">--select month--</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                    <button class="btn btn-success mt-2" type="submit">Submit</button>
                                </form>
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
                                    <th>Customer Name</th>
                                    <th>Total Quantity</th>
                                    <th>Total Price</th>
                                    <th>Pay</th>
                                    <th>Due</th>
                                    <th>Pay By</th>
                                    <th>Date</th>
                                    <th>Month</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="order in orders" :key="order.id">
                                    <td>{{order.name}}</td>
                                    <td>{{order.cart_quantity}}</td>
                                    <td>{{order.total}}</td>
                                    <td>{{order.pay}}</td>
                                    <td>{{order.due}}</td>
                                    <td>{{order.payby}}</td>
                                    <td>{{order.order_date}}</td>
                                    <td>{{order.order_month}}</td>
                                    <td>
                                        <router-link :to="{name:'orderDetails',params:{id:order.id}}" class="btn-sm btn-info">View</router-link>
                                        <a @click="orderDel(order.id)" class="btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
        name: "orderDetails",
        data(){
            return {
                orders:[],
                details:[],
                form:{
                    date:'',
                    month:'',
                },
                searchFillter:'',
            }
        },
        methods:{
            orderMonth(){
                axios.post('api/order-search-month',this.form)
                    .then(res=>{
                        this.orders = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            orderDate(){
                axios.post('api/order-search-date',this.form)
                    .then(res=>{
                        this.orders = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
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
