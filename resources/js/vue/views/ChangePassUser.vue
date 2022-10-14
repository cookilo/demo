<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import { updateProfileUserByUser, getUserProfile, changePassword, changePasswordByUser } from "../api/user";
import * as yup from 'yup';
import sww from 'sweetalert2';
const api_endpoint = process.env.MIX_API_URL;
const schema = yup.object({
        old_password: yup.string().required().min(6),
        new_password: yup.string().required().min(6),
        password_confirmation: yup.string().required().min(6),

    });
</script>
<template>
    <Form @submit="resetPass" :validation-schema="schema">
        <div class="secure">
            <div class="container rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <img v-if="!imforUser.avatar" class="rounded-circle mt-5" width="150px"
                                src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" />
                            <img ref_for="avatar" v-if="imforUser.avatar" class="rounded-circle mt-5" width="150px"
                                :src="`${api_endpoint}/storage/${imforUser.avatar}`" />
                            <span class="text-black-50">{{imforUser.email}}</span>
                        </div>
                    </div>
                    <div class="col-md-5 border-right no-border">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">パスワードを変更する</h4>
                            </div>

                            <div class="col-md-12">
                                <label class="labels" for="old_password">以前のパスワード</label>
                                <ErrorMessage class="err-mess-validate ml-3" name="old_password" as="span">{{ErrorMessage?'古いパスワードが必要です':''}}</ErrorMessage>
                                <Field
                                    as="input"
                                    class="form-control"
                                    id="old_password"
                                    type="password"
                                    name="old_password"
                                    placeholder="以前のパスワード"
                                    v-model="body.old_password"
                                />
                            </div>

                            <div class="col-md-12">
                                <label class="labels" for="new_password">新しいパスワードを入力してください。</label>
                                <span class="err-mess-validate">*</span>
                                <ErrorMessage class="err-mess-validate ml-3" name="new_password" as="span">{{ErrorMessage?'パスワードは6文字以上で必要です。':''}}</ErrorMessage>
                                <Field
                                    class="form-control"
                                    as="input"
                                    id="new_password"
                                    type="password"
                                    name="new_password"
                                    placeholder="新しいパスワードを入力してください。"
                                    v-model="body.new_password"
                                    @change="ComfirmPassword()"
                                />
                            </div>

                            <div class="col-md-12">
                                <label class="labels" for="password_confirmation">新しいパスワード　確認のため再入力</label>
                                <span class="err-mess-validate">*</span>
                                <span v-if="passErr" class="err-mess-validate ml-3">パスワードを再度ご確認ください。</span>
                                <ErrorMessage class="err-mess-validate ml-3" name="password_confirmation" as="span">{{ErrorMessage?'パスワードは6文字以上で必要です。':''}}</ErrorMessage>
                                <Field
                                    class="form-control"
                                    as="input"
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="新しいパスワードを再入力してください。"
                                    v-model="body.password_confirmation"
                                    @change="ComfirmPassword()"
                                />
                            </div>

                        </div>
                    </div>
                </div>
                <div  class="mt-5 confirmed-wrap">
                    <button class="btn btn-primary profile-button ml-3" type="submit" value="Submit">
                        確認
                    </button>
                </div>
            </div>
        </div>
    </Form>
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
            imforUser: {}
        };
    },
    mounted() {
        console.log(yup.object);
        if (!this.$store.state.authenticated) {
            this.$router.replace({ name: "home" });
        }
        this.imforUser = this.$store.state.profileUser;
    },
    methods: {
        resetPass: function(){
                changePasswordByUser(this.body). then(data => {
                    if(data.status === true){
                        this.$router.replace({ name: "profileuser" });
                        sww.fire({
                            icon: 'success',
                            title: 'パスワード変更済み',
                            confirmButtonText: '確認',
                        })
                    }
                    if(data.status === false){
                        sww.fire({
                            icon: 'error',
                            title: 'パスワードが間違っている'
                        })
                    }
                })
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
@import url(https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css);

.no-border{
    border: unset !important;
}
.change-pass-user{
    color: #0d5dd5;
    cursor: pointer;
    font-size: 13px;
}
.confirmed-wrap{
    display: flex;
    justify-content: center;
    align-items: center;
}
.err-mess-validate{
    color: red;
    font-size: 12px;
}
.none-active-input {
    pointer-events: none !important;
}

body {
    background: rgb(99, 39, 120)
}

.secure {
    text-align: left;
}

.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: rgb(99, 39, 120);
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}

.cfm-au {
    width: 20px;
    height: 20px;
    margin-left: 10px;
}

.skill {
    height: 150px;
}

.labo {
    height: 300px;
}

.rounded-circle {
    width: 150px;
}
</style>
