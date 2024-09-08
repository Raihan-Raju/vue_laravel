<script>
import axios from 'axios'

export default {
    data() {
        return {
            orders: []
        }
    },

    methods: {
        getOrders() {
            axios.get('http://127.0.0.1:8000/api/admin/orders')
                .then((result) => {
                    this.orders = result.data.data;
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
        this.getOrders()
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
                        <th>Order ID</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>User ID</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(o, i) in orders" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ o.id }}</td>
                        <td>{{ o.total_price }}</td>
                        <td>{{ o.order_date }}</td>
                        <td>{{ [o.user_id] }} {{ o.user.name }}</td>
                        <td>
                            <router-link :to="{ name: 'order-details', params: { id: o.id } }"
                                class="btn btn-primary">View</router-link>
                            <!-- <button @click="deleteCart(c.id)" class="btn btn-danger mx-2">Delete</button> -->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>