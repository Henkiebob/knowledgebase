var cart = {
   state: {
      products: fetchLocalStorage("cart"),
   },
   setProduct (number,value) {
      console.log('setProduct triggered '+this.state.products);
      // verander de quantity van het product
      this.state.products[number] = value;
      localStorage.setItem("cart", JSON.stringify(this.state.products));
   },
   addProduct (value) {
      console.log('addProduct triggered '+this.state.products);
      //voeg nieuwe product toe
      this.state.products.push(value);
      localStorage.setItem("cart", JSON.stringify(this.state.products));
   },
}
// Functie ophalen van localstorage
function fetchLocalStorage(key) {
   // kijken of localstorage gevuld is met data van de cart.
   if(localStorage.getItem(key)) {
      return JSON.parse(localStorage.getItem(key));
   } else {
      // is het leeg, stuur lege array terug
      return {
         itemTotal:0,
         products: []
      };
   }
}
export default cart;
