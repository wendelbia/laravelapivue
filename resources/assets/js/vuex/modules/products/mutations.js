export default {
	//chamo o mutation de:LOAD_PRODUCT, chamo a state e products que estão todos ligados em products.js
	LOAD_PRODUCTS (state, products) {
		state.items = products
	}
}