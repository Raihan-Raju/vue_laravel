import { createStore } from 'vuex'
import cart from './cart.js';
import createPersistedState from 'vuex-persistedstate';
import base from './base.js';
import auth from './auth.js';

// Create a new store instance.
const store = createStore(
    {
        modules:{
            cart,
            base,
            auth
        },
        plugins:[
            createPersistedState(
                {
                    storage:window.sessionStorage
                }
            )
        ]
    }
)
export default store