const state = {
    user: {
        name: null,
        email: null,
    }
};
const getters = {
    getUser: (state) => {
        return state.user;
    }
};
const actions = {
    loginApi({commit, rootState}, user) {
        rootState.progressBar = true;
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/api/login', user).then(response => {
                localStorage.setItem('user_token', response.data.login_token);
                axios.get('/api/user', {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer '+ localStorage.getItem('user_token')
                    }
                }).then(response => {
                    commit('setUser', response.data)
                    rootState.progressBar = false;
                })
                rootState.progressBar = false;
                rootState.snackbar = {
                    show: true,
                    text: response.data.message
                }
            }).catch(error => {
                rootState.progressBar = false;
                rootState.snackbar = {
                    show: true,
                    text: error.response.data.message
                }
            })
        });
    },

    userApi({commit, rootState}) {
        rootState.progressBar = true;
        axios.get('/api/user', {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('user_token')
            }
        }).then(response => {
            commit('setUser', response.data)
            rootState.progressBar = false;
        }).catch(error => {
            //
            rootState.progressBar = false;
        })
    },

    logoutApi() {
        axios.get('/sanctum/csrf-cookie').then(r => {
            axios.post('/api/logout', null, {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('user_token')
                }
            }).then(response => {
                localStorage.removeItem('user_token');
                console.log(response)
                window.history.go(0);
            }).catch(error => {
                // console.log(error.response)
            })
        })
    }
};
const mutations = {
    setUser: (state, user) => {
        state.user = user;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
