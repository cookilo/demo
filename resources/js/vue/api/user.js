import axios from 'axios';

function getHeader(){
    return  {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            authorization: 'bearer ' + sessionStorage.getItem('tk'),

        };
}

function getHeader1(){
    return  {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            authorization: 'bearer ' + sessionStorage.getItem('tk'),
            'Cache-Control': 'no-cache',
            "Content-Type": "multipart/form-data",
        };
}

export const getUsers = async () => {
    return axios({
        method: 'get',
        url: process.env.MIX_API_URL + '/api/admin/profile',
        headers: getHeader(),
    })
        .then(res => {
            return res.data;
        })
}

export const singin = async (email, password) => {
    return axios({
        method: "post",
        url: process.env.MIX_API_URL + "/api/auth/login",
        data: {email,password}
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });

}

export const getUserProfile = async () => {
    return axios({
        method: "get",
        url: process.env.MIX_API_URL + "/api/profile" ,
        headers: getHeader(),
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });

}

export const getUserProfileByID = async (id) => {
    return axios({
        method: "get",
        url: process.env.MIX_API_URL + `/api/admin/profile/${id}`,
        headers: getHeader(),
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });

}

export const updateProfileUserById = async (id, body, avt) => {
    if(avt){
        const fd = new FormData();
        fd.append('image',avt)
        body.avatar = avt;
    }
    if(!body.date_of_birth){
        delete body.date_of_birth
    }
    return axios({
        method: "post",
        url: process.env.MIX_API_URL + `/api/admin/profile/${id}`,
        headers: getHeader1(),
        data: {
            ...body
        }
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });
}

export const addUser = async (body, avt, date) => {
    if(avt){
        const fd = new FormData();
        fd.append('image',avt)
        body.avatar = avt;
    }

    if(date){
        body.date_of_birth = date;
    } else {
        delete body.date_of_birth
    }

    return axios({
        method: "post",
        url: process.env.MIX_API_URL + "/api/admin/profile",
        headers: getHeader1(),
        data: {
            ...body
        },
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });
}

export const deleteUser = async (id) => {
    return axios({
        method: "delete",
        url: process.env.MIX_API_URL + "/api/admin/profile/" + id,
        headers: getHeader(),
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });
}


export const updateProfileUserByUser = async (body, avt) => {
    if(avt){
        const fd = new FormData();
        fd.append('image',avt)
        body.avatar = avt;
    }
    if(!body.date_of_birth){
        delete body.date_of_birth
    }
    return axios({
        method: "post",
        url: process.env.MIX_API_URL + "/api/profile",
        headers: getHeader1(),
        data: {
            ...body
        }
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });
}
