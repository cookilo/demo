<script setup>
import { addUser, getUsers } from "../api/user";
</script>

<template>
    <div class="secure">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" />
                        <span class="text-black-50">edogaru@mail.com.my</span><span> </span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Name</label><input id="name" type="text" class="form-control"
                                    placeholder="enter name" v-model="body.name" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input id="email" type="text" class="form-control" placeholder="enter email" v-model="body.email" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Password</label><input id="password" type="password"
                                    class="form-control" placeholder="enter password" v-model="body.password" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Address Line 1</label><textarea id="address" type="text"
                                    class="form-control" placeholder="enter address line 1" v-model="body.address" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Postcode</label><input id="post_code" type="text"
                                    class="form-control" placeholder="enter Postcode" v-model="body.post_code" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Date of birth</label>
                                <Datepicker :enableTimePicker="false"  v-model="body.date_of_birth"></Datepicker>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Salary</label><input id="salary" type="text" class="form-control"
                                    placeholder="enter money" v-model="body.salary" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Avatar</label><input id="avatar" @change="onFileSelected" name="avatar" type="file" class="form-control"/>
                            </div>
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
                            <label class="labels">Proficiency</label><textarea id="proficiency" type="text"
                                class="form-control skill" placeholder="experience" v-model="body.proficiency" />
                        </div>
                        <br />
                        <div class="col-md-12">
                            <label class="labels">Contract details</label><textarea id="contract" type="text"
                                class="form-control labo" placeholder="additional details" v-model="body.contract" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button @click="addNewUser()" class="btn btn-primary profile-button ml-5" type="button">
                    Save Profile
                </button>
            </div>
            <div v-if="messErr" class="mess-err-add mt-3 text-center">
                <div v-for="(err,i) of messErr" :key="i" class="mes-err">{{err[0]}}</div>
            </div>
        </div>
    </div>
</template>


<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    name: "AddUser",
    components: { Datepicker },
    data() {
        return {
            body: {
                name: '',
                email: '',
                password: '',
                post_code: '',
                address: '',
                proficiency: '',
                contract: '',
                salary: '',
                date_of_birth: '',
            },
            messErr: null,
            selectedFile: null,
            date: null,
        };
    },
    mounted() {
        if (!this.$store.state.authenticated) {
            this.$router.replace({ name: "home" });
        }
    },
    methods: {
        addNewUser: function () {
            var dateCus = null;
            console.log(this.body.date_of_birth,'-:this.body.date_of_birth: ', typeof this.body.date_of_birth);
            if(typeof this.body.date_of_birth === 'object'){
                var day = this.body.date_of_birth.getDate().toString();
                var mon = (this.body.date_of_birth.getMonth()+1).toString();
                var y = this.body.date_of_birth.getFullYear().toString();

                if(day.length === 1 ){
                    day = `0${day}`
                }
                if(mon.length === 1 ){
                    mon = `0${mon}`
                }
                dateCus = `${y}-${mon}-${day}`;
            }
            if(typeof this.body.date_of_birth === 'string'){
                if(this.body.date_of_birth.length){
                    dateCus = this.body.date_of_birth;
                }
            }
            console.log('--------dateCus--------: ', dateCus);

            addUser(this.body, this.selectedFile, dateCus).then(data => {
                if(data.status === true){
                    this.$router.replace({ name: "manageruser" });
                    getUsers().then(data => {
                        this.$store.state.users = data.data.data
                    })
                }
                if(data.status === 'error'){
                    this.messErr = data.data;
                }
            })
        },
        onFileSelected: function(e){
            this.selectedFile = e.target.files[0]
        }
    },
};
</script>
<style scoped>
@import url(https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css);

@media screen and (max-width: 520px){
    .mess-err-add{
        width: 100% !important;
    }
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
.mess-err-add {
    width: 35%;
    margin: 0 auto;
    border: 1px #030303 solid;
    border-radius: 5px;
    padding: 5px;
}
</style>
