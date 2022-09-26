import axios from 'axios';
const api_endpoint = process.env.MIX_API_URL;
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
            authorization: 'bearer ' + sessionStorage.getItem('tk'),
            'Cache-Control': 'no-cache',
            "Content-Type": "multipart/form-data",
        };
}

export const getUsers = async () => {
    return axios({
        method: 'get',
        url: `${api_endpoint}/api/admin/profile`,
        headers: getHeader(),
    })
        .then(res => {
            return res.data;
        })
}

export const singin = async (email, password) => {
    return axios({
        method: "post",
        url: `${api_endpoint}/api/auth/login`,
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
        url: `${api_endpoint}/api/profile`,
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
        url: `${api_endpoint}/api/admin/profile/${id}`,
        headers: getHeader(),
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });

}

function changeConfirmed(body){
    var cf;
    if (body.confirmed) {
        cf = 1;
    } else {
        cf = 0;
    }
    return cf;
}

export const changeDate = (body) => {
    var dateCus = null;
    if(body.date_of_birth && typeof body.date_of_birth === 'object'){
        var day = body.date_of_birth.getDate().toString();
        var mon = (body.date_of_birth.getMonth()+1).toString();
        var y = body.date_of_birth.getFullYear().toString();

        if(day.length === 1 ){
            day = `0${day}`
        }
        if(mon.length === 1 ){
            mon = `0${mon}`
        }
        dateCus = `${y}-${mon}-${day}`;
    }
    if(body.date_of_birth){
        if(body.date_of_birth.length){
            dateCus = body.date_of_birth;
        }
    }
    return dateCus;
}

export const updateProfileUserById = async (id, body, avt, date) => {
    var cf = changeConfirmed(body);
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
        url: `${api_endpoint}/api/admin/profile/${id}`,
        headers: getHeader1(),
        data: {
            ...body,
            confirmed: cf
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

    var cf = changeConfirmed(body);

    return axios({
        method: "post",
        url: `${api_endpoint}/api/admin/profile`,
        headers: getHeader1(),
        data: {
            ...body,
            confirmed: cf
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
        url: `${api_endpoint}/api/admin/profile/${id}`,
        headers: getHeader(),
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });
}


export const updateProfileUserByUser = async (body, avt, date) => {
    // const data = body
    if(date){
        body.date_of_birth = date;
    } else {
        delete body.date_of_birth
    }
    var cf = changeConfirmed(body);
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
        url: `${api_endpoint}/api/profile`,
        headers: getHeader1(),
        data: {
            ...body,
            confirmed: cf
        }
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (jes) {
            return jes.data;
        });
}
