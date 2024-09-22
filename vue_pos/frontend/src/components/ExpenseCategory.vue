<template>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Expense Category Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Expense Category's Name</label>
                        <input type="text" class="form-control" v-model="expensecat" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <button v-if="id == 0" @click="save" class="btn btn-primary mt-2 active">Save</button>
                    <button v-else @click="updateExpensecat" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 vh-100">

            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Expense Category's List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Expense Category's Name</th>
                                <th style="width: 80px;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in list" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{ d.name }}</td>
                                <td width='150px'>
                                    <button @click="editExpensecat(d.id)" class="btn btn-primary">Edit</button>
                                    <button @click="deleteExpensecat(d.id)" class="btn btn-danger">Delete</button>
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
            expensecat: '',
            id: 0
        }
    },
    methods: {
        allExpensecat() {
            axios.get('http://127.0.0.1:8000/api/part2/expensecategory')
                .then((result) => {
                    this.list = result.data.data
                    //console.log(result.data.data)
                })
        },

        save() {
            axios.post("http://127.0.0.1:8000/api/part2/expensecategory", { name: this.expensecat }).then((response) => {
                this.expensecat = ''
                this.allExpensecat()
            });
        },

        editExpensecat(id) {
            this.id = id
            axios.get("http://127.0.0.1:8000/api/part2/expensecategory/" + id + '/edit').then((response) => {
                const d = response.data.data
                this.expensecat = d.name
                this.allExpensecat()
                console.log(response.data.data);
            });
        },

        updateExpensecat() {
            axios.put("http://127.0.0.1:8000/api/part2/expensecategory/" + this.id, { name: this.expensecat}).then((response) => {
                console.log(response.status, response.data);
                this.allExpensecat()
            });
            this.id = 0
            this.expensecat = ''
        },

        deleteExpensecat(id) {
            axios.delete("http://127.0.0.1:8000/api/part2/expensecategory/" + id).then(() => {
                this.allExpensecat()
            });
        },
    },
    mounted() {
        this.allExpensecat()
    }
}
</script>