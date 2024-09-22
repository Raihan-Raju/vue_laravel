<template>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Category Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Category's Name</label>
                        <input type="text" v-validate="'email'" class="form-control" v-model="name" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                            <p v-if="nameError" class="error" style="color: crimson;"> 
                                {{ nameError }}
                            </p>
                            

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
                    <h6 class="mb-4">Category List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Category Name</th>
                                <th style="width: 50px;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in list" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
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
            list: [],
            name: '',
            id: 0
        }
    },
    
    watch:{ 
        name:function(){ 
            if(this.name.length >5){ 
                this.nameError="at least 5 cherecter";
            } else { 
                this.nameError="";
            }
        }
    },
    methods: {
        getCategory() {
            axios.get('http://127.0.0.1:8000/api/part1/category')
                .then((res) => {
                    this.list = res.data.data
                    console.log(res.data.data)
                })
        },
        save() {
            axios.post("http://127.0.0.1:8000/api/part1/category/", { name: this.name })
                .then((response) => {
                    this.name
                    this.getCategory()
                    this.name = ""
                    this.id = ""
                });
        },
        showCat(id) {
            this.id = id
            axios.get("http://127.0.0.1:8000/api/part1/category/" + id + '/edit')
                .then((response) => {
                    const d = response.data.data
                    this.name = d.name
                    this.getCategory()
                });
        },
        updateCate() {
            axios.put("http://127.0.0.1:8000/api/part1/category/" + this.id, { name: this.name })
                .then((response) => {
                    console.log(response.status, response.data);
                    this.id = 0;
                    this.name = "";
                    this.getCategory();
                })
                .catch((error) => {
                    console.error("Error updating category:", error);
                });
        },
        deleteCate(id) {
            axios.delete("http://127.0.0.1:8000/api/part1/category/" + id)
            .then(() => {
                console.log("Category deleted successfully.");
                this.getCategory()
            })
            .catch((error)=>{
                console.error("Error deleting category:",error);
            });
        }


    },
    mounted() {
        this.getCategory()
    }
}
</script>