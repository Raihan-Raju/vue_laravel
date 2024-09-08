<script>
import axios from 'axios'

export default {
    data() {
        return {
            list: []
        }
    },

    methods: {
        getProductPrice() {
            axios.get('http://127.0.0.1:8000/api/admin/productprice/')
                .then((result) => {
                    this.list = result.data.data;
                    console.log(result.data.data);
                })
        },
        deleteproductPrice(id) {
            axios.delete("http://127.0.0.1:8000/api/admin/productprice/" + id).then(() => {
                this.getProductPrice()
                alert('This fields deleted successfully!');
            });
        },
        update(id){
            this.$router.push(`/admin/product-price/product-price-edit/${id}`)

        }
    },

    mounted(){
    this.getProductPrice()
  },
};
</script>

<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="mb-0"></h5>
                </div>
                <div class="col-auto">
                    <router-link :to="{name: 'product-price-add'}" class="btn btn-primary btn-lg">Add More</router-link>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(c, i) in list" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ c.product.name }}</td>
                        <td>{{ c.buying_price }}</td>
                        <td>{{ c.selling_price }}</td>
                        <td>
                          <button @click="update(c.id)" class="btn btn-info"><i class='bx bxs-edit'></i></button> 
                            &nbsp;
                          <button @click="deleteproductPrice(c.id)" class="btn btn-danger"><i class='bx bxs-trash'></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>