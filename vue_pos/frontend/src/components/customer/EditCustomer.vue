<template>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Customer Update Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">name</label>
                        <input type="text" class="form-control" v-model="name" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <label for="exampleInputEmail1" class="form-label">Customer Type</label>
                        <input type="text" class="form-control" v-model="customer_type" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" v-model="email" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <label for="exampleInputEmail1" class="form-label">Phone</label>
                        <input type="text" class="form-control" v-model="phone" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <label for="exampleInputEmail1" class="form-label">Address</label>
                        <input type="text" class="form-control" v-model="address" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        
                    </div>
                    <button @click="update()" class="btn btn-primary mt-2 active">Update</button>

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
            name: '',
            customer_type: '',
            email: '',
            phone: '',
            address: '',
            id: this.$route.params.id,
            url: "http://127.0.0.1:8000/api/part1/customer",
        }
    },
    methods: {
        update() {
            const allData = {
                customer_type: this.customer_type,
                name: this.name,
                email: this.email,
                phone: this.phone,
                address: this.address,
            };
            axios.put(`${this.url}/${this.id}`, allData)
                .then((response) => {
                    this.$router.push({ name: 'customer' })
                });
        },
        getCustomer() {
            axios.get(`${this.url}/${this.id}/edit`)
                .then((res) => {
                    const d=res.data.data;
                    this.customer_type =d.customer_type
                    this.name =d.teamable.name
                        this.email =d.teamable.email
                        this.phone =d.teamable.phone
                        this.address =d.teamable.address
                        console.log(d)
                });
        },
    },
    mounted() {
        this.getCustomer()
    }
}
</script>