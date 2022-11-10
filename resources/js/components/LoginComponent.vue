<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login Component</div>

                    <div class="card-body">
                        <form @submit.prevent="handleLogin">
                            <p>
                                <input
                                    placeholder="Enter email"
                                    type="email"
                                    name="email"
                                    id="email"
                                    v-model="login.email"
                                    required
                                />
                            </p>
                            <p>
                                <input
                                    placeholder="********"
                                    type="password"
                                    name="password"
                                    id="password"
                                    v-model="login.password"
                                    required
                                />
                            </p>
                            <button type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "App",
    data() {
        return {
            login: {
                email: "",
                password: "",
            },
            errorShow: false,
            isSuccess: false,
            successMsg: "",
            isLoggedIn: false,
        };
    },

    methods: {
        async handleLogin() {
            try {
                const user = new FormData();
                user.append("email", this.login.email);
                user.append("password", this.login.password);
                axios
                    .post(`/auth/login`, user)
                    .then((response) => {
                        if (
                            !response.data.error &&
                            response.data.payload != null
                        ) {
                            this.isLoggedIn = true;
                            this.isSuccess = true;
                            this.successMsg = response.data.msg;
                            window.localStorage.setItem(
                                "logintoken",
                                response.data.payload.token
                            );
                            window.location.href = '/friends';
                        }
                    })
                    .catch((error) => {
                        this.errorShow = true;
                    });
            } catch (error) {
                this.errorShow = true;
                console.log(error);
            }
        },
    },
};
</script>
