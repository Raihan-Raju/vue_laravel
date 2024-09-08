<script>
import axios from "axios";
export default {
  data() {
    return {
      url: "http://127.0.0.1:8000/api/admin/cupons",
      code: "",
      percentage: "",
      valid_from: "",
      valid_to: "",
      max_uses: "",
      use_count: "",
      id: this.$route.params.id,
      selectedDate:"",
    };
  },
  methods: {
    getcupons(id) {
      axios.get(`${this.url}/${id}/edit`).then((result) => {
        this.code = result.data.data.code;
        this.percentage = result.data.data.percentage;
        this.valid_from = result.data.data.valid_from;
        this.valid_to = result.data.data.valid_to;
        this.max_uses = result.data.data.max_uses;
        this.use_count = result.data.data.use_count;
        this.id = result.data.data.id;
      });
    },
    save() {
      axios
        .put(this.url + "/" + this.$route.params.id, {
          code: this.code,
          percentage: this.percentage,
          valid_from: this.valid_from,
          valid_to: this.valid_to,
          max_uses: this.max_uses,
          use_count: this.use_count,
        })
        .then(
          (response) => {
            console.log(response);
            this.$router.push({ name: "couponsshow" })
          },
          (error) => {
            console.log(error);
          }
        );
      //console.log(this.url + "/" + this.$route.params.id);
    }
  },
  mounted() {
    const id = this.$route.params.id;
    this.getcupons(id);

  },
};
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Cupons/</span> update
    </h4>

    <!-- Basic Layout -->
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-body">
          <form v-on:submit.prevent="save">
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Code</label>
              <input type="text" v-model="code" class="form-control"  placeholder="code" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Percentage</label>
              <input type="text" v-model="percentage" class="form-control" 
                placeholder="30%" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Valid_from</label>
              <input type="datetime" v-model="valid_from" class="form-control" 
                placeholder="valid_from" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Valid_to</label>
              <input type="datetime" v-model="valid_to" class="form-control" 
                placeholder="valid_to" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">max_uses</label>
              <input type="number" v-model="max_uses" class="form-control" 
                placeholder="max_uses" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">use_count</label>
              <input type="number" v-model="use_count" class="form-control" 
                placeholder="use_count" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>