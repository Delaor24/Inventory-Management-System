<template>
    <div>
        <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card" style="background-color:#b9ede8">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Income</h5>
                                        <h2 class="mb-3 font-18">{{this.dayIncome}}</h2>
                                        <p class="mb-0"><span class="col-green">10%</span> Increase</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card" style="background-color:#a5e8a2">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Sell</h5>
                                        <h2 class="mb-3 font-18">{{this.daySell}}</h2>
                                        <p class="mb-0"><span class="col-orange">09%</span> Decrease</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card" style="background-color:#9e8b3f">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Due</h5>
                                        <h2 class="mb-3 font-18">{{this.dayDue}}</h2>
                                        <p class="mb-0"><span class="col-green">18%</span>
                                            Increase</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card" style="background-color:#83bceb">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Expense</h5>
                                        <h2 class="mb-3 font-18">{{this.dayExpense}}</h2>
                                        <p class="mb-0"><span class="col-green">18%</span>
                                            Increase</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>Stock Out Products</h4>
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
                                <tr v-for="product in products" :key="product.id" v-if="product.p_quantity < 1">

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
        name: "Home",
        data(){
            return {
                products:[],
                dayIncome:'',
                daySell:'',
                dayDue:'',
                dayExpense:'',

            }
        },
        methods:{
            allProduct(){
                axios.get('api/products')
                    .then(res=>{
                        this.products = res.data;
                    }).catch(error=>{console.log(error.response.data)});
            },
            todayIncome(){
                axios.get('api/today-income')
                .then(res=>{
                    this.dayIncome = res.data;
                })
            },
            todaySell(){
                axios.get('api/today-sell')
                    .then(res=>{
                        this.daySell = res.data;
                    })
            },
            todayDue(){
                axios.get('api/today-due')
                    .then(res=>{
                        this.dayDue = res.data;
                    })
            },
            todayExpense(){
                axios.get('api/today-expense')
                    .then(res=>{
                        this.dayExpense = res.data;
                    })
            }

        },
        created() {
            if(!User.loggedIn()){
                Toast.fire({
                    icon: 'warning',
                    title: 'Login First!',
                });
                this.$router.push({name:'login'})
            }
            this.allProduct();
            this.todayDue();
            this.todayIncome();
            this.todaySell();
            this.todayExpense();
        },
    }
</script>

<style scoped>

</style>
