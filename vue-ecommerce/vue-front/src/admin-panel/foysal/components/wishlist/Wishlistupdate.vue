
<script>
import axios from 'axios'

export default {
    data() {
        return {
            products: [],
            users: [],
            user_id: 0,
            product_id: 0,
            id: this.$route.params.id
        }
    },

    methods: {

        getInfo() {
            axios.get('http://127.0.0.1:8000/api/admin/wishlists/create')
                .then((result) => {
                    this.products = result.data.data.products;
                    this.users = result.data.data.users;
                    console.log(result.data.data.users);
                })
        },
           

        getwishlist() {
            axios.get("http://127.0.0.1:8000/api/admin/wishlists/" + this.id + '/edit')
                .then((response) => {
                    const wishlist = response.data.data;
                    this.user_id = wishlist.user_id;
                    this.product_id = wishlist.product_id;
                  
                });
        },

        updatewishlist() {
            const wishlistData = {
                user_id: this.user_id,
                product_id: this.product_id,
                quantity: this.quantity
            }

            axios.put("http://127.0.0.1:8000/api/admin/wishlists/" +this.id, wishlistData)
                .then((response) => {
                    console.log(response);
                    this.$router.push({name:"wishlisttable"})
                });
        }

    },

    mounted() {
        this.getInfo();
        this.getwishlist();
    }
}

</script>


<template>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Wishlist Update</h5>
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
                <option v-for="(p, i) in products" :key="i" :value="p.id">{{ p.name }}</option>
            </select>
        </div>
    
        <button @click="updatewishlist()" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>
