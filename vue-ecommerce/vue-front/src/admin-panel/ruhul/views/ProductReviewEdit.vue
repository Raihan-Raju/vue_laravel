
<script>
import axios from 'axios'

export default {
    data() {
        return {
            products: [],
            users: [],
            content_text: 0,
            rating: 0,
            user_id: 0,
            product_id: 0,
            id: this.$route.params.id
        }
    },

    methods: {

        getInfo() {
            axios.get('http://127.0.0.1:8000/api/admin/productreviews/create')
                .then((result) => {
                    this.users = result.data.data.users;
                    this.products = result.data.data.product_reviews;
                    console.log(this.users);
                })
        },

        getreview() {
            axios.get("http://127.0.0.1:8000/api/admin/productreviews/" + this.id + '/edit')
                .then((response) => {
                    const usep = response.data.data;
                    this.content_text = usep.content_text;
                    this.rating = usep.rating;
                    this.user_id = usep.user_id;
                    this.product_id = usep.product_id;
                });
        },

        updatereview() {
            const addData = {
              content_text: this.content_text,
              rating: this.rating,
              user_id: this.user_id,
              product_id: this.product_id,
            }
            
            axios.put("http://127.0.0.1:8000/api/admin/productreviews/"+this.id, addData)
            .then((response) => {
                this.$router.push({ name: "product-review-list" })
                console.log(response);
            });
        }

    },

    mounted() {
        this.getInfo();
        this.getreview();
    }
}

</script>

<template>
  <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Product review edit</h5>
  </div>
  <div class="card-body">
    <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Content</label>
          <input v-model="content_text" type="text" class="form-control" id="basic-default-fullname"
              placeholder="" />
      </div>
    <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Rating</label>
          <input v-model="rating" type="text" class="form-control" id="basic-default-fullname"
              placeholder="" />
      </div>
      <div class="mb-3">
          <label class="form-label" for="basic-default-email">User</label>
          <select class="form-select" v-model="user_id">
              <option selected>Open this select menu</option>
              <option v-for="(u, i) in users" :key="i" :value="u.id">{{ u.name }}</option>
          </select>
      </div>
      <div class="mb-3">
            <label class="form-label" for="basic-default-company">Product</label>
            <select class="form-select" v-model="product_id">
                <option selected>Open this select menu</option>
                <option v-for="(p, i) in products" :key="i" :value="p.id">{{ p.name }}</option>
            </select>
        </div>
      
      <button @click="updatereview" type="submit" class="btn btn-primary">Submit</button>
  </div>
</template>