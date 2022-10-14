<script setup>
import sww from 'sweetalert2';
import { getUserProfileByID, deleteUser, getUsers} from "../api/user";
const api_endpoint = process.env.MIX_API_URL;
</script>

<template>
    <div class="about">
        <div class="text-end"><button type="button" class="btn btn-primary" @click="addUser()">新しいユーザー追加</button>
        </div>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">アバター</th>
                    <th scope="col">氏名</th>
                    <th scope="col">住所</th>
                    <th scope="col">アクション</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in this.$store.state.users" :key="user.id">
                    <td scope="row">{{user.id}}</td>
                    <td>
                        <img v-if="!user.avatar" class="img-avatar"
                        src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"
                        alt="" />
                        <img v-if="user.avatar" class="img-avatar" :src="`${api_endpoint}/storage/${user.avatar}`" alt="" />
                    </td>
                    <td>{{user.name}}</td>
                    <td>{{user.address}}</td>
                    <td>
                        <div class="actions-user">
                            <div @click="editProfileUserById(user.id)" class="ac-user"><img class="img-user-action" src="../assets/img/user-avatar.png" alt=""></div>
                            <div @click="changePass(user.id)" class="ac-user"><img class="img-user-action" src="../assets/img/password.png" alt=""></div>
                            <div @click="remoteUserByID(user.id)" class="ac-user"><img class="img-user-action" src="../assets/img/remove.png" alt=""></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    setup() {

    },
    mounted() {
        console.log('+++++++++++++++++++++++');
        if (!this.$store.state.authenticated) {
            console.log('--------------------');
            this.$router.replace({ name: "home" });
        }
    },
    methods: {
        
        editProfileUserById: function (id) {
            getUserProfileByID(id).then(data => {
                this.$store.state.profileUserByID = data.data
                this.$router.replace({ name: "editprofileuser" });
            })
        },
        changePass: function (id) {
            this.$router.push({ name: `changepass`, params: { id: id }});
        },

        addUser: function () {
            this.$router.replace({ name: "adduser" });
        },

        remoteUserByID: function(id){
            sww.fire({
                title: 'ユーザーを削除しますか?',
                showCancelButton: true
            }).then(r =>{
                if(r.isConfirmed){
                    deleteUser(id).then(data => {
                        if(data.status === true){
                            getUsers().then(data => {
                                this.$store.state.users = data.data.data
                            })
                        }
                    })
                }
            })


        }
    }
}
</script>
<style scoped>
.actions-user{
    display: flex;
    justify-content: center;
}
.ac-user{
    width: 40px;
    height: 40px;
    margin: 0 5px;
    cursor: pointer;
}
.img-user-action{
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.img-avatar {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}

.about {
    text-align: right;
    width: 85%;
    margin: 0 auto;
}
th{
    text-align: center !important;
}
</style>

