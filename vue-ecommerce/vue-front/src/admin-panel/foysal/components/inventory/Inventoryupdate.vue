
<script>
import axios from 'axios'

export default {
    data() {
        return {
            products: [],
            product_id: 0,
            quantity: 0,
            id: this.$route.params.id
        }
    },

    methods: {

        getData() {
            axios.get('http://127.0.0.1:8000/api/admin/inventory/create')
                .then((result) => {
                    this.products = result.data.data.product_inventory;
                    console.log(result.data.data);
                });
        },

        getproductInventory() {
            axios.get("http://127.0.0.1:8000/api/admin/inventory/" + this.id + '/edit')
                .then((response) => {
                    const usep = response.data.data;
                    this.product_id = usep.product_id;
                    this.quantity = usep.quantity;
                });
        },

        updateproductInventory() {
            const addData = {
              product_id: this.product_id,
              quantity: this.quantity,
            }
            
            axios.put("http://127.0.0.1:8000/api/admin/inventory/"+this.id, addData)
            .then((response) => {
                this.$router.push({ name: "inventorylist" })
                console.log(response);
            });
        }

    },

    mounted() {
        this.getData();
        this.getproductInventory();
    }
}

</script>

<template>
  <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Product inventory edit</h5>
  </div>
  <div class="card-body">
    <div class="mb-3">
            <label class="form-label" for="basic-default-company">Product inventory</label>
            <select class="form-select" v-model="product_id">
                <option selected>Open this select menu</option>
                <option v-for="(p, i) in products" :key="i" :value="p.id">{{ p.name }}</option>
            </select>
        </div>
    <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Quantity</label>
          <input v-model="quantity" type="text" class="form-control" id="basic-default-fullname"
              placeholder="" />
      </div>
      <button @click="updateproductInventory" type="submit" class="btn btn-primary">Submit</button>
  </div>
</template>