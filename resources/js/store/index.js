// store.js
import 'izitoast/dist/css/iziToast.min.css';
import iziToast from 'izitoast/dist/js/iziToast.min.js';
import { createStore } from 'vuex'

export default createStore({
  state() {
    return {
      cart: [],
      cartCount:0,
      Products:[],
      totalMount:0,
      totalPoint:0
    }
  },
  mutations: {
    addToCart(state, item) {
      state.cart.push(item)
    },
    countsCart(state,count){
      state.cartCount = count
    },
    setProducts(state,product){
      state.Products = product
    },
    setTotalMount(state,total){
      state.totalMount = total
    },
    setTotalPoint(state,points){
      state.totalPoint = points
    }
  },
  actions: {
    async addToCart({ commit }, item) {
      try {
        await axios.post('/api/add/product/'+item.uuid,{user:item.user})
       this.dispatch('countCart',JSON.parse(item.user).id)
       iziToast.success({
           message: 'Producto agregado.',
           position: 'topRight',
           timeout: 1500,
       });
      } catch (error) {
        if(error.response.status === 401){
          return iziToast.error({
            message: error.response.data.message,
            position: 'topRight',
            timeout: 1500,
        });
        }
        window.location.href='/login/doctor'
        console.log(error)
      }
    },
    async countCart({commit},item){
      try {
        const {data} = await axios.get('/api/info/cart/'+ item)
        commit('countsCart',data.countProduct)
        commit('setTotalMount',data.totalMount)
        commit('setTotalPoint',data.totalPoint)
      } catch (error) {
        console.log(error)
      }
    },
    async getInfoCart({ commit }, user){
      try {
        const {data} = await axios.get('/api/catalog/products/'+user)
        commit('setProducts',data)
      } catch (error) {
        console.log(error)
      }
    }
  },
  getters: {
    cartTotal(state) {
      return state.cart.reduce((total, item) => total + item.price, 0)
    }
  }
})
