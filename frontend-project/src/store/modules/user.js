// import { login, getInfo } from '@/api/user'
// import { getToken, removeToken } from '@/utils/auth'
// import router, { resetRouter } from '@/router'

const state = {
  // token: getToken(),
  // name: '',
  // accountName: '',
  // introduction: '',
  // roles: []
}

const mutations = {
  // SET_INTRODUCTION: (state, introduction) => {
  //   state.introduction = introduction
  // },
  // SET_NAME: (state, name) => {
  //   state.name = name
  // },
  // SET_AccountName: (state, accountName) => {
  //   state.accountName = accountName
  // },
  // SET_ROLES: (state, roles) => {
  //   state.roles = roles
  // }
}

const actions = {
  // user login
  // login({ commit }, [userInfo, message]) {
  //   const { username, password } = userInfo
  //   return new Promise((resolve, reject) => {
  //     const formData = new FormData()
  //     formData.append('account', username.trim())
  //     formData.append('password', password)
  //     login(formData).then(response => {
  //       if (response.data.success) {
  //         // setToken(response.data.content.token)
  //         resolve()
  //       } else {
  //         message.error(response.data.msg)
  //         reject()
  //       }
  //     }).catch(error => {
  //       reject(error)
  //     })
  //   })
  // },

  // // get user info
  // getInfo({ commit, state }) {
  //   return new Promise((resolve, reject) => {
  //     getInfo().then(response => {
  //       const { data } = response
  //       if (data.success) {
  //         const { content } = data
  //         const roles = [content.roles]
  //         const accountName = [content.accountName]
  //         const introduction = 'I am a super administrator'
  //         // roles must be a non-empty array
  //         if (!roles || roles.length <= 0) {
  //           reject('getInfo: roles must be a non-null array!')
  //         }

  //         commit('SET_ROLES', content.roles)
  //         commit('SET_NAME', content.role)
  //         commit('SET_AccountName', content.accountName)
  //         commit('SET_INTRODUCTION', introduction)
  //         const newData = {
  //           roles,
  //           accountName,
  //           introduction
  //         }
  //         resolve(newData)
  //       } else {
  //         removeToken()
  //       }
  //     }).catch(error => {
  //       reject(error)
  //     })
  //   })
  // },

  // // user logout
  // logout({ commit, state, dispatch }) {
  //   return new Promise((resolve, reject) => {
  //     // logout(getToken()).then(() => {
  //     //   commit('SET_ROLES', [])
  //     //   removeToken()
  //     //   resetRouter()

  //     //   // reset visited views and cached views
  //     //   // to fixed https://github.com/PanJiaChen/vue-element-admin/issues/2485
  //     //   dispatch('tagsView/delAllViews', null, { root: true })

  //     //   resolve()
  //     // }).catch(error => {
  //     //   reject(error)
  //     // })
  //     commit('SET_ROLES', [])
  //     removeToken()
  //     resetRouter()

  //     // reset visited views and cached views
  //     // to fixed https://github.com/PanJiaChen/vue-element-admin/issues/2485
  //     dispatch('tagsView/delAllViews', null, { root: true })
  //     resolve()
  //   })
  // },

  // // remove token
  // resetToken({ commit }) {
  //   return new Promise(resolve => {
  //     commit('SET_ROLES', [])
  //     removeToken()
  //     resolve()
  //   })
  // },

  // // dynamically modify permissions
  // async changeRoles({ commit, dispatch }, role) {
  //   // const token = role + '-token'

  //   // setToken(token)

  //   const { roles } = await dispatch('getInfo')

  //   resetRouter()

  //   // generate accessible routes map based on roles
  //   const accessRoutes = await dispatch('permission/generateRoutes', roles, { root: true })
  //   // dynamically add accessible routes
  //   router.addRoutes(accessRoutes)

  //   // reset visited views and cached views
  //   dispatch('tagsView/delAllViews', null, { root: true })
  // }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
