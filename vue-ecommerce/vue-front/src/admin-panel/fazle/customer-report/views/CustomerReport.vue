<script>
import axios from 'axios'

export default {
    data() {
        return {
            orders: [],
            url: this.$store.state.base.url,
            customerId: this.$route.params.id,
            totalProfit: 0,
            selectedPeriod: 'weekly'
        }
    },

    methods: {
        getOrders() {
            axios.get(`${this.url}admin/customer/report/${this.customerId}/${this.selectedPeriod}`)
                .then((result) => {
                    this.orders = result.data.data;
                    this.calculateTotalProfit();
                })
        },
        calculateTotalProfit() {
            this.totalProfit = this.orders.reduce((total, order) => total + order.total_profit_on_order, 0);
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
                    <h2 class="mb-0" style="font-weight: bold; color: green;"><em>Customer Full Analytic Report</em></h2>
                </div>
                <div class="col-auto">
                    <label for="period" style="font-weight: bold;">Select Period:</label>
                    <select class="form-select" style="width: 200px;" v-model="selectedPeriod" @change="getOrders">
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="annual">Annual</option>
                    </select>
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
                        <th>Order ID</th>
                        <th>Selling Price</th>
                        <th>Buying Price</th>
                        <th>Profit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(o, i) in orders" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ o.id }}</td>
                        <td>{{ o.total_selling_price_on_order }}</td>
                        <td>{{ o.total_buying_price_on_order }}</td>
                        <td>{{ o.total_profit_on_order }}</td>
                        <td>
                            <router-link :to="{ name: 'coreport', params: { id: o.id } }"
                                class="btn btn-primary">Details</router-link>
                        </td>
                    </tr>
                </tbody>
                <tfoot class="">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="fs-5">Total Profit</th>
                        <th class="fs-5">{{ totalProfit }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>