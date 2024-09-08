<script>
import axios from 'axios'

export default {
    data() {
        return {
            list: []
        }
    },

    methods: {
        getCupons() {
            axios.get('http://127.0.0.1:8000/api/admin/cupons')
                .then((result) => {
                    this.list = result.data.data;
                    console.log(result.data.data);
                })
        },
        deletecupons(id) {
            axios.delete("http://127.0.0.1:8000/api/admin/cupons/" + id).then(() => {
                this.getCupons();
                alert('Coupon deleted successfully!');
            });
        },
        update(id) {
            this.$router.push(`/admin/coupons/coupons-update/${id}`)

        }

    },

    mounted() {
        this.getCupons()
    },
};
</script>

<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="mb-0">Cupons List</h5>
                </div>
                <div class="col-auto">
                    <router-link :to="{ name: 'couponsAdd' }" class="btn btn-primary btn-lg">Add More</router-link>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Code</th>
                        <th>Percentage</th>
                        <th>Valid From</th>
                        <th>Valid To</th>
                        <th>Max uses</th>
                        <th>Use Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(c, i) in list" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ c.code }}</td>
                        <td>{{ c.percentage }}</td>
                        <td>{{ c.valid_from }}</td>
                        <td>{{ c.valid_to }}</td>
                        <td>{{ c.max_uses }}</td>
                        <td>{{ c.use_count }}</td>
                        <td>
                            <button @click="update(c.id)" class="btn btn-success" @onclick="refresh"><i class='bx bxs-edit'></i></button>
                            &nbsp;
                            <button @click="deletecupons(c.id)" class="btn btn-danger"><i class='bx bxs-trash'></i></button>
                        </td>
                        <!-- <td>
                            <router-link :to="{ name: 'cartUpdate', params: { id: c.id } }" class="btn btn-info mr-2">Edit</router-link>
                            <button @click="deleteCupons(c.id)" class="btn btn-danger">Delete</button>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>