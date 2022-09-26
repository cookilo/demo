<script setup>
import { useStore } from "vuex";
import { singin, getUsers, getUserProfile } from "./api/user";
</script>

    <template>
    <div id="app1">
        <div id="nav">
        <!-- <router-link v-if="this.$store.state.authenticated" to="/">Home</router-link> -->
        <router-link v-if="this.$store.state.authenticated && this.$store.state.userType" to="/ManagerUser">ユーザー管理</router-link>
        <router-link v-if="this.$store.state.authenticated && !this.$store.state.userType" to="/profileuser">プロファイルユーザー</router-link>
        <router-link v-if="this.$store.state.authenticated && this.$store.state.userType" to="/adduser">ユーザー追加</router-link>
        <router-link
            v-if="this.$store.state.authenticated"
            to="/"
            v-on:click="logout()"
            replace
            >ログアウト</router-link
        >
        <div class="limiter" v-if="!this.$store.state.authenticated">
            <div class="container-login100">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-41"> ログインアカウント </span>
                <div
                class="wrap-input100 validate-input"
                data-validate="メールアドレスを入力してください。"
                >
                <input
                    class="input100"
                    id="username"
                    v-model="input.username"
                    type="text"
                    name="username"
                    placeholder="メールアドレス"
                />
                </div>

                <div
                class="wrap-input100 validate-input"
                data-validate="パスワードを入力してください。"
                >
                <input
                    class="input100"
                    id="password"
                    v-model="input.password"
                    type="password"
                    name="pass"
                    placeholder="パスワード"
                />
                </div>

                <div class="container-login100-form-btn m-t-32">
                <button class="login100-form-btn" v-on:click="login()">
                    ログインアカウント
                </button>
                </div>
            </div>
            <div v-if="messErr" class="mess-err">{{messErr}}</div>
            </div>
        </div>
        <RouterView @authenticated="setAuthenticated"/>
        </div>
    </div>
</template>

    <script>
export default {
    setup() {
        const store = useStore();
    },
    data() {
        return {
            authenticated: false,
            input: {
                username: "",
                password: "",
            },
            messErr: null,
        };
    },
    methods: {
        setAuthenticated(status) {
            this.$store.state.authenticated = status;
        },
        logout() {
            this.setAuthenticated(false)
            sessionStorage.setItem("tk",'');
        },
        login() {
        if (this.input.username != "" && this.input.password != "") {
            singin(this.input.username, this.input.password).then((data) => {
                if(data.code !== 202){
                    this.messErr = data.message;
                }
                if (data) {
                    if(data.data.user){
                        if(data.data.user.roles.some(r=> r.name === 'admin')){
                            // this.$emit("authenticated", true);
                            this.$router.replace({ name: "manageruser" });
                            this.setAuthenticated(true)
                            this.$store.state.userType = true;
                            sessionStorage.setItem("tk", data.data.access_token);
                            getUsers().then(data => {
                                this.$store.state.users = data.data.data

                            })
                        }
                        if(data.data.user.roles.some(r=> r.name === 'user')){
                            // this.$emit("authenticated", true);
                            this.setAuthenticated(true)
                            this.$store.state.userType = false;
                            sessionStorage.setItem("tk", data.data.access_token);
                            getUserProfile().then(data => {
                                this.$store.state.profileUser = data.data
                                this.$router.replace({ name: "profileuser" });
                            });
                        }
                    }

                }
            });
        } else {
            console.log("A username and password must be present");
        }
        },
    },
};
</script>


    <style scoped>
@import "./assets/css/bootstrap.min.css";
@import "./assets/css/util.css";
@import "./assets/css/main-new.css";
@import "./assets/fonts/icon-font.min.css";
.input100{
    color: #fff;
}
.input100::placeholder {
    color: #fff;
}
.input100::-ms-input-placeholder {
    color: #fff;
}
.input100::-ms-input-placeholder {
    color: #fff;
}
.mess-err{
   color: #ff5858;
}
#app1 {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}
.container-login100 {
    background-image: url("assets/img/bg-01.jpg");
}
#nav {
    padding-top: 10px;
}

#nav a {
    font-weight: bold;
    color: #2c3e50;
    padding-right: 10px;
}

#nav a:not(:first-child) {
    border-left: 1px solid #2c3e50;
    padding-left: 10px;
}

#nav a.router-link-exact-active {
    color: #42b983;
}
#login .form-inputs {
    padding-bottom: 10px;
}

#login .form-inputs label {
    padding-right: 10px;
}
.container-login100{
    display: grid;
}
</style>
