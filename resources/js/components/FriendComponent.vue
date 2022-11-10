<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Friend Component</div>

                    <div class="card-body">
                        <div class="row">
                            <div
                                class="col-md-4"
                                v-for="(item, index) in friends"
                                :key="index"
                            >
                                <div>
                                    <h3>{{ item.user2.name }}</h3>
                                    <a href="javascript:void(0);">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            friends: [],
        };
    },

    created() {
        this.getFriends();
    },

    methods: {
        async getFriends() {
            try {
                axios
                    .get(`/friends`, {
                        headers: {
                            "Access-Control-Allow-Origin": "*",
                            "Content-type": "Application/json",
                            Authorization: `Bearer ${window.localStorage.getItem('logintoken')}`,
                        },
                    })
                    .then((response) => {
                        if (
                            !response.data.error &&
                            response.data.payload != null
                        ) {
                            this.friends = JSON.parse(JSON.stringify(response.data.payload.friends));
                        }
                    })
                    .catch((error) => {});
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
