<script>
import axios from 'axios'

export default {
    data() {
        return {
            items: [],
            url: this.$store.state.base.url,
            orderId: this.$route.params.id,
            totalProfit: 0,
        }
    },

    methods: {
        getOrders() {
            axios.get(`${this.url}admin/customer/oreport/${this.orderId}`)
                .then((result) => {
                    this.items = result.data.data;
                    console.log(result);
                    this.calculateTotalProfit();
                })
        },
        calculateTotalProfit() {
            this.totalProfit = this.items.reduce((total, item) => total + item.profit, 0);
        }
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
                    <h2 class="mb-0" style="font-weight: bold; color: green;"><em>Order Details Report</em></h2>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Buying Price</th>
                        <th>Profit</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(d, i) in items" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ d.product.name }}</td>
                        <td>{{ d.quantity }}</td>
                        <td>{{ d.selling_price }}৳</td>
                        <td>{{ d.buying_price }}৳</td>
                        <td>{{ d.profit }}৳</td>
                    </tr>
                </tbody>
                <tfoot class="">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="fs-5">Total Profit</th>
                        <th class="fs-5">{{ totalProfit }}৳</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>