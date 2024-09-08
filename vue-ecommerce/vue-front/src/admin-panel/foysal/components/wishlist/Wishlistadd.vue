<script>
import axios from 'axios'

export default {
    data() {
        return {
            product: [],
            users: [],
            user_id: 0,
            product_id: 0,
        }
    },

    methods: {
        getWishlist() {
            axios.get('http://127.0.0.1:8000/api/admin/wishlists/create')
                .then((result) => {
                    this.product = result.data.data.products;
                    this.users = result.data.data.users;
                    console.log(result.data.data.users);
                })
        },
        storeWishlist() {
            const wishdata = {
                user_id: this.user_id,
                product_id: this.product_id, 
            }

           // console.log(wishdata);

            axios.post("http://127.0.0.1:8000/api/admin/wishlists", wishdata)
                .then((response) => {
                    console.log(response)
                   this.$router.push({name:"wishlisttable"})
                });
               

        }

    },
    mounted() {
        this.getWishlist()
    }
}

</script>

<template>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Name</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="basic-default-email">User</label>
            <select class="form-select" v-model="user_id">
                <option selected>Open this select menu</option>
                <option v-for="(u, i) in users" :key="i" :value="u.id">{{ u.name }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-company">Product</label>
            <select class="form-select" v-model="product_id">
                <option selected>Open this select menu</option>
                <option v-for="(p, i) in product" :key="i" :value="p.id">{{ p.name }}</option>
            </select>
        </div>
        <button @click="storeWishlist()" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>