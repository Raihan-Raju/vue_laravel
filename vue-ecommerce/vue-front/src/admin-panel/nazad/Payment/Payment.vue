<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Basic Layout</h5>
                        <small class="text-muted float-end">Default label</small>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <h2>Payment Table</h2>
                            <div><RouterLink class="btn btn-primary" :to="{name:'paymentcreate'}">Add Payment</RouterLink></div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Sl</th>
                                            <th>Date</th>
                                            <th>Method</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Order Id</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data, k) in list" :key="k">
                                            <td>{{++k}}</td>
                                            <td>{{ data.date }}</td>
                                            <td>{{ data.method }}</td>
                                            <td>{{ data.amount }}</td>
                                            <td>{{ data.status }}</td>
                                            <td>{{ data.order_id }}</td>
                                            <td>
                                                <button class="btn btn-primary" @click="update(data.id)">Edit</button>
                                                <button class="btn btn-danger" @click="deletePayment(data.id)">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            url: 'http://localhost:8000/api/admin/payments',
            list:'',

        }
    },
    methods: {
        getPaymentList() {
            axios.get(this.url)
                .then((result) => {
                    this.list = result.data.data
                    
                   console.log(result.data.data)

                });
        },
        update(id) {
            this.$router.push({path:'/admin/paymentedit/'+id});
        },
        async deletePayment(id) {
            try {
                await axios.delete(`${this.url}/${id}`);
                this.getPaymentList(); // Call getIncomeList after successful deletion
            } catch (error) {
                console.error("Error deleting User:", error);
                // Handle error as needed (show user message, etc.)
            }
        }

    },
    mounted() {
        this.getPaymentList()
    },
}
</script>