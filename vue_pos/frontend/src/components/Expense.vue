<template>
     <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Sub Category Form</h6>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Expense Category's Name</label>
                        <select v-model="expense_category_id" class="form-select mb-3" aria-label="Default select example">
                            <option value="0">Choose Expense Category Name</option>
                            <option v-for="(d, i) in expncatList" :key="i" :value="d.id">{{ d.name }}</option>
                        </select>
                        <label for="exampleInputEmail1" class="form-label">Amount</label>
                        <input type="text" class="form-control" v-model="amount" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <label for="exampleInputEmail1" class="form-label">Date</label>
                        <input type="date" class="form-control" v-model="date" id="exampleInputEmail1"
                            aria-describedby="emailHelp" value="date(yyyy-MM-dd)">
                    </div>
                    <button v-if="id == 0" @click="save()" class="btn btn-primary mt-2 active">Save</button>
                    <button v-else @click="updateExpense" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 vh-100">

            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Expense List</h6>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Expense Category Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                                <th style="width: 70px;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-for="(d, i) in expenseList" :key="i">
                            <tr>
                                <td scope="row">{{ i + 1 }}</td>
                                <td>{{d.expense_category.name  }}</td>
                                <td>{{ d.amount }}</td>
                                <td>{{ d.date }}</td>
                                <td width='150px'>
                                    <button @click="editExpense(d.id)" class="btn btn-primary">Edit</button>
                                    <button @click="deleteExpense(d.id)" class="btn btn-danger">Delete</button>
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
import axios from "axios";
export default {
    data() {
        return {
            expense_category_id: 0,
            expncatList: [],
            amount: '',
            date: '',
            id: 0,
            expenseList: [] 
        }
    },
    methods: {
        getExpenseCategory() {
            axios.get('http://127.0.0.1:8000/api/part2/expensecategory')
                .then((result) => {
                    this.expncatList = result.data.data
                    console.log(result.data.data)
                })
        },
        getExpense() {
            axios.get('http://127.0.0.1:8000/api/part2/expense')
                .then((result) => {
                    this.expenseList = result.data.data
                    console.log(result.data.data)
                })
        },
        save() {
            axios.post("http://127.0.0.1:8000/api/part2/expense/", { expense_category_id: this.expense_category_id, amount: this.amount, date: this.date})
                .then((response) => {
                    console.log(response.data.data)
                    this.expense_category_id = '';
                    this.amount = '';
                    this.date = '';
                    this. getExpense();

                });
        },
        editExpense(id) {
            this.id = id
            axios.get("http://127.0.0.1:8000/api/part2/expense/" + id + '/edit').then((response) => {
                const d = response.data.data
                this.expense_category_id = d.expense_category_id
                this.amount = d.amount
                this.date = d.date
                this.getExpense()
            });
        },
        updateExpense() {
            axios.put("http://127.0.0.1:8000/api/part2/expense/" + this.id, { expense_category_id: this.expense_category_id, amount: this.amount, date: this.date }).then((response) => {
                console.log(response.status, response.data);
                this.getExpense()
            });
            this.id = 0
            this.expense_category_id = this.amount = this.date = ''
        },
        deleteExpense(id) {
            axios.delete("http://127.0.0.1:8000/api/part2/expense/" + id).then(() => {
                this.getExpense()
            });
        },
    },
    mounted() {
        this.getExpense()
        this.getExpenseCategory()
    }
}
</script>