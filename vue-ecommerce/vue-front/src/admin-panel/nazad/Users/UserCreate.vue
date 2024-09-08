<script>
import axios from 'axios';
export default {
    data() {
        return {
            url: this.$store.state.base.url,
            name: "",
            email: "",
            phone_number: "",
            password: "",
            address: "",
            bank_info: "",
            role_id: "",
            image: null
        }
    },
    methods: {

        onFileChange(e) {
            this.image = e.target.files[0];
            console.log(this.image);
        },

        saveContent() {

            const userData = {
                name: this.name,
                email: this.email,
                phone_number: this.phone_number,
                password: this.password,
                address: this.address,
                bank_info: this.bank_info,
                role_id: this.role_id,
            }

            const allData = {
                userData: userData,
                image: this.image
            }

            axios.post('http://127.0.0.1:8000/api/admin/users', allData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    console.log(response);
                    this.$router.push({ name: 'users' });
                });
        }
        
    }

}
</script>

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
                        <form v-on:submit.prevent="saveContent">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Name</label>
                                <input type="text" v-model="name" class="form-control" id="basic-default-fullname"
                                    placeholder="John Doe" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" v-model="email" id="basic-default-email" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe"
                                        aria-describedby="basic-default-email2" />
                                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Phone</label>
                                <input type="text" v-model="phone_number" class="form-control" placeholder="0158" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Password</label>
                                <input type="text" v-model="password" class="form-control" placeholder="0158" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Role</label>
                                <select class="form-control" v-model="role_id" @onchange="this.value">
                                    <option value="">Select one</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Customer</option>
                                    <option value="3">Vendor</option>
                                    <option value="4">Guest</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Address</label>
                                <input type="text" v-model="address" id="basic-default-phone"
                                    class="form-control phone-mask" placeholder="Dhaka" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-message">Bank Info</label>
                                <textarea id="basic-default-message" v-model="bank_info" class="form-control"
                                    placeholder="Inter your bank account and name"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Upload Image</label>
                                <input @change="onFileChange" class="form-control" type="file" id="formFile" />
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>