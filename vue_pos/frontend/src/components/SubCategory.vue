<template>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Sub Category Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Category Name</label>
                        <select v-model="category_id" class="form-select mb-3" aria-label="Default select example">
                            <option value="0">Choose Category Name</option>
                            <option v-for="(d, i) in mainlist" :key="i" :value="d.id">{{ d.name }}</option>
                        </select>
                        <label for="exampleInputEmail1" class="form-label">Sub Category's Name</label>
                        <input type="text" class="form-control" v-model="name" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <button v-if="id == 0" @click="save()" class="btn btn-primary mt-2 active">Save</button>
                    <button v-else @click="updateCate" class="btn btn-primary">Update</button>

                </div>
            </div>

        </div>
    </div>
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 vh-100">

            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Sub Category List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Sub Category Name</th>
                                <th style="width: 80px;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in sublist" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{ d.category.name }}</td>
                                <td>{{ d.name }}</td>
                                <td width='150px'>
                                    <button @click="showCat(d.id)" class="btn btn-primary">Edit</button>
                                    <button @click="deleteCate(d.id)" class="btn btn-danger">Delete</button>
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
            sublist: [],
            mainlist: [],
            // catname: '',
            name: '',
            category_id: 0,
            id: 0

        }

    },
    methods: {
        getmaincat() {
            axios.get('http://127.0.0.1:8000/api/part1/category')
                .then((res) => {
                    this.mainlist = res.data.data
                    // console.log(res.data.data)
                })
        },
        getCategory() {
            axios.get('http://127.0.0.1:8000/api/part1/sub_category')
                .then((res) => {
                    this.sublist = res.data.data
                    // console.log(res.data.data)
                })
        },
        save() {
            axios.post("http://127.0.0.1:8000/api/part1/sub_category/", { name: this.name, category_id: this.category_id })
                .then((response) => {
                    console.log(response)
                    this.name = '';
                    this.category_id = '';
                    this.getCategory()

                });
        },
        showCat(id) {
            this.id = id
            axios.get("http://127.0.0.1:8000/api/part1/sub_category/" + id + '/edit')
                .then((response) => {
                    console.log(response);
                    const d = response.data.data
                    this.name = d.name
                    this.category_id = d.category_id
                    this.getCategory()

                });
        },
        updateCate() {
            axios.put("http://127.0.0.1:8000/api/part1/sub_category/" + this.id,
                {
                    name: this.name,
                    category_id: this.category_id
                })
                .then((response) => {
                    console.log(response);
                    this.id = 0;
                    this.name = "";
                    this.category_id = "";
                    this.getCategory();
                })
                .catch((error) => {
                    console.error("Error updating subcategory:", error);
                });
        },
        deleteCate(id) {
            axios.delete("http://127.0.0.1:8000/api/part1/sub_category/" + id)
                .then(() => {
                    console.log("Category deleted successfully.");
                    this.getCategory()
                })
                .catch((error) => {
                    console.error("Error deleting subcategory:", error);
                });
        }


    },
    mounted() {
        this.getmaincat()
        this.getCategory()
    }
}
</script>