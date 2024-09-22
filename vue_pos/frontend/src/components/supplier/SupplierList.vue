<template>
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4 vh-100">
        <div class="row g-4 vh-100">
            <div class="col-12">
                <router-link class="btn btn-primary" :to="{name:'addsupplier'}">add Supplier</router-link>
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Supplier List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Contact Person</th>
                                <th scope="col">Company Name</th>
                                <th scope="col">Email</th>
                                <th  scope="col">Phone</th>
                                <th  scope="col">Address</th>
                                <th  scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in supplierList" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{ d.teamable.name }}</td>
                                <td>{{ d.company_name }}</td>
                                <td>{{ d.teamable.email }}</td>
                                <td>{{ d.teamable.phone }}</td>
                                <td>{{ d.teamable.address }}</td>
                                <td width='150px'>
                                    <button @click="showSupplier(d.id)" class="btn btn-primary">Edit</button>
                                    <button @click="deleteSupplier(d.id)" class="btn btn-danger">Delete</button>
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
            supplierList: [],
            id:0,
        }
    },
    methods: {
        getSupplier() {
            axios.get('http://127.0.0.1:8000/api/part2/supplier')
                .then((res) => {
                    this.supplierList = res.data.data
                    // console.log(res.data.data)
                });
        },
        showSupplier(id){
            this.$router.push({name:'editsupplier',params: { id: id }})
        },
        deleteSupplier(id){
            axios.delete("http://127.0.0.1:8000/api/part2/supplier/" + id)
            .then(() => {
                console.log("Category deleted successfully.");
                this.getSupplier()
            })
            .catch((error)=>{
                console.error("Error deleting category:",error);
            });
        }
    },
    mounted() {
        this.getSupplier()
    }
}
</script>