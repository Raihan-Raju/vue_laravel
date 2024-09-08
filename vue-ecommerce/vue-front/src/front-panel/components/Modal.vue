<script>
import axios from 'axios'
import { mapActions } from 'vuex';
export default {
	data() {
		return {
			product: [],
			mclass: '',
			idx: 0,
			qty: 1,
		}
	},
	props: {
		id: Number,
		url: String,
		modalclass: String
	},
	methods: {
		getProduct() {
			if (this.idx !== 0) {
				axios.get(this.url + 'products/' + this.idx)
					.then((result) => {
						this.product = result.data.data;
						console.log(this.product);
					})
			}
		},
		closeModal() {
			this.mclass = ''
		},
		updateModalClass() {
			this.$emit('update:modalclass', '');
		},

		//add product to cart
		...mapActions({
			addtocart: 'addcart',
		}),
		cartAdd() {
			let productNew = this.product
			productNew.quantity = this.qty
			this.addtocart(productNew)
			this.qty = 1;
			console.log(this.$store.state.cart.products);
			this.closeModal();
		},
		qtyInc() {
			this.qty++;
		},
		qtyDec() {
			this.qty > 1 ? this.qty-- : this.qty;
		}
	},
	mounted() {
		this.getProduct()
	},
	watch: {
		modalclass(newValue) {
			this.mclass = newValue;
			console.log(newValue);
		},
		id(newValue) {
			this.idx = newValue;
			this.getProduct()
		}
	}
}
</script>

<template>
	<div :class="'wrap-modal1 js-modal1 p-t-60 p-b-20' + ' ' + mclass">
		<div class="overlay-modal1 js-hide-modal1"></div>
		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button @click="updateModalClass" class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="@/assets/front-assets/images/icons/icon-close.png" alt="CLOSE">
				</button>

				<div class="row">
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

								<div class="slick3 gallery-lb">
									<div class="item-slick3"
										data-thumb="@/assets/front-assets/images/product-detail-01.jpg">
										<div class="wrap-pic-w pos-relative">
											<img :src="`http://127.0.0.1:8000/photos/products/${product.photo ? product.photo.path : 'no-image.png'}`"
												alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="@/assets/front-assets/images/product-detail-01.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">
							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
								{{ product.name }}
								{{ mclass }}
								{{ id + '' + idx }}
							</h4>

							<span class="mtext-106 cl2">
								{{ product.price }}
							</span>

							<p class="stext-102 cl3 p-t-23">
								{{ product.description }}
							</p>

							<!--  -->
							<div class="p-t-33">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Size
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Size S</option>
												<option>Size M</option>
												<option>Size L</option>
												<option>Size XL</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Color
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Red</option>
												<option>Blue</option>
												<option>White</option>
												<option>Grey</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div @click="qtyDec" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number"
												name="num-product" v-model="qty">

											<div @click="qtyInc" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>

										<button @click="cartAdd"
											class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
											Add to cart
										</button>
									</div>
								</div>
							</div>

							<!--  -->
							<div class="flex-w flex-m p-l-100 p-t-40 respon7">
								<div class="flex-m bor9 p-r-10 m-r-11">
									<a href="#"
										class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
										data-tooltip="Add to Wishlist">
										<i class="zmdi zmdi-favorite"></i>
									</a>
								</div>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Facebook">
									<i class="fa fa-facebook"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Twitter">
									<i class="fa fa-twitter"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Google Plus">
									<i class="fa fa-google-plus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>