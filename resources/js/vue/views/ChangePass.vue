<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import { updateProfileUserByUser, getUserProfile, changePassword, changePasswordByUser } from "../api/user";
import * as yup from 'yup';
import sww from 'sweetalert2';
const api_endpoint = process.env.MIX_API_URL;
const schema = yup.object({
    name: yup.string().required(),
    email: yup.string().required().email(),
    new_password: yup.string().required().min(6),
    old_password: yup.string().required().min(6),
    password: yup.string().required().min(6),
    password_confirmation: yup.string().required().min(6),
    address: yup.string().required(),
    post_code: yup.number().positive(),
    salary: yup.number().positive(),
    proficiency: yup.string().required(),
    contract: yup.string().required(),
});
</script>

<template>
    <div id="app1">
        <Form :validation-schema="schema">
            <div class="reset-pass">
            <h1>パスワードを変更する</h1>
                <div v-if="this.$route.params.id === 'user'">
                    <label for="old_password">以前のパスワード</label>
                    <span class="err-mess-validate">*</span>
                    <ErrorMessage class="err-mess-validate ml-3" name="old_password" as="span">{{ErrorMessage?'パスワードは6文字以上で必要です。':''}}</ErrorMessage>
                    <Field
                        as="input"
                        id="old_password"
                        type="password"
                        name="old_password"
                        placeholder="以前のパスワード"
                        v-model="body.old_password"
                    />
                </div>

                <label for="new_password">新しいパスワード</label>
                <span class="err-mess-validate">*</span>
                <ErrorMessage class="err-mess-validate ml-3" name="new_password" as="span">{{ErrorMessage?'パスワードは6文字以上で必要です。':''}}</ErrorMessage>
                <Field
                    as="input"
                    id="new_password"
                    type="password"
                    name="new_password"
                    placeholder="新しいパスワード"
                    v-model="body.new_password"
                    @change="ComfirmPassword()"
                />

                <label for="password_confirmation">パスワード</label>
                <span class="err-mess-validate">*</span>
                <span v-if="passErr" class="err-mess-validate ml-3">パスワードを再度ご確認ください。</span>
                <ErrorMessage class="err-mess-validate ml-3" name="password_confirmation" as="span">{{ErrorMessage?'パスワードは6文字以上で必要です。':''}}</ErrorMessage>
                <Field
                    as="input"
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="パスワードを入力してください。"
                    v-model="body.password_confirmation"
                    @change="ComfirmPassword()"
                />

                <button v-on:click="resetPass()" type="submit" class="btn btn-primary btn-block btn-large">reset</button>
        </div>
        </Form>

        <RouterView @authenticated="setAuthenticated" />
    </div>
</template>


<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    name: "ChangePass",
    components: { Datepicker },
    data() {
        return {
            body: {
                new_password: null,
                password_confirmation: null,
                old_password: null,
            },
            passErr: false,
            contract: this.$store.state.profileUser.contract,
        };
    },
    mounted() {
        console.log('$route.params.id: ', this.$route.params.id);
        if (!this.$store.state.authenticated) {
            this.$router.replace({ name: "home" });
        }
    },
    methods: {
        resetPass: function(){
            if(this.$route.params.id === 'user'){
                changePasswordByUser(this.body). then(data => {
                    if(data.status === true){
                        this.$router.replace({ name: "profileuser" });
                        sww.fire({
                            icon: 'success',
                            title: 'パスワード変更済み'
                        })
                    }
                    if(data.status === false){
                        sww.fire({
                            icon: 'error',
                            title: 'パスワードが間違っている'
                        })
                    }
                })
            } else {
                    changePassword(this.body,this.$route.params.id).then(data => {
                    if(data.status === true){
                        this.$router.replace({ name: "manageruser" });
                        sww.fire({
                            icon: 'success',
                            title: 'パスワード変更済み'
                        })
                    }
                })
            }
        },
        ComfirmPassword(){
            if(this.body.new_password !== this.body.password_confirmation){
                this.passErr = true;
            } else {
                this.passErr = false;
            }
        }
    },
};
</script>

<style scoped>

.err-mess-validate{
    color: red;
    font-size: 12px;
}
.t{
    height: 100vh;
    width: 100%;
    font-family: 'Open Sans', sans-serif;
    background: #092756;
    background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -moz-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -moz-linear-gradient(-45deg, #670d10 0%, #092756 100%);
    background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -webkit-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -webkit-linear-gradient(-45deg, #670d10 0%, #092756 100%);
    background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -o-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -o-linear-gradient(-45deg, #670d10 0%, #092756 100%);
    background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -ms-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -ms-linear-gradient(-45deg, #670d10 0%, #092756 100%);
    background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), linear-gradient(to bottom, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), linear-gradient(135deg, #670d10 0%, #092756 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3E1D6D', endColorstr='#092756', GradientType=1);
}
.input100 {
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

.mess-err {
    color: #ff5858;
    position: absolute;
    top: 75%;
    left: 50%;
    margin: -150px 0 0 -150px;
}

#app1 {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}

.container-login100 {
    background-image: url("../assets/img/bg-01.jpg");
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

.container-login100 {
    display: grid;
}

/* @import url(https://fonts.googleapis.com/css?family=Open+Sans); */

.btn {
  display: inline-block;
  *display: inline;
  *zoom: 1;
  padding: 4px 10px 4px;
  margin-bottom: 0;
  font-size: 13px;
  line-height: 18px;
  color: #333333;
  text-align: center;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  vertical-align: middle;
  background-color: #f5f5f5;
  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: linear-gradient(top, #ffffff, #e6e6e6);
  background-repeat: repeat-x;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr=#ffffff, endColorstr=#e6e6e6, GradientType=0);
  border-color: #e6e6e6 #e6e6e6 #e6e6e6;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  border: 1px solid #e6e6e6;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  cursor: pointer;
  *margin-left: .3em;
}

.btn:hover,
.btn:active,
.btn.active,
.btn.disabled,
.btn[disabled] {
  background-color: #e6e6e6;
}

.btn-large {
  padding: 9px 14px;
  font-size: 15px;
  line-height: normal;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
}

.btn:hover {
  color: #333333;
  text-decoration: none;
  background-color: #e6e6e6;
  background-position: 0 -15px;
  -webkit-transition: background-position 0.1s linear;
  -moz-transition: background-position 0.1s linear;
  -ms-transition: background-position 0.1s linear;
  -o-transition: background-position 0.1s linear;
  transition: background-position 0.1s linear;
}

.btn-primary,
.btn-primary:hover {
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  color: #ffffff;
}

.btn-primary.active {
  color: rgba(255, 255, 255, 0.75);
}

.btn-primary {
  background-color: #4a77d4;
  background-image: -moz-linear-gradient(top, #6eb6de, #4a77d4);
  background-image: -ms-linear-gradient(top, #6eb6de, #4a77d4);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#6eb6de), to(#4a77d4));
  background-image: -webkit-linear-gradient(top, #6eb6de, #4a77d4);
  background-image: -o-linear-gradient(top, #6eb6de, #4a77d4);
  background-image: linear-gradient(top, #6eb6de, #4a77d4);
  background-repeat: repeat-x;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr=#6eb6de, endColorstr=#4a77d4, GradientType=0);
  border: 1px solid #3762bc;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.5);
}

.btn-primary:hover,
.btn-primary:active,
.btn-primary.active,
.btn-primary.disabled,
.btn-primary[disabled] {
  filter: none;
  background-color: #4a77d4;
}

.btn-block {
  width: 100%;
  display: block;
}

* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  -ms-box-sizing: border-box;
  -o-box-sizing: border-box;
  box-sizing: border-box;
}

html {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

body {
  width: 100%;
  height: 100%;
  font-family: 'Open Sans', sans-serif;
  background: #092756;
  background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -moz-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -moz-linear-gradient(-45deg, #670d10 0%, #092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -webkit-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -webkit-linear-gradient(-45deg, #670d10 0%, #092756 100%);
  background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -o-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -o-linear-gradient(-45deg, #670d10 0%, #092756 100%);
  background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -ms-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -ms-linear-gradient(-45deg, #670d10 0%, #092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), linear-gradient(to bottom, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), linear-gradient(135deg, #670d10 0%, #092756 100%);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3E1D6D', endColorstr='#092756', GradientType=1);
}

.reset-pass {
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -150px 0 0 -150px;
  width: 300px;
  height: 300px;
  text-align: left;
}

.reset-pass h1 {
    color: #030303;
    text-shadow: 0 0 10px rgb(0 0 0 / 30%);
    letter-spacing: 1px;
    text-align: center;
    font-size: 28px;
    margin-bottom: 20px;
}

input {
  width: 100%;
  margin-bottom: 10px;
  background: rgba(0, 0, 0, 0.3);
  border: none;
  outline: none;
  padding: 10px;
  font-size: 13px;
  color: #fff;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(0, 0, 0, 0.3);
  border-radius: 4px;
  box-shadow: inset 0 -5px 45px rgba(100, 100, 100, 0.2), 0 1px 1px rgba(255, 255, 255, 0.2);
  -webkit-transition: box-shadow .5s ease;
  -moz-transition: box-shadow .5s ease;
  -o-transition: box-shadow .5s ease;
  -ms-transition: box-shadow .5s ease;
  transition: box-shadow .5s ease;
}

input:focus {
  box-shadow: inset 0 -5px 45px rgba(100, 100, 100, 0.4), 0 1px 1px rgba(255, 255, 255, 0.2);
}
</style>
