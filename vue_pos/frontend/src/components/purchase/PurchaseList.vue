<template>
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4 vh-100">
        <div class="row g-4 vh-100">
            <div class="col-12">
                <router-link class="btn btn-primary" :to="{name:'addEmployee'}">add Purchase</router-link>
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Purchase List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Category</th>
                                <th scope="col">Sub Category</th>
                                <th  scope="col">Brand</th>
                                <th  scope="col">Product</th>
                                <th  scope="col">Unit</th>
                                <th  scope="col">Price</th>
                                <th  scope="col">Quantity</th>
                                <th  scope="col">Total Price</th>
                                <th  scope="col">Payment</th>
                                <th  scope="col">Date</th>
                                <th  scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in purchaseList" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{ d.invoice_id }}</td>
                                <td>{{ d.position }}</td>
                                <td>{{ d.joining_date}}</td>
                                <td>{{ d.teamable.email }}</td>
                                <td>{{ d.teamable.phone }}</td>
                                <td>{{ d.teamable.address }}</td>
                                <td width='150px'>
                                    <button @click="showPurchase(d.id)" class="btn btn-primary">Edit</button>
                                    <button @click="deleteEmployee(d.id)" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Table End -->
</template>
<script>
import axios from 'axios';
// import EditProduct from './EditProduct.vue';
export default {
    data() {
        return {
            purchaseList: [],
            id:0,
        }
    },
    methods: {
        getPurchase() {
            axios.get('http://127.0.0.1:8000/api/part1/purchase')
                .then((res) => {
                    this.purchaseList = res.data.data
                    // console.log(res.data.data)
                });
        },
        showPurchase(id){
            this.$router.push({name:'editemployee',params: { id: id }})
        },
        deleteEmployee(id){
            axios.delete("http://127.0.0.1:8000/api/part1/purchase/" + id)
            .then(() => {
                console.log("Purchase deleted successfully.");
                this.getPurchase()
            })
            .catch((error)=>{
                console.error("Error deleting Purchase:",error);
            });
        }
    },
    mounted() {
        this.getPurchase()
    }
}
</script>