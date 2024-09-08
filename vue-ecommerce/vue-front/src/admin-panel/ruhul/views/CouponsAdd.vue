<script>
import axios from "axios";

export default {
  data() {
    return {
      cupons: [],
      code: "",
      percentage: "",
      valid_from: "",
      valid_to: "",
      max_uses: "",
      use_count: "",
    };
  },
  methods: {
    getCupons() {
      axios.get("http://127.0.0.1:8000/api/admin/cupons").then((result) => {
        this.cupons = result.data.data;
        console.log(this.cupons);
      });
    },
    storeCupons() {
      if (this.validateForm()) {
        const cuponsData = {
          code: this.code,
          percentage: this.percentage,
          valid_from: this.valid_from,
          valid_to: this.valid_to,
          max_uses: this.max_uses,
          use_count: this.use_count,
        };

        console.log("ok");

        axios
          .post("http://127.0.0.1:8000/api/admin/cupons", cuponsData)
          .then((response) => {
            console.log(response);
            this.$router.push("/admin/coupons/coupons-list");
          });
      }
    },
    validateCode() {
      return this.code.trim() !== "0";
    },
    validatePercentage() {
      return this.percentage !== "0";
    },
    validateValidFrom() {
      return this.valid_from.trim() !== "0";
    },
    validateValidTo() {
      return this.valid_to.trim() !== "0";
    },
    validateMaxUses() {
      return this.max_uses.trim() !== "0";
    },
    validateUseCount() {
      return this.use_count.trim() !== "0";
    },
    validateForm() {
      return (
        this.validateCode() &&
        this.validatePercentage() &&
        this.validateValidFrom() &&
        this.validateValidTo() &&
        this.validateMaxUses() &&
        this.validateUseCount()
      );
    },
  },
  mounted() {
    this.getCupons();
  },
};
</script>

<template>
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Add Coupons</h5>
  </div>
  <div class="card-body">
    <div class="mb-3">
      <label class="form-label" for="basic-default-fullname">Code</label>
      <input
        v-model="code"
        type="text"
        class="form-control"
        id="basic-default-fullname"
        placeholder="Coupon code here"
        :class="{ 'is-invalid': !validateCode() }"
      />
      <span v-if="!validateCode()" class="invalid-feedback"
        >Code is required</span
      >
    </div>
    <div class="mb-3">
      <label class="form-label" for="basic-default-fullname">Percentage</label>
      <input
        v-model="percentage"
        type="number"
        class="form-control"
        id="basic-default-fullname"
        placeholder="Percentage"
        :class="{ 'is-invalid': !validatePercentage() }"
      />
      <span v-if="!validatePercentage()" class="invalid-feedback"
        >Percentage is required</span
      >
    </div>
    <div class="mb-3">
      <label class="form-label" for="valid-from">Valid From</label>
      <input
        v-model="valid_from"
        type="datetime-local"
        class="form-control"
        id="valid-from"
        placeholder="YYYY-MM-DD"
        :class="{ 'is-invalid': !validateValidFrom() }"
      />
      <span v-if="!validateValidFrom()" class="invalid-feedback"
        >Valid from date is required</span
      >
    </div>
    <div class="mb-3">
      <label class="form-label" for="valid-to">Valid To</label>
      <input
        v-model="valid_to"
        type="datetime-local"
        class="form-control"
        id="valid-to"
        placeholder="YYYY-MM-DD"
        :class="{ 'is-invalid': !validateValidTo() }"
      />
      <span v-if="!validateValidTo()" class="invalid-feedback"
        >Valid to date is required</span
      >
    </div>

    <div class="mb-3">
      <label class="form-label" for="basic-default-fullname">Max Uses</label>
      <input
        v-model="max_uses"
        type="text"
        class="form-control"
        id="basic-default-fullname"
        placeholder="Max uses"
        :class="{ 'is-invalid': !validateMaxUses() }"
      />
      <span v-if="!validateMaxUses()" class="invalid-feedback"
        >Max uses is required</span
      >
    </div>
    <div class="mb-3">
      <label class="form-label" for="basic-default-fullname">Use Count</label>
      <input
        v-model="use_count"
        type="text"
        class="form-control"
        id="basic-default-fullname"
        placeholder="Use count"
        :class="{ 'is-invalid': !validateUseCount() }"
      />
      <span v-if="!validateUseCount()" class="invalid-feedback"
        >Use count is required</span
      >
    </div>
    <button @click="storeCupons" type="submit" class="btn btn-primary">
      Submit
    </button>
  </div>
</template>


