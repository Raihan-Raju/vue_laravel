<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="mb-0">Sub Category List</h5>
                </div>
                <div class="col-auto">
                    <router-link :to="{ name: 'sub_add' }" class="btn btn-primary btn-lg">Add More</router-link>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category_id</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sub_categorys, index) in this.sub_categorys" :key="index">
                        <td>{{ sub_categorys.id }}</td>
                        <td>{{ sub_categorys.name }}</td>
                        <td>{{ sub_categorys.category ? sub_categorys.category.name : "no data" }}
                        </td>
                        <td>
                            <router-link :to="{ name: 'sub_update', params: { id: sub_categorys.id } }" class="btn btn-info mr-2">Edit</router-link>
                            <button type="button" @click="deleteSub_categorys(sub_categorys.id)" class="btn btn-danger">
                                Delete </button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    name: 'sub_categorys',
    data() {
        return {
            sub_categorys: []
        }
    },

    methods: {
        getsubcategorys() {
            axios.get("http://127.0.0.1:8000/api/admin/subcategorys").then((res) => {
                this.sub_categorys = res.data.data;
                console.log(this.subcategorys);
            })
        },
        deleteSub_categorys(id) {

            if (confirm('are you sure, you want to delete this file?')) {

                axios.delete("http://127.0.0.1:8000/api/admin/subcategorys/" + id).then(() => {
                    this.getsubcategorys()
                });
            }
        }
    },

    mounted() {

        this.getsubcategorys();
    }
}

</script>