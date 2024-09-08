<script>
import axios from 'axios'

export default {
    data() {
        return {
            list: []
        }
    },

    methods: {
        getProductReviews() {
            axios.get('http://127.0.0.1:8000/api/admin/productreviews/')
                .then((result) => {
                    this.list = result.data.data;
                    console.log(result.data.data);
                })
        },
        deletecupons(id) {
            axios.delete("http://127.0.0.1:8000/api/admin/productreviews/" + id).then(() => {
                this.getProductReviews()
                alert('This fields deleted successfully!');
            });
        },
        update(id){
            this.$router.push(`/admin/product-review/product-review-edit/${id}`)

        }
    },

    mounted(){
    this.getProductReviews()
  },
};
</script>

<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="mb-0">Product Review List</h5>
                </div>
                <div class="col-auto">
                    <router-link :to="{name: 'product-review-add'}" class="btn btn-primary btn-lg">Add More</router-link>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Content</th>
                        <th>Rating</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(c, i) in list" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ c.content_text }}</td>
                        <td>{{ c.rating }}</td>
                        <td>{{ c.user.name }}</td>
                        <td>{{ c.product.name }}</td>
                        <td>
                          <button @click="update(c.id)" class="btn btn-info"><i class='bx bxs-edit'></i></button> 
                            &nbsp;
                          <button @click="deletecupons(c.id)" class="btn btn-danger"><i class='bx bxs-trash'></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>