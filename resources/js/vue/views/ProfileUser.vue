<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import { updateProfileUserByUser, getUserProfile, changeDate } from "../api/user";
import * as yup from 'yup';
import sww from 'sweetalert2';
const api_endpoint = process.env.MIX_API_URL;
const schema = yup.object({
    name: yup.string().required(),
    email: yup.string().required().email(),
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
    <Form :validation-schema="schema">
        <div class="secure">
            <div class="container rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <img v-if="!this.$store.state.profileUser.avatar" class="rounded-circle mt-5" width="150px"
                                src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" />
                            <img ref_for="avatar" v-if="this.$store.state.profileUser.avatar" class="rounded-circle mt-5" width="150px"
                                :src="`${api_endpoint}/storage/${this.$store.state.profileUser.avatar}`" />
                            <span class="text-black-50">{{this.$store.state.profileUser.email}}</span>
                            <button class="btn btn-primary profile-button ml-3" @click="changePass()">パスワードを変更する</button>
                        </div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">プロファイル設定</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="name" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}" class="labels">氏名</label>
                                <span class="err-mess-validate">*</span>
                                <ErrorMessage class="err-mess-validate ml-3" name="name" as="span">{{ErrorMessage?'氏名は必須です。':''}}</ErrorMessage>
                                <Field id="name" name="name" type="text" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}" class="form-control"
                                    placeholder="氏名入力" v-model="body.name" />
                            </div>
                            <div class="col-md-12">
                                <label for="address" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}" class="labels">住所</label>
                                <!-- <span class="err-mess-validate">*</span><ErrorMessage class="err-mess-validate ml-3" name="address" /> -->
                                <Field as="textarea" name="address" type="text" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}"
                                    class="form-control"
                                    placeholder="住所を入力してください。"
                                    v-model="body.address" id="address" />
                            </div>
                            <div class="col-md-12">
                                <label for="post_code" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}" class="labels">郵便番号</label>
                                <!-- <span class="err-mess-validate">*</span> -->
                                <ErrorMessage class="err-mess-validate ml-3" name="post_code" as="span">{{ErrorMessage?'郵便番号は数字で整数です。':''}}</ErrorMessage>
                                <Field id="post_code" name="post_code" type="text" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}"
                                class="form-control" placeholder="郵便番号を入力" v-model="body.post_code" />
                            </div>
                            <div class="col-md-12">
                                <label for="date_of_birth" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}" class="labels">生年月日</label>
                                <Datepicker locale="ja" autoApply :enableTimePicker="false"  :maxDate="new Date()"
                                            v-model="body.date_of_birth"
                                            :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}">
                                </Datepicker>
                            </div>
                            <div class="col-md-12">
                                <label for="salary" class="labels none-active-input">給料</label>
                                <!-- <span class="err-mess-validate">*</span> -->
                                <ErrorMessage class="err-mess-validate ml-3" name="salary" as="span">{{ErrorMessage?'給料は数字で整数です。':''}}</ErrorMessage>
                                <div class="input-group mb-3">
                                    <Field id="salary" name="salary" type="text"
                                        class="form-control none-active-input read-only" placeholder="給料" :value="body.salary" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">¥</span>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <label for="avatar" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}" class="labels">アバター</label>
                                <input  id="avatar" @change="onFileSelected" name="avatar"
                                    type="file" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 py-5">
                            <div class="
                                d-flex
                                justify-content-between
                                align-items-center
                                experience
                            ">
                            </div>
                            <br />
                            <div class="col-md-12">
                                <label for="proficiency" :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}"
                                    class="labels">プロフィシェンシー</label>
                                    <!-- <span class="err-mess-validate">*</span><ErrorMessage class="err-mess-validate ml-3" name="proficiency" /> -->
                                    <Field as="textarea" name="proficiency" type="text"
                                        :class="{'none-active-input':this.$store.state.profileUser.confirmed !==0}"
                                        class="form-control skill"
                                        id="proficiency"
                                        placeholder="習熟度を入力" v-model="body.proficiency" />
                            </div>
                            <br />
                            <div class="col-md-12">
                                <label for="contract" class="labels none-active-input">詳細契約</label>
                                <!-- <span class="err-mess-validate">*</span>
                                <ErrorMessage class="err-mess-validate ml-3" name="contract" /> -->
                                <Field as="textarea" name="contract" type="text"
                                    class="form-control labo none-active-input read-only" placeholder="契約内容を入力"
                                    id="contract"
                                    :value="contract"
                                    />
                            </div>
                        </div>
                    </div>

                </div>
                <div v-if="this.$store.state.profileUser.confirmed===0" class="mt-5 confirmed-wrap">
                    <label for="confirmed">検証</label>
                    <input class="cfm-au" type="checkbox" name="confirmed" id="confirmed" v-model="body.confirmed">
                    <button @click="updateUserByUser()" class="btn btn-primary profile-button ml-3" type="button">
                        保存
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
    name: "ProfileUser",
    components: { Datepicker },
    data() {
        return {
            body: {
                name: this.$store.state.profileUser.name,
                post_code: this.$store.state.profileUser.post_code,
                address: this.$store.state.profileUser.address,
                proficiency: this.$store.state.profileUser.proficiency,
                contract: this.$store.state.profileUser.contract,
                salary: parseInt(this.$store.state.profileUser.salary),
                confirmed: this.$store.state.profileUser.confirmed?true:false,
                date_of_birth: this.$store.state.profileUser.date_of_birth,
                _method: 'PUT',
            },
            selectedFile: null,
            contract: this.$store.state.profileUser.contract,
        };
    },
    mounted() {
        if (!this.$store.state.authenticated) {
            this.$router.replace({ name: "home" });
        }
    },
    methods: {
        updateUserByUser: function(){
            var dateCus = changeDate(this.body);
            updateProfileUserByUser(this.body, this.selectedFile, dateCus).then(data_update => {
                getUserProfile().then(data => {
                    this.$store.state.profileUser = data.data
                    this.$router.replace({ name: "profileuser" });
                });
                if(data_update.status === 'error' || data_update.status === 500){
                    sww.fire({
                        icon: 'error',
                        title: 'エラーが発生しました。もう一度ご確認ください。'
                    })
                }
                if(data_update.status === true) {
                        sww.fire({
                        title: 'プロファイルが保存されました。'
                    })
                }
            })
        },
        onFileSelected: function(e){
            this.selectedFile = e.target.files[0]
        },
        changePass: function () {
            this.$router.push({ name: `changepass`, params: { id: 'user' }});
        },
    },
};
</script>
<style scoped>
@import url(https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css);

.read-only{
    background-color: #efefef;
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
