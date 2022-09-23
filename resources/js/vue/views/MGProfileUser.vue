<script setup>
import { updateProfileUserById, getUsers } from "../api/user";
</script>

<template>
    <div class="secure">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img v-if="!this.$store.state.profileUserByID.avatar" class="rounded-circle mt-5" width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" />
                        <img v-if="this.$store.state.profileUserByID.avatar" class="rounded-circle mt-5" width="150px"
                            :src="process.env.MIX_API_URL + `/storage/${this.$store.state.profileUserByID.avatar}`" />
                        <span class="text-black-50">{{this.$store.state.profileUserByID.email}}</span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Name</label><input id="name" type="text" class="form-control"
                                placeholder="enter Postcode" v-model="body.name" />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Postcode</label><input id="post_code" type="text" class="form-control"
                                placeholder="enter Postcode" v-model="body.post_code" />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">salary</label><input id="salary" type="text" class="form-control"
                                placeholder="enter salary" v-model="body.salary" />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">date of birth</label><input id="date_of_birth" type="text"
                                class="form-control" placeholder="enter date of birth" v-model="body.date_of_birth" />
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Address</label><textarea id="address" type="text"
                                    class="form-control" placeholder="enter phone number"
                                    v-model="body.address"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Avatar</label>
                                    <input id="avatar" @change="onFileSelected" name="avatar" type="file" class="form-control"/>
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
                            <label class="labels">proficiency</label><textarea id="proficiency" type="text"
                                class="form-control skill" placeholder="experience" v-model="body.proficiency" />
                        </div>
                        <br />
                        <div class="col-md-12">
                            <label class="labels">Contract Details</label><textarea id="contract" name="contract"
                                type="text" class="form-control labo" placeholder="additional details"
                                v-model="body.contract" />
                        </div>
                    </div>
                </div>

            </div>
            <div class="mt-5 text-center">
                <label for="">Show checkbox</label>
                <input class="cfm-au" type="checkbox" name="confirmed" id="confirmed" v-model="body.confirmed">
                <button @click="updateProfileUserbyIDAdmin(this.$store.state.profileUserByID.id)"
                    class="btn btn-primary profile-button ml-5" type="button">
                    Save Profile
                </button>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    name: "MGProfileUser",
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
        };
    },
    mounted() {
        if (!this.$store.state.authenticated) {
            this.$router.replace({ name: "home" });
        }
    },
    methods: {
        updateProfileUserbyIDAdmin: function (id,) {
            if (this.body.confirmed) {
                this.body.confirmed = 1;
            } else {
                this.body.confirmed = 0;
            }
            updateProfileUserById(id, this.body, this.selectedFile).then(data => {
                if(data.status){
                    getUsers().then(data => {
                        this.$store.state.users = data.data.data
                        this.$router.replace({ name: "manageruser" });
                    })
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