<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import { updateProfileUserById, getUsers, changeDate } from "../api/user";
import * as yup from 'yup';
import sww from 'sweetalert2';
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
const api_endpoint = process.env.MIX_API_URL;
</script>

<template>
    <Form :validation-schema="schema">
        <div class="secure">
            <div class="container rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <img v-if="!this.$store.state.profileUserByID.avatar" class="rounded-circle mt-5" width="150px"
                                src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" />
                            <img v-if="this.$store.state.profileUserByID.avatar" class="rounded-circle mt-5" width="150px"
                                :src="`${api_endpoint}/storage/${this.$store.state.profileUserByID.avatar}`" />
                            <span class="text-black-50">{{this.$store.state.profileUserByID.email}}</span>
                        </div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">プロファイル設定</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="name" class="labels">氏名</label><span class="err-mess-validate">*</span>
                                <ErrorMessage class="err-mess-validate ml-3" name="name" as="span">{{ErrorMessage?'氏名は必須です。':''}}</ErrorMessage>
                                <Field id="name" name="name" type="text" class="form-control"
                                    placeholder="氏名入力" v-model="body.name" />
                            </div>
                            <div class="col-md-12">
                                <label for="address" class="labels">住所</label>
                                <!-- <span class="err-mess-validate">*</span>
                                <ErrorMessage class="err-mess-validate ml-3" name="address" /> -->
                                <Field as="textarea" name="address" id="address" type="text"
                                    class="form-control" placeholder="住所を入力してください。"
                                    v-model="body.address"></Field>
                            </div>
                            <div class="col-md-12">
                                <label for="post_code" class="labels">郵便番号</label>
                                <!-- <span class="err-mess-validate">*</span> -->
                                <ErrorMessage class="err-mess-validate ml-3" name="post_code" as="span">{{ErrorMessage?'郵便番号は数字で整数です。':''}}</ErrorMessage>
                                <Field id="post_code" name="post_code" type="text" class="form-control"
                                    placeholder="郵便番号を入力" v-model="body.post_code" />
                            </div>
                            <div class="col-md-12">
                                <label for="date_of_birth" class="labels">生年月日</label>
                                <Datepicker locale="ja" :enableTimePicker="false"  v-model="body.date_of_birth" autoApply :maxDate="new Date()"></Datepicker>
                            </div>
                            <div class="col-md-12">
                                <label for="salary" class="labels">給料</label>
                                <!-- <span class="err-mess-validate">*</span> -->
                                <ErrorMessage class="err-mess-validate ml-3" name="salary" as="span">{{ErrorMessage?'給料は数字で整数です。':''}}</ErrorMessage>
                                <div class="input-group mb-3">
                                    <Field id="salary" name="salary" type="text" class="form-control"
                                    placeholder="給料" v-model="body.salary" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">¥</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="avatar" class="labels">アバター</label>
                                <input id="avatar" @change="onFileSelected" name="avatar" type="file" class="form-control"/>
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
                                <label for="proficiency" class="labels">プロフィシェンシー</label>
                                <!-- <span class="err-mess-validate">*</span><ErrorMessage class="err-mess-validate ml-3" name="proficiency" /> -->
                                <Field as="textarea" name="proficiency" id="proficiency" type="text"
                                    class="form-control skill" placeholder="習熟度を入力" v-model="body.proficiency" />
                            </div>
                            <br />
                            <div class="col-md-12">
                                <label for="contract" class="labels">詳細契約</label>
                                <!-- <span class="err-mess-validate">*</span>
                                <ErrorMessage class="err-mess-validate ml-3" name="contract" /> -->
                                <Field as="textarea" id="contract" name="contract"
                                    type="text" class="form-control labo" placeholder="契約内容を入力"
                                    v-model="body.contract" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-5 confirmed-wrap">
                    <label v-if="this.$store.state.profileUserByID.confirmed == 0" for="confirmed">検証</label>
                    <label v-if="this.$store.state.profileUserByID.confirmed == 1" for="confirmed">未検証</label>
                    <input class="cfm-au" type="checkbox" name="confirmed" id="confirmed" v-model="body.confirmed">
                    <button @click="updateProfileUserbyIDAdmin(this.$store.state.profileUserByID.id)"
                        class="btn btn-primary profile-button ml-5" type="button">
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
    name: "MGProfileUser",
    components: { Datepicker },
    data() {
        return {
            body: {
                name: this.$store.state.profileUserByID.name,
                post_code: this.$store.state.profileUserByID.post_code,
                address: this.$store.state.profileUserByID.address,
                proficiency: this.$store.state.profileUserByID.proficiency,
                contract: this.$store.state.profileUserByID.contract,
                salary: parseInt(this.$store.state.profileUserByID.salary),
                confirmed: this.$store.state.profileUserByID.confirmed?true:false,
                date_of_birth: this.$store.state.profileUserByID.date_of_birth,
                _method: 'PUT',
            },
            selectedFile: null,
            passErr: false
        };
    },
    mounted() {
        if (!this.$store.state.authenticated) {
            this.$router.replace({ name: "home" });
        }
    },
    methods: {

        updateProfileUserbyIDAdmin: function (id,) {
            var dateCus = changeDate(this.body);
            var {confirmed} = this.$store.state.profileUserByID;
            if(confirmed == 1){
                this.$store.state.profileUserByID.confirmed = true
            }
            if(!confirmed){
                this.$store.state.profileUserByID.confirmed = false
            }
            updateProfileUserById(id, this.body, this.selectedFile, dateCus).then(data => {
                if(data.status === true){
                    getUsers().then(data => {
                        this.$store.state.users = data.data.data
                        this.$router.replace({ name: "manageruser" });
                    })
                }
                if(data.status ==='error'){
                    sww.fire({
                        icon: 'error',
                        title: 'エラーが発生しました。もう一度ご確認ください。'
                    })
                }
            })
        },
        onFileSelected: function(e){
            this.selectedFile = e.target.files[0]
        },
        ComfirmPassword(){
            if(this.body.password !== this.body.password_confirmation){
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

body {
    background: rgb(99, 39, 120)
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
