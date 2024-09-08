<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Users Form</h5>
                        <small class="text-muted float-end">Default label</small>
                    </div>
                    <div class="card-body">
                        <form v-on:submit.prevent="save">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Name</label>
                                <input type="text" v-model="name" class="form-control" id="basic-default-fullname"
                                    placeholder="John Doe" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Phone</label>
                                <input type="text" v-model="phone_number" class="form-control"
                                    placeholder="0158" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Role</label>
                                <select class="form-control" v-model="role_id" @onchange="this.value" >
                                    <option value="">Select one</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Customer</option>
                                    <option value="3">Guest</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Address</label>
                                <input type="text" v-model="address" id="basic-default-phone" class="form-control phone-mask"
                                    placeholder="Dhaka" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-message">Bank Info</label>
                                <textarea id="basic-default-message" v-model="bank_info" class="form-control"
                                    placeholder="Inter your bank account and name"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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
            url: 'http://localhost:8000/api/admin/users',
            name: "",
            phone_number: "",
            address: "",
            bank_info: "",
            role_id: "",
        }
    },
    methods: {
        getUserList(id) {
            axios.get(`${this.url}/${id}/edit`)
                .then((result) => {
                    this.name = result.data.data.name
                    this.email = result.data.data.email
                    this.phone_number = result.data.data.phone_number
                    this.address = result.data.data.address
                    this.bank_info = result.data.data.bank_info
                    this.role_id = result.data.data.role_id
                });
        },
        save() {
            axios.put(`${this.url}/${this.$route.params.id}`, {
                     name:this.name,
                     phone_number:this.phone_number,
                     address:this.address,
                     bank_info:this.bank_info,
                     role_id: this.role_id,
            })
                .then((response) => {
                    this.$router.push('/admin/users');
                }, (error) => {
                    console.log(error);
                });
        },
    },
    mounted() {
        const id = this.$route.params.id;
        this.getUserList(id)
    },
}
</script>