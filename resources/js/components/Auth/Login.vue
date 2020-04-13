<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-5 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="login" class="needs-validation" novalidate="">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input v-model="form.email" id="email" type="email" class="form-control" name="email"
                                       tabindex="1" required autofocus>
                                <div class="invalid-feedback" v-if="errors.email">
                                    {{errors.email[0]}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                    <div class="float-right">
                                        <a href="auth-forgot-password.html" class="text-small">
                                            Forgot Password?
                                        </a>
                                    </div>
                                </div>
                                <input id="password" v-model="form.password" type="password" class="form-control"
                                       name="password" tabindex="2" required>
                                <div class="invalid-feedback" v-if="errors.password">
                                    {{errors.password[0]}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                           id="remember-me">
                                    <label class="custom-control-label" for="remember-me">Remember Me</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 text-muted text-center">
                            Don't have an account?
                            <router-link :to="{name:'register'}">Create One</router-link>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                form: {
                    email: null,
                    password: null
                },
                errors: {},
            }
        },
        created() {
            if(User.loggedIn()){
                this.$router.push({name:'home'})
            }
        },
        methods: {
            login() {
                axios.post('/api/auth/login', this.form)
                    .then(res => {
                        User.responseAfterLogin(res);
                        Toast.fire({
                            icon: 'success',
                            title: 'Sign In Successfully!',
                        });
                        this.$router.push({name: 'home'})
                    })
                    .catch(error => {
                        if(error.response.data.errors){
                            this.errors = error.response.data.errors
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: 'Email Or Password Invalid!',
                            });
                        }

                    });


            }
        }
    }
</script>

<style scoped>

</style>
