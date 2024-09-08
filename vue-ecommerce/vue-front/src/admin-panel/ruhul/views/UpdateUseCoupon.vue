<script>
import axios from 'axios'

export default {
    data() {
        return {
            coupons: [],
            users: [],
            user_id: 0,
            cupon_id: 0,
            usage_count: 0,
            id: this.$route.params.id
        }
    },

    methods: {

        getInfo() {
            axios.get('http://127.0.0.1:8000/api/admin/couponusages/create')
                .then((result) => {
                    this.users = result.data.data.users;
                    this.coupons = result.data.data.ruhul;
                    console.log(this.users);
                })
        },

        getcoupon() {
            axios.get("http://127.0.0.1:8000/api/admin/couponusages/" + this.id + '/edit')
                .then((response) => {
                    const usec = response.data.data;
                    this.user_id = usec.user_id;
                    this.cupon_id = usec.cupon_id;
                    this.usage_count = usec.usage_count;
                });
        },

        updateUseCount() {
            const addData = {
                user_id: this.user_id,
                cupon_id: this.cupon_id,
                usage_count: this.usage_count
            }
            
            axios.put("http://127.0.0.1:8000/api/admin/couponusages/"+this.id, addData)
            .then((response) => {
                this.$router.push({ name: "couponsUselist" })
                console.log(response);
            });
        }

    },

    mounted() {
        this.getInfo();
        this.getcoupon();
    }
}

</script>

<template>
  <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Usage Coupons Update</h5>
  </div>
  <div class="card-body">
      <div class="mb-3">
          <label class="form-label" for="basic-default-email">User</label>
          <select class="form-select" v-model="user_id">
              <option selected>Open this select menu</option>
              <option v-for="(u, i) in users" :key="i" :value="u.id">{{ u.name }}</option>
          </select>
      </div>
      <div class="mb-3">
            <label class="form-label" for="basic-default-company">Code</label>
            <select class="form-select" v-model="cupon_id">
                <option selected>Open this select menu</option>
                <option v-for="(p, i) in coupons" :key="i" :value="p.id">{{ p.code }}</option>
            </select>
        </div>
      <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Count</label>
          <input v-model="usage_count" type="text" class="form-control" id="basic-default-fullname"
              placeholder="" />
      </div>
      <button @click="updateUseCount" type="submit" class="btn btn-primary">Submit</button>
  </div>
</template>