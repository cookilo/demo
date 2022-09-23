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

export const updateProfileUserById = async (id, body, avt) => {
    if (body.confirmed) {
        body.confirmed = 1;
    } else {
        body.confirmed = 0;
    }
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
        url: `${api_endpoint}/api/admin/profile/${id}`,
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
        url: `${api_endpoint}/api/admin/profile`,
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


export const updateProfileUserByUser = async (body, avt) => {
    const data = body
    if (data.confirmed) {
        data.confirmed = 1;
        } else {
            data.confirmed = 0;
        }
    if(avt){
        const fd = new FormData();
        fd.append('image',avt)
        data.avatar = avt;
    }
    if(!data.date_of_birth){
        delete data.date_of_birth
    }
    return axios({
        method: "post",
        url: `${api_endpoint}/api/profile`,
        headers: getHeader1(),
        data: {
            ...data
        }
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (response) {
            return response.data;
        });
}
