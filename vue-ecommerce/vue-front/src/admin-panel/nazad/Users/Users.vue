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
                            <h2>Users Table</h2>
                            <div>
                                <RouterLink class="btn btn-primary" :to="{ name: 'usercreate' }">Add Users</RouterLink>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Bank info</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data, k) in list" :key="k">
                                            <td>{{ ++k }}</td>
                                            <td>{{ data.name }}</td>
                                            <td>
                                                <img :src="`http://127.0.0.1:8000/photos/users/${data.photo ? data.photo.path : 'no-image.jpg'}`"
                                                    class="img-fluid rounded" alt="user-image" />
                                            </td>
                                            <td>{{ data.email }}</td>
                                            <td>{{ data.address }}</td>
                                            <td>{{ data.bank_info }}</td>
                                            <td>{{ data.phone_number }}</td>
                                            <td>{{
                                                data.role_id === 1 ? "Admin" :
                                                    data.role_id === 2 ? "Customer" :
                                                        data.role_id === 3 ? "Vendor" :
                                                            data.role_id === 4 ? "Guest" :
                                                                ""
                                            }}</td>
                                            <td>
                                                <button class="btn btn-primary" @click="update(data.id)">Edit</button>
                                                <button class="btn btn-danger"
                                                    @click="deleteUser(data.id)">Delete</button>
                                            </td>
                                        </tr>
                                        <!-- Add more rows for additional products -->
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
            url: 'http://localhost:8000/api/admin/users',
            list: '',

        }
    },
    methods: {
        getUserList() {
            axios.get(this.url)
                .then((result) => {
                    this.list = result.data.data

                    //    console.log(result.data.data)

                });
        },
        update(id) {
            this.$router.push({ path: '/admin/useredit/' + id });
        },
        async deleteUser(id) {
            try {
                await axios.delete(`${this.url}/${id}`);
                this.getUserList(); // Call getIncomeList after successful deletion
            } catch (error) {
                console.error("Error deleting User:", error);
                // Handle error as needed (show user message, etc.)
            }
        }

    },
    mounted() {
        this.getUserList()
    },
}
</script>