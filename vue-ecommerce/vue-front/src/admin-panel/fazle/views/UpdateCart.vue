<script>
import axios from 'axios'

export default {
    data() {
        return {
            products: [],
            users: [],
            user_id: 0,
            product_id: 0,
            quantity: 0,
            id: this.$route.params.id,
            url: this.$store.state.base.url
        }
    },

    methods: {

        getInfo() {
            axios.get(this.url+'admin/carts/create')
                .then((result) => {
                    this.users = result.data.data.users;
                    this.products = result.data.data.products;
                    console.log(this.users);
                })
        },

        getCart() {
            axios.get(this.url+"admin/carts/" + this.id + '/edit')
                .then((response) => {
                    const cart = response.data.data;
                    this.user_id = cart.user_id;
                    this.product_id = cart.product_id;
                    this.quantity = cart.quantity;
                });
        },

        updateCart() {
            const cartData = {
                user_id: this.user_id,
                product_id: this.product_id,
                quantity: this.quantity
            }

            axios.put(this.url+"admin/carts/"+this.id, cartData)
                .then((response) => {
                    console.log(response);
                });
        }

    },

    mounted() {
        this.getInfo();
        this.getCart();
    }
}

</script>


<template>
    <div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Cart Update</h5>
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
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Quantity</label>
            <input v-model="quantity" type="text" class="form-control" id="basic-default-fullname"
                placeholder="John Doe" />
        </div>
        <button @click="updateCart" type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</template>