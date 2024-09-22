<template>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Unit Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Unit's Name</label>
                        <input type="text" class="form-control" v-model="name" id="exampleInputEmail1"
                            aria-describedby="emailHelp">

                    </div>
                    <button v-if="id == 0" @click="save()" class="btn btn-primary mt-2 active">Save</button>
                    <button v-else @click="updateUnit" class="btn btn-primary">Update</button>

                </div>
            </div>

        </div>
    </div>
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 vh-100">

            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Unit List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Unit Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in list" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{ d.name }}</td>
                                <td width="150px">
                                    <button @click="showUni(d.id)" class="btn btn-primary">Edit</button>
                                    <button @click="deleteUnit(d.id)" class="btn btn-danger">Delete</button>
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
    methods: {
        getUnit() {
            axios.get('http://127.0.0.1:8000/api/part3/unit')
                .then((res) => {
                    this.list = res.data.data
                    console.log(res.data.data)
                })
        },
        save() {
            axios.post("http://127.0.0.1:8000/api/part3/unit", {name: this.name })
                .then((response) => {
                    this.name
                    this.getUnit()
                    this.name = ""
                    console.log(response)
                  
                });
        },
        showUni(id) {
            this.id = id
            axios.get("http://127.0.0.1:8000/api/part3/unit/" + id + '/edit')
                .then((response) => {
                    const d = response.data.data
                    this.name = d.name
                    this.getUnit()
                });
        },
        updateUnit() {
            axios.put("http://127.0.0.1:8000/api/part3/unit/" + this.id, { name: this.name })
                .then((response) => {
                    console.log(response.status, response.data);
                    this.id = 0;
                    this.name = "";
                    this.getUnit();
                })
                .catch((error) => {
                    console.error("Error updating unit:", error);
                });
        },
        deleteUnit(id) {
            axios.delete("http://127.0.0.1:8000/api/part3/unit/" + id)
            .then(() => {
                console.log("Unit deleted successfully.");
                this.getUnit()
            })
            .catch((error)=>{
                console.error("Error deleting unit:",error);
            });
        }


    },
    mounted() {
        this.getUnit()
    }
}
</script>