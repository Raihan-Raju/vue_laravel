<script>
import axios from 'axios'

export default {
    data() {
        return {
            order: [],
            id: this.$route.params.id
        }
    },

    methods: {
        getOrder() {
            axios.get('http://127.0.0.1:8000/api/admin/orderitems/'+this.id)
                .then((result) => {
                    this.order = result.data.data;
                    console.log(result);
                })
        },
        // deleteCart(id) {
        //     axios.delete("http://127.0.0.1:8000/api/admin/carts/" + id).then(() => {
        //         this.getCarts()
        //     });
        // }
    },

    mounted() {
        this.getOrder()
    }
}
</script>

<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="mb-0">Order List</h5>
                </div>
                <!-- <div class="col-auto">
                    <router-link :to="{ name: 'cartAdd' }" class="btn btn-primary btn-lg">Add More</router-link>
                </div> -->
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Order ID</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(o, i) in order" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ o.product.name }}</td>
                        <td>{{ o.order_id }}</td>
                        <td>{{ o.quantity }}</td>
                        <!-- <td>
                            <router-link :to="{ name: 'cartUpdate', params: { id: c.id } }"
                                class="btn btn-primary">Edit</router-link>
                            <button @click="deleteCart(c.id)" class="btn btn-danger mx-2">Delete</button>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>