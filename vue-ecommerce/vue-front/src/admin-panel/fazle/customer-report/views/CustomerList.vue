<script>
import axios from 'axios'

export default {
    data() {
        return {
            customers: [],
            url: this.$store.state.base.url
        }
    },

    methods: {
        getCustomers() {
            axios.get(this.url + 'admin/customer-list')
                .then((result) => {
                    this.customers = result.data.data;
                    console.log(result);
                })
        }
    },

    mounted() {
        this.getCustomers()
    }
}
</script>

<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="mb-0">Customer List</h5>
                </div>
                <!-- <div class="col-auto">
                    <router-link :to="{ name: 'cartAdd' }" class="btn btn-primary btn-lg">Add More</router-link>
                </div> -->
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Bank Info</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(c, i) in customers" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ c.name }}</td>
                        <td>{{ c.email }}</td>
                        <td>{{ c.phone_number }}</td>
                        <td>{{ c.bank_info }}</td>
                        <td>{{ c.address }}</td>
                        <td>
                            <router-link :to="{ name: 'creport', params: { id: c.id } }"
                                class="btn btn-primary">Report</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>