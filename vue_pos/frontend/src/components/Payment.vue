<template>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Payment Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Payment's Name</label>
                        <input type="text" class="form-control" v-model="method" id="exampleInputEmail1"
                            aria-describedby="emailHelp">

                    </div>
                    <button v-if="id == 0" @click="save()" class="btn btn-primary mt-2 active">Save</button>
                    <button v-else @click="updatePayment" class="btn btn-primary">Update</button>

                </div>
            </div>

        </div>
    </div>
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 vh-100">

            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Payment List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Payment Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in list" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{ d.method }}</td>
                                <td width="150px">
                                    <button @click="showPayment(d.id)" class="btn btn-primary">Edit</button>
                                    <button @click="deletePayment(d.id)" class="btn btn-danger">Delete</button>
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
export default {
    data() {
        return {
            list: [],
            method: '',
            id: 0
        }
    },
    methods: {
        getPayment() {
            axios.get('http://127.0.0.1:8000/api/part3/payment')
                .then((res) => {
                    this.list = res.data.data
                    console.log(res.data.data)
                })
        },
        save() {
            axios.post("http://127.0.0.1:8000/api/part3/payment", {method: this.method })
                .then((response) => {
                    this.method
                    this.getPayment()
                    this.method = ""
                    console.log(response)
                  
                });
        },
        showPayment(id) {
            this.id = id
            axios.get("http://127.0.0.1:8000/api/part3/payment/" + id + '/edit')
                .then((response) => {
                    const d = response.data.data
                    this.method = d.method
                    this.getPayment()
                });
        },
        updatePayment() {
            axios.put("http://127.0.0.1:8000/api/part3/payment/" + this.id, { method: this.method })
                .then((response) => {
                    console.log(response.status, response.data);
                    this.getPayment();
                    this.id = 0
                    this.name = ""
                })
                .catch((error) => {
                    console.error("Error updating payment:", error);
                });
        },
        deletePayment(id) {
            axios.delete("http://127.0.0.1:8000/api/part3/payment/" + id)
            .then(() => {
                console.log("Payment deleted successfully.");
                this.getPayment()
            })
            .catch((error)=>{
                console.error("Error deleting payment:",error);
            });
        }


    },
    mounted() {
        this.getPayment()
    }
}
</script>