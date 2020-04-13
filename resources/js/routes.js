
// auth routes
let login = require('./components/Auth/Login.vue').default;
let register = require('./components/Auth/Register.vue').default;
let logout = require('./components/Auth/Logout.vue').default;
// dashboard routes
let home = require('./components/Home.vue').default;
// employee routes
let empCreate = require('./components/Employee/create.vue').default;
let empIndex = require('./components/Employee/index.vue').default;
let empEdit = require('./components/Employee/edit.vue').default;
// supplier routes
let supCreate = require('./components/Supplier/create.vue').default;
let supIndex = require('./components/Supplier/index.vue').default;
let supEdit = require('./components/Supplier/edit.vue').default;

// category routes
let categoryCreate = require('./components/Category/create.vue').default;
let categoryIndex = require('./components/Category/index.vue').default;
let categoryEdit = require('./components/Category/edit.vue').default;
// product routes
let productCreate = require('./components/Product/create.vue').default;
let productIndex = require('./components/Product/index.vue').default;
let productEdit = require('./components/Product/edit.vue').default;
let stock = require('./components/Product/stock.vue').default;
// expense routes
let expenseCreate = require('./components/Expense/create.vue').default;
let expenseIndex = require('./components/Expense/index.vue').default;
let expenseEdit = require('./components/Expense/edit.vue').default;

// salary routes
let salaryCreate = require('./components/Salary/create.vue').default;
let salaryIndex = require('./components/Salary/index.vue').default;
let salaryEdit = require('./components/Salary/edit.vue').default;
let salary_employees = require('./components/Salary/salary_employees.vue').default;
let salary_month_list = require('./components/Salary/salary_month.vue').default;
let all_salary = require('./components/Salary/all_salary.vue').default;
// customer routes
let customerCreate = require('./components/Customer/create.vue').default;
let customerIndex = require('./components/Customer/index.vue').default;
let customerEdit = require('./components/Customer/edit.vue').default;
//point of sell
let pointofsell = require('./components/pointofsell.vue').default;
//orders route
let todayOrder = require('./components/Order/todayOrder').default;
let orderDetails = require('./components/Order/orderDetails.vue').default;
let orders = require('./components/Order/orders.vue').default;
let search = require('./components/Order/search.vue').default;


export  const routes = [
    {path:'/', component: login, name:'login'},
    {path:'/register', component: register, name:'register'},
    {path:'/logout', component: logout, name:'logout'},

    {path:'/home', component: home, name:'home'},
// employee routes
    {path:'/add-employee', component: empCreate, name:'empAdd'},
    {path:'/employees', component: empIndex, name:'empIndex'},
    {path:'/employees-edit/:id', component: empEdit, name:'empEdit'},
// category routes
    {path:'/add-category', component: categoryCreate, name:'categoryCreate'},
    {path:'/categories', component: categoryIndex, name:'categoryIndex'},
    {path:'/category-edit/:id', component: categoryEdit, name:'categoryEdit'},

    // supplier routes
    {path:'/add-supplier', component: supCreate, name:'supAdd'},
    {path:'/suppliers', component: supIndex, name:'supIndex'},
    {path:'/supplier-edit/:id', component: supEdit, name:'supEdit'},
    // product routes
    {path:'/add-product', component: productCreate, name:'productCreate'},
    {path:'/products', component: productIndex, name:'productIndex'},
    {path:'/product-edit/:id', component: productEdit, name:'productEdit'},
    {path:'/stocks', component: stock, name:'stock'},
     // expense routes
    {path:'/add-expense', component: expenseCreate, name:'expenseCreate'},
    {path:'/expenses', component: expenseIndex, name:'expenseIndex'},
    {path:'/expense-edit/:id', component: expenseEdit, name:'expenseEdit'},
     // salary routes
    {path:'/add-salary/:id', component: salaryCreate, name:'salaryCreate'},
    {path:'/salaries/:month', component: salaryIndex, name:'salaryIndex'},
    {path:'/salary-edit/:id', component: salaryEdit, name:'salaryEdit'},
    {path:'/salary-employees', component: salary_employees, name:'salaryEmp'},
    {path:'/salary-months', component: salary_month_list, name:'salaryMonths'},
    {path:'/salary-lists', component: all_salary, name:'all_salary'},

     // customer routes
    {path:'/add-customer', component: customerCreate, name:'customerCreate'},
    {path:'/customers', component: customerIndex, name:'customerIndex'},
    {path:'/customer-edit/:id', component: customerEdit, name:'customerEdit'},
    //point of sell
    {path:'/pos', component: pointofsell, name:'pointofsell'},
    //order
    {path:'/today-orders',component:todayOrder,name:'todayOrder'},
    {path:'/order-details/:id',component:orderDetails,name:'orderDetails'},
    {path:'/orders',component:orders,name:'orders'},
    {path:'/order-search',component:search,name:'search'},

];
