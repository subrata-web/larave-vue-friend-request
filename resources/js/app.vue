<template>
    <div>
        <div class="container" style="margin-top: 20px">
            <div class="row">
                <div class="col-md-6 col-offset-3">
                    <router-link to="/login">Login</router-link> |
                    <router-link to="/friends">My Friends</router-link>
                </div>
                <router-view />
            </div>
        </div>
    </div>
</template>
<script></script>
<style scoped></style>
