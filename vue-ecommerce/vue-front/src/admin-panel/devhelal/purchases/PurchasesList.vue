<script>
import axios from "axios";
import ModalAddPurchasesVue from './ModalAddPurchases.vue';
export default {
  data() {
    return {
      ShowModal: false,
      allPurchases:[],
      url:this.$store.state.base.url+"admin/",
    };
  },
  methods: {
    showf(newValue) {
            this.ShowModal=newValue
        },
    getPurchases(){
      axios.get(this.url+"purchases").then((response) => {
        const alldata= response.data.data;
        this.allPurchases = response.data.data;
              });
    },
    calculateTotalPrice(data) {
    //   for (let i=0; i< data.length; i++){
    console.log(data.price) ;}
    // },
  },
  mounted(){
    this.getPurchases();
    //this.calculateTotalPrice();
  },
components: {
  ModalAddPurchasesVue,
	}
};
</script>
<template>
  
  <div class="container-xxl flex-grow-1 container-p-y">
    <ModalAddPurchasesVue :ShowM="ShowModal" @showfunction="showf"/>
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Purchases/</span> View All Purchases
    </h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Filters</h5>
            <div class="col-md-12 row">
              <div class="col-md-3">
                <select name="" id="" class="form-select">
                  <option value="" selected>📋Created By</option>
                  <option value="">02-01-2024</option>
                  <option value="">02-01-2024</option>
                </select>
              </div>
              <div class="col-md-3">
                <select name="" id="" class="form-select">
                  <option value="" selected>📋Vendor</option>
                </select>
              </div>
              <div class="col-md-3">
                <select name="" id="" class="form-select">
                  <option value="" selected>📋Title</option>
                </select>
              </div>
              <div class="col-md-3">
                <select name="" id="" class="form-select">
                  <option value="" selected>📋Status</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12 row d-flex justify-content-between align-items-center">
            <div class="row">
              <div class="col-md-3">
                <input type="text" class="form-control" placeholder="🔍 Search Purchases" />
              </div>
              <div class="col-md-5"></div>
              <div class="col-md-4">

<!-- ======================== Purchases Modal start========================== -->
<div class="container">
    <button class="btn btn-info" @click="showf">Show Modal</button>
  </div>
<!-- ============================Purchases Modal End ====================== -->
                <button class="col-md-6 btn btn-dark">Export</button>
                <router-link :to="{ name: 'addpurchases'}" class="col-md-6 btn btn-primary">Add Purchases</router-link>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table m-0 table-striped">
              <thead class="bg-info">
                <tr>
                  <th>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    </div>
                  </th>
                  <th>INVOICE</th>
                  <th>CREATED</th>
                  <th>VENDOR</th>
                  <th>TITLE</th>
                  <th>PRICE</th>
                  <th>STATUS</th>
                  <th style="width: 230px" class="text-center">Action</th>
                </tr>
              </thead>
              <!-- <tbody v-for="(data, i) in productlist" :key="i" class="text-center"> -->
              <tbody  class="text-center">
               <tr v-for="(data, i) in allPurchases" :key="i">
                <td>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    </div>
                  </td>
                <td>{{ i }}</td>
                <td>{{ data[0].date}}</td>
                <td>{{ data[0].user.name}}</td>
                <td>For New LL</td>
                <td>{{ calculateTotalPrice(data) }}</td>
                <!-- <td>{{ data}}</td> -->
                <td>6</td>
                <td>7</td>
               </tr>
              </tbody>
            </table>
            <span class="float-right"> </span>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>
