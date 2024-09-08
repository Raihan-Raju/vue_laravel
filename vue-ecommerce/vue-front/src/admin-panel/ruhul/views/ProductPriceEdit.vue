
<script>
import axios from 'axios'

export default {
    data() {
        return {
            products: [],
            product_id: 0,
            buuing_price: 0,
            selling_price: 0,
            id: this.$route.params.id
        }
    },

    methods: {

        getData() {
            axios.get('http://127.0.0.1:8000/api/admin/productprice/create')
                .then((result) => {
                    this.products = result.data.data.product_price;
                    console.log(result.data.data);
                });
        },

        getproductPrice() {
            axios.get("http://127.0.0.1:8000/api/admin/productprice/" + this.id + '/edit')
                .then((response) => {
                    const usep = response.data.data;
                    this.product_id = usep.product_id;
                    this.buying_price = usep.buying_price;
                    this.selling_price = usep.selling_price;
                });
        },

        updateProductPrice() {
            const addData = {
              product_id: this.product_id,
              buying_price: this.buying_price,
              selling_price: this.selling_price,
            }
            
            axios.put("http://127.0.0.1:8000/api/admin/productprice/"+this.id, addData)
            .then((response) => {
                this.$router.push({ name: "product-price-list" })
                console.log(response);
            });
        }

    },

    mounted() {
        this.getData();
        this.getproductPrice();
    }
}

</script>

<template>
  <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Product price edit</h5>
  </div>
  <div class="card-body">
    <div class="mb-3">
            <label class="form-label" for="basic-default-company">Product price</label>
            <select class="form-select" v-model="product_id">
                <option selected>Open this select menu</option>
                <option v-for="(p, i) in products" :key="i" :value="p.id">{{ p.name }}</option>
            </select>
        </div>
    <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Buying price</label>
          <input v-model="buying_price" type="text" class="form-control" id="basic-default-fullname"
              placeholder="" />
      </div>
    <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Selling price</label>
          <input v-model="selling_price" type="text" class="form-control" id="basic-default-fullname"
              placeholder="" />
      </div>
      <button @click="updateProductPrice" type="submit" class="btn btn-primary">Submit</button>
  </div>
</template>