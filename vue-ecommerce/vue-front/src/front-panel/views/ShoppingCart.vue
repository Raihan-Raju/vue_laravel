<script>
import axios from "axios";
import { mapState, mapGetters, mapActions } from "vuex";
import Modal from '../fazle/components/Modal.vue';

export default {
  data() {
    return {
      num: 0,
      total: 0,
      coupon_persentage: 0,
      coupon_code: "",
      coupon_info: "",
      pay: 0,
      paymentMethod: "null",
      order_msg: '',
      showModal: false
    };
  },
  props: {
    cartShow: String,
  },
  computed: {
    // Compute the products in the cart from the Vuex store
    productsInCart() {
      return this.$store.state.cart.products;
    },
    userData() {
      return this.$store.state.auth.user;
    },
    ...mapGetters(["totalPrice"]),
    finalTotal() {
      this.total =
        this.totalPrice - this.totalPrice * (this.coupon_persentage / 100);
      return this.total;
    },
  },
  methods: {
    ...mapActions(["incrementQuantity", "decrementQuantity", "clearCart"]),
    applyCoupon() {
      axios
        .post("http://127.0.0.1:8000/api/admin/checkcoupon", {
          code: this.coupon_code,
        })
        .then((response) => {
          this.coupon_persentage = response.data.data.percentage;
          this.coupon_info =
            "Your coupon applied successfully. You have got " +
            this.coupon_persentage +
            "% discount on your products.";
          console.log(response.data.data.percentage);
        })
        .catch((error) => {
          this.coupon_info = "Coupon not found!";
          this.coupon_persentage = 0;
          console.log(error);
        });
    },
    payNext() {
      this.pay++;
      if (this.pay == 4) {
        setTimeout(() => {
          this.pay = 0;
          this.showModal = false;
        }, 10000);
      }
    },
    orderMsg() {
      this.order_msg = "Your Order Placed Successfully!!!",
        setTimeout(() => {
          this.order_msg = '';
        }, 10000);
    },
    storeOrder() {
      const orderData = {
        products: this.productsInCart,
        total_price: this.finalTotal,
        userData: this.userData
      };

      console.log("ok");

      axios
        .post("http://127.0.0.1:8000/api/admin/orders", orderData)
        .then((response) => {
          console.log(response.data.data);
          //this.$router.push({ name: "cartTable" });
        });

      this.orderMsg();

      setTimeout(() => {
        this.clearCart();
        this.$router.push({ name: 'customer' });
      }, 5000);
    },
  },
  watch: {
    paymentMethod(newVal) {
      if (this.paymentMethod === "bkash") {
        this.showModal = true;
        this.pay = 1;
      } else {
        this.showModal = false;
        this.pay = 0
      }
    },
  },
  components: {
    Modal
  },
};
</script>

<template>
  <div>
    <!-- breadcrumb -->
    <div class="container">
      <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
          Home
          <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4"> Shoping Cart </span>
      </div>
    </div>

    <!-- Shoping Cart -->
    <div class="bg0 p-t-75 p-b-85">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            <div class="m-l-25 m-r--38 m-lr-0-xl">
              <div class="wrap-table-shopping-cart">
                <table class="table-shopping-cart">
                  <tr class="table_head">
                    <th class="column-1">Product</th>
                    <th class="column-2"></th>
                    <th class="column-3">Price</th>
                    <th class="column-4">Quantity</th>
                    <th class="column-5">Total</th>
                  </tr>

                  <tr v-for="(p, i) in productsInCart" :key="i" class="table_row">
                    <td class="column-1">
                      <div class="how-itemcart1">
                        <img :src="'http://127.0.0.1:8000/photos/products/' +
                          p.photo.path
                          " alt="IMG" />
                      </div>
                    </td>
                    <td class="column-2">{{ p.name }}</td>
                    <td class="column-3">৳ {{ p.price }}</td>
                    <td class="column-4">
                      <div class="wrap-num-product flex-w m-l-auto m-r-0">
                        <div @click="decrementQuantity(p)" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                          <i class="fs-16 zmdi zmdi-minus"></i>
                        </div>

                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1"
                          :value="p.quantity" />

                        <div @click="incrementQuantity(p)" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                          <i class="fs-16 zmdi zmdi-plus"></i>
                        </div>
                      </div>
                    </td>
                    <td class="column-5">৳ {{ p.price * p.quantity }}</td>
                  </tr>
                </table>
              </div>

              <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                <div class="flex-w flex-m m-r-20 m-tb-5">
                  <input v-model="coupon_code" class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5"
                    type="text" name="coupon" placeholder="Coupon Code" />
                  <div @click="applyCoupon"
                    class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                    Apply coupon
                  </div>
                </div>

                <div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                  Update Cart
                </div>
                <p :class="coupon_info == 'Coupon not found!'
                  ? 'text-danger'
                  : 'text-success'
                  ">
                  {{ coupon_info }}
                </p>
              </div>
            </div>
          </div>

          <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
              <h4 class="mtext-109 cl2 p-b-30">Cart Totals</h4>
              <h1 class="cl2 p-b-30 text-success">{{ order_msg }}</h1>

              <div class="flex-w flex-t bor12 p-b-13">
                <div class="size-208">
                  <span class="stext-110 cl2"> Subtotal: </span>
                </div>

                <div class="size-209">
                  <span class="mtext-110 cl2"> ৳ {{ totalPrice }} </span>
                </div>
              </div>

              <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                <div class="size-208 w-full-ssm">
                  <span class="stext-110 cl2"> Shipping: </span>
                </div>

                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                  <div class="">
                    <div class="bor8 bg0 m-b-12">
                      <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="Phone" />
                    </div>

                    <div class="bor8 bg0 m-b-22">
                      <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode"
                        placeholder="Address" />
                    </div>
                  </div>
                </div>
              </div>
              <!-- this will change -->
              <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                <div class="size-208 w-full-ssm">
                  <span class="stext-110 cl2"> Payment: </span>
                </div>

                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                  <div class="">
                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12">
                      <select v-model="paymentMethod" class="js-select2" name="time">
                        <option value="null">Select a payment method...</option>
                        <option value="bkash">Bkash</option>
                        <option value="cash">Cash On Delivery</option>
                      </select>
                      <div class="dropDownSelect2"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="flex-w flex-t bor12 p-t-15 p-b-30" v-show="pay > 0">
                <img class="img-fluid" src="@/assets/front-assets/images/bkash-payment.png" alt="" />
                <div v-show="pay == 1">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Enter Your Bkash Number:</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
                    <div id="emailHelp" class="form-text">
                      We'll never share your email with anyone else.
                    </div>
                  </div>
                  <button @click="payNext" class="btn btn-primary">Submit</button>
                </div>
                <div v-show="pay == 2">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Enter Your Pin Number:</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
                    <div id="emailHelp" class="form-text">
                      We'll never share your email with anyone else.
                    </div>
                  </div>
                  <button @click="payNext" class="btn btn-primary">Submit</button>
                </div>
                <div v-show="pay == 3">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Enter Amount:</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
                    <div id="emailHelp" class="form-text">
                      We'll never share your email with anyone else.
                    </div>
                  </div>
                  <button @click="payNext" class="btn btn-primary">Submit</button>
                </div>
                <div v-show="pay == 4">
                  <div class="mb-3">
                    <h1 style="
                      color: #f16522;
                      font-family: 'Helvetica Neue', Helvetica, Arial,
                        sans-serif;
                      font-size: 30px;
                      font-weight: 700;
                      line-height: 34px;
                      margin-bottom: 0;
                      margin-top: 0;
                    ">
                      Payment received
                    </h1>
                  </div>
                </div>
              </div> -->

              <!-- ends here -->
              <div class="flex-w flex-t p-t-27 p-b-33">
                <div class="size-208">
                  <span class="mtext-101 cl2"> Total: </span>
                </div>

                <div class="size-209 p-t-1">
                  <span class="mtext-110 cl2"> ৳ {{ finalTotal }} </span>
                </div>
              </div>

              <button @click="storeOrder"
                class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                Proceed to Checkout
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- modal -->
    <Modal :title="'Bkash Payment'" :isVisible="showModal" @close="showModal = false">
      <img class="img-fluid" src="@/assets/front-assets/images/bkash-payment.png" alt="" />
      <div v-show="pay == 1">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Enter Your Bkash Number:</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
        </div>
        <button @click="payNext" class="btn btn-primary">Submit</button>
      </div>
      <div v-show="pay == 2">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Enter Your Pin Number:</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
        </div>
        <button @click="payNext" class="btn btn-primary">Submit</button>
      </div>
      <div v-show="pay == 3">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Enter Amount:</label>
          <input v-model="finalTotal" type="email" class="form-control" id="exampleInputEmail1"
            aria-describedby="emailHelp" readonly />
        </div>
        <button @click="payNext" class="btn btn-primary">Submit</button>
      </div>
      <div v-show="pay == 4">
        <div class="mb-3">
          <h1 style="
                      color: #f16522;
                      font-family: 'Helvetica Neue', Helvetica, Arial,
                        sans-serif;
                      font-size: 30px;
                      font-weight: 700;
                      line-height: 34px;
                      margin-bottom: 0;
                      margin-top: 0;
                    ">
            Payment received
          </h1>
        </div>
      </div>
    </Modal>
    <!-- modal ends here -->
  </div>
</template>
