<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Category/</span>Item</h4>

        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center col">
                        <h5 class="mb-0">Category List</h5>
                    </div>
                    <div class="col-auto">
                        <RouterLink to="/admin/category" class="btn btn-primary"> Add Category</RouterLink>
                    </div>
                    <div class="card-body">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(c, index) in this.categories" :key="index">
                                    <td>{{ c.id }}</td>
                                    <td>{{ c.name }}</td>
                                    <td>
                                        <router-link :to="{ name: 'categoryupdate', params: { id: c.id } }"
                                            class="btn btn-info mr-2">Edit</router-link>
                                        <button type="button" @click="deleteCategory(c.id)"
                                            class="btn btn-danger"> Delete

                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'Category',
    data() {
        return {
            categories: []
        }
    },
    mounted() {

        this.getCategory();
        // console.log('i am here')
    },
    methods: {
        getCategory() {

            axios.get("http://127.0.0.1:8000/api/admin/categorys").then(res => {
                this.categories = res.data.data
                console.log(this.categories)
            })
        },

        deleteCategory(id) {

            if (confirm('are you sure, you want to delete this file?')) {

                axios.delete("http://127.0.0.1:8000/api/admin/categorys/" + id).then(() => {
                    this.getCategory()
                });
            }


        }

    },

}


</script>