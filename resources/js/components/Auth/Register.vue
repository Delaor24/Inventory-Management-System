<template>
    <div class="container mt-1">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-6 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="name">Full Name</label>
                                    <input v-model="form.name" id="name" type="text" class="form-control" autofocus>
                                    <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input v-model="form.email" id="email" type="email" class="form-control">
                                <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                                <div class="invalid-feedback">

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="password" class="d-block">Password</label>
                                    <input id="password" v-model="form.password" type="password"
                                           class="form-control pwstrength" data-indicator="pwindicator"
                                           name="password">
                                    <small class="text-danger" v-if="errors.password">{{errors.password[0]}}</small>
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="password2" class="d-block">Password Confirmation</label>
                                    <input v-model="form.password_confirmation" id="password2" type="password"
                                           class="form-control" name="password-confirm">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                                    <label class="custom-control-label" for="agree">I agree with the terms and
                                        conditions</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="mb-4 text-muted text-center">
                        Already Registered?
                        <router-link :to="{name: 'login'}">Login</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                form: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null
                },
                errors:{},
            }
        },
        created() {
            if(User.loggedIn()){
                this.$router.push({name:'home'})
            }
        },
        methods: {
            register() {
                axios.post('/api/auth/register', this.form)
                    .then(res => {
                        User.responseAfterLogin(res);
                        Toast.fire({
                            icon: 'success',
                            title: 'Signed in successfully'

                        });
                        this.$router.push({name: 'home'})
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            }
        }
    }
</script>

<style scoped>

</style>
