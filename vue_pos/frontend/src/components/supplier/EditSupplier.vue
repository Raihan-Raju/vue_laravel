<template>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Supplier Update Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Contact Person</label>
                        <input type="text" class="form-control" v-model="name" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <label for="exampleInputEmail1" class="form-label">company Name</label>
                        <input type="text" class="form-control" v-model="company_name" id="exampleInputEmail1"
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
                    <button @click="updateSupplier()" class="btn btn-primary mt-2 active">Update</button>

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
            company_name: '',
            email: '',
            phone: '',
            address: '',
            id: this.$route.params.id,
            url: "http://127.0.0.1:8000/api/part2/supplier",
        }
    },
    methods: {
        updateSupplier() {
            const allData={
            name:this.name,
            company_name:this.company_name,
            email:this.email,
            phone:this.phone,
            address:this.address,
        };
            axios.put(`${this.url}/${this.id}`, allData)
                .then((response) => {
                        console.log(response);
                    this.$router.push({ name: 'supplier' })
                });
        },
        getSupplier() {
            axios.get(`${this.url}/${this.id}/edit`)
                .then((res) => {
                    const d=res.data.data;
                    this.name =d.teamable.name
                        this.company_name =d.company_name
                        this.email =d.teamable.email
                        this.phone =d.teamable.phone
                        this.address =d.teamable.address
                        console.log(d)
                });
        },
    },
    mounted(){
        this.getSupplier()
    }
}
</script>