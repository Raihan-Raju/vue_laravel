<template>
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4 vh-100">
        <div class="row g-4 vh-100">
            <div class="col-12">
                <router-link class="btn btn-primary" :to="{name:'addEmployee'}">add Employee</router-link>
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Employee List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Joining Date</th>
                                <th scope="col">Email</th>
                                <th  scope="col">Phone</th>
                                <th  scope="col">Address</th>
                                <th  scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in employeeList" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{ d.teamable.name }}</td>
                                <td>{{ d.position }}</td>
                                <td>{{ d.joining_date}}</td>
                                <td>{{ d.teamable.email }}</td>
                                <td>{{ d.teamable.phone }}</td>
                                <td>{{ d.teamable.address }}</td>
                                <td width='150px'>
                                    <button @click="showEmployee(d.id)" class="btn btn-primary">Edit</button>
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
            employeeList: [],
            id:0,
        }
    },
    methods: {
        getEmployee() {
            axios.get('http://127.0.0.1:8000/api/part1/employee')
                .then((res) => {
                    this.employeeList = res.data.data
                    // console.log(res.data.data)
                });
        },
        showEmployee(id){
            this.$router.push({name:'editemployee',params: { id: id }})
        },
        deleteEmployee(id){
            axios.delete("http://127.0.0.1:8000/api/part1/employee/" + id)
            .then(() => {
                console.log("Category deleted successfully.");
                this.getEmployee()
            })
            .catch((error)=>{
                console.error("Error deleting category:",error);
            });
        }
    },
    mounted() {
        this.getEmployee()
    }
}
</script>